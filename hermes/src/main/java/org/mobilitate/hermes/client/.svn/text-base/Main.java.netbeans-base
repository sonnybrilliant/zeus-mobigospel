package org.mobilitate.hermes.client;


import java.util.ArrayList;
import java.util.List;
import java.util.concurrent.Executors;
import java.util.concurrent.ScheduledExecutorService;
import java.util.concurrent.ScheduledFuture;
import java.util.concurrent.TimeUnit;
import org.apache.log4j.Logger;
import org.apache.log4j.PropertyConfigurator;



/**
 * Hello world!
 *
 */
public class Main
{
    private ScheduledExecutorService scheduler;
    private static int NUM_THREADS = 1;
    public volatile static boolean isAmqpConnected = false;
    public static List<String> QOutgoing = new ArrayList<String>();
    public static List<String> QIncoming = new ArrayList<String>();
    public static List<String> QAlert    = new ArrayList<String>();
    private Logger logger;

    public static void main( String[] args )
    {
        String s = args[0];

        if(!s.isEmpty()){
          Config.init(args[0]);
        }

        PropertyConfigurator.configure(Config.Log4jPath);
        System.out.println( "Starting Hermes...." );
        Main app = new Main();
    }

    public Main(){
        scheduler = Executors.newScheduledThreadPool(NUM_THREADS);
        Higate hg = new Higate();
        hg.start();

        //pass higate instance
        Globals.higate = hg;
        
        Consumer consumer = new Consumer();
        Producer produce  = new Producer();
        ScheduledFuture futureConsumer = scheduler.scheduleAtFixedRate(consumer, 10, 10, TimeUnit.SECONDS);
        ScheduledFuture futureProducer = scheduler.scheduleAtFixedRate(produce, 15, 10, TimeUnit.SECONDS);


    }

}
