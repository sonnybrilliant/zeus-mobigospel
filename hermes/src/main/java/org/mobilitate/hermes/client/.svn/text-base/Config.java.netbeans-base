/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package org.mobilitate.hermes.client;

import java.io.FileInputStream;
import java.io.IOException;
import java.util.Properties;

/**
 *
 * @author ronald
 */
public class Config {

//    public static String HigateUserName              = "kaizstg";
//    public static String HigatePassword              = "GJ8Qxw";
//    public static String HigateServiceCode           = "KAISTG";
//    public static String HigateTag                   = "333";
//    public static String HigateServer                = "higate1.integrat.co.za";
//    public static int    HigatePort                  = 5075;
//    public static String HigateMode                  = "LIVE";
    public static String HigateUserName              = "kaizatcpip";
    public static String HigatePassword              = "sXTxC5";
    public static String HigateServiceCode           = "KAITCPIP";
    public static String HigateTag                   = "0112";
    public static String HigateServer                = "higatesimbox.integrat.co.za";
    public static int    HigatePort                  = 50101;
    public static String HigateMode                  = "SIM";
    public static String HigateLogPath               = "/home/ronald/Java projects/java/RabbitMQConcurrentClient/log/";
    
    public static String RabbitMQHost                = "localhost";
    public static String RabbitMQUserName            = "admin";
    public static String RabbitMQPassword            = "4Micha";
    public static String RabbitMQVirtualHost         = "mobilitate";
    public static int    RabbitMQPort                = 5672;

    public static String RabbitMQExchange            = "SMS";
    public static String RabbitMQOutgoingQueue       = "smsOutgoing";
    public static String RabbitMQOutgoingKey         = "sms.outgoing";
    public static String RabbitMQIncomingQueue       = "smsIncoming";
    public static String RabbitMQIncomingKey         = "sms.incoming";
    public static String RabbitMQIncomingAlertQueue  = "smsStatusUpdate";
    public static String RabbitMQIncomingAlertKey    = "sms.statusUpdate";

    public static String Log4jPath                   = "/home/ronald/Java projects/java/RabbitMQConcurrentClient/log4j.properties";

    public static String serverName                  = "localhost";
    public static String email                       = "ronald.conco@kaizania.co.za";

    
    public static void init(String path) {
        //read config file
        Properties pr = new Properties();
        try {
            pr.load(new FileInputStream(path));

            HigateUserName             = pr.getProperty("higate.username");
            HigatePassword             = pr.getProperty("higate.password");
            HigateServer               = pr.getProperty("higate.server");
            HigateTag                  = pr.getProperty("higate.tag");
            HigatePort                 = Integer.parseInt(pr.getProperty("higate.port"));
            HigateMode                 = pr.getProperty("higate.mode");
            HigateLogPath              = pr.getProperty("log.path");
            HigateServiceCode          = pr.getProperty("higate.servicecode");


            RabbitMQHost               = pr.getProperty("rabbitmq.server");
            RabbitMQUserName           = pr.getProperty("rabbitmq.username");
            RabbitMQPassword           = pr.getProperty("rabbitmq.password");
            RabbitMQVirtualHost        = pr.getProperty("rabbitmq.virtualhost");
            RabbitMQPort               = Integer.parseInt(pr.getProperty("rabbitmq.port"));

            RabbitMQExchange           = pr.getProperty("rabbitmq.exchange");
            RabbitMQOutgoingQueue      = pr.getProperty("rabbitmq.queueoutgoing");
            RabbitMQOutgoingKey        = pr.getProperty("rabbitmq.queueoutgoingkey");
            RabbitMQIncomingQueue      = pr.getProperty("rabbitmq.queueincoming");
            RabbitMQIncomingKey        = pr.getProperty("rabbitmq.queueincomingkey");
            RabbitMQIncomingAlertQueue = pr.getProperty("rabbitmq.queueincomingalert");
            RabbitMQIncomingAlertKey   = pr.getProperty("rabbitmq.queueincomingalertkey");

            Log4jPath                  = pr.getProperty("log.log4j");
            serverName                 = pr.getProperty("server.name");
            email                      = pr.getProperty("server.email");
        } catch (IOException e) {
            e.printStackTrace();
        }
    }

 
    
}
