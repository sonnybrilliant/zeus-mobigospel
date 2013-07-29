/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package org.mobilitate.hermes.client;

import com.rabbitmq.client.Channel;
import com.rabbitmq.client.Connection;
import com.rabbitmq.client.ConnectionFactory;
import com.rabbitmq.client.ShutdownListener;
import com.rabbitmq.client.ShutdownSignalException;
import java.io.IOException;

/**
 *
 * @author ronald
 */
public class Globals {

    public static Connection conn;
    public static Channel channel;
    public static volatile boolean isHigateConnected = false;
    public static volatile boolean isEmailSent = false;
    public static Higate higate;
    
    public static void connect() {

        while (!Main.isAmqpConnected) {
            ConnectionFactory cf = new ConnectionFactory();
            cf.setHost(Config.RabbitMQHost);
            cf.setUsername(Config.RabbitMQUserName);
            cf.setPassword(Config.RabbitMQPassword);
            cf.setVirtualHost(Config.RabbitMQVirtualHost);
            cf.setPort(Config.RabbitMQPort);
            try {
                conn = cf.newConnection();
                channel = conn.createChannel();
                Main.isAmqpConnected = true;
                conn.addShutdownListener(new ShutdownListener() {
                    @Override
                    public void shutdownCompleted(ShutdownSignalException cause) {
                        Main.isAmqpConnected = false;
                    }
                });


            } catch (IOException ex) {
                //stop higate connection
                System.out.println("========================================");
                System.out.println("Failed to establish connection to host");
                System.out.println("connection details:");
                System.out.println("hostname:" + Config.RabbitMQHost);
                System.out.println("username:" + Config.RabbitMQUserName);
                System.out.println("password:" + Config.RabbitMQPassword);
                System.out.println("port:" + Config.RabbitMQPort);
                System.out.println("virtualhost:" + Config.RabbitMQVirtualHost);
                System.out.println("Error Messgae:" + ex.getMessage());
                System.out.println("\n\n");

            }
        }
    }

    public static Connection getConnection() {

        while (!conn.isOpen()) {
            connect();
        }

        return conn;
    }

    public static Channel getChannel() {

        while (!conn.isOpen()) {
            connect();
        }

        return channel;
    }

    public static void stop() {
        if (Main.isAmqpConnected) {
            try {
                channel.close();
                conn.close();
            } catch (IOException ex) {
                ex.printStackTrace();
            }
        }
    }
}
