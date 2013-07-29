/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package org.mobilitate.hermes.client;

import com.rabbitmq.client.Channel;
import com.rabbitmq.client.Connection;
import com.rabbitmq.client.ConsumerCancelledException;
import com.rabbitmq.client.GetResponse;
import com.rabbitmq.client.QueueingConsumer;
import com.rabbitmq.client.ShutdownSignalException;
import java.io.IOException;
import org.apache.log4j.Logger;
import org.apache.log4j.PropertyConfigurator;

/**
 *
 * @author ronald
 */
public class Consumer implements Runnable {

    private Channel channel;
    private QueueingConsumer consumer;
    private Connection conn;
    private boolean terminate = false;
    private Logger logger;

    public Consumer() {

        PropertyConfigurator.configure(Config.Log4jPath);
        logger = Logger.getLogger(Consumer.class.getName());

        try {
            //check connection
            this.checkConnection();

            channel.exchangeDeclare(Config.RabbitMQExchange, "direct", true);
            channel.queueDeclare(Config.RabbitMQOutgoingQueue, true, false, false, null);
            channel.queueBind(Config.RabbitMQOutgoingQueue, Config.RabbitMQExchange, Config.RabbitMQOutgoingKey);
            consumer = new QueueingConsumer(channel);
            channel.basicQos(1);
            //channel.basicConsume(Config.RabbitMQOutgoingQueue, true, consumer);
        } catch (IOException ex) {
            logger.error("Failed starting consumer");
            logger.error(ex.getMessage());
        }
    }

    private void checkConnection() {
        Globals.connect();
        conn = Globals.getConnection();
        channel = Globals.getChannel();
    }

    public void run() {

        //check connection
        this.checkConnection();

        if (Globals.isHigateConnected) {
            int counter = 1;

            while (true) {
                try {

                    GetResponse response = channel.basicGet(Config.RabbitMQOutgoingQueue, false);
                    if (!terminate) {
                        if (response != null) {
                            String msg = new String(response.getBody());
                            long deliveryTag = response.getEnvelope().getDeliveryTag();
                            logger.info("onRabbitMQConsume message id:"+counter);
                            synchronized (this) {
                                Main.QOutgoing.add(msg);
                            }
                            
                            channel.basicAck(deliveryTag, false);
                            counter++;

                            if (counter >= 1000) {
                                terminate = true;
                            }
                        } else {
                            logger.info("onRabbitMQConsume messages[0]");
                            terminate = false;
                            break;
                        }
                    }else{
                        terminate = false;
                        break;
                    }

                } catch (ShutdownSignalException ex) {
                    logger.error(ex.getMessage());
                    break;
                } catch (ConsumerCancelledException ex) {
                    logger.error(ex.getMessage());
                    break;
                } catch (IOException ex) {
                    logger.error(ex.getMessage());
                    break;
                }
            }
        }else{
            logger.error("onRabbitMQConsume Higate is not connected");
        }
    }
}
