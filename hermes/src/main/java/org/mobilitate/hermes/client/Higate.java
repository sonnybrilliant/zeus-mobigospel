/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package org.mobilitate.hermes.client;

import com.google.gson.Gson;
import com.integrat.higate.HigateException;
import com.integrat.higate.HigateV200;
import org.apache.log4j.Logger;
import org.apache.log4j.PropertyConfigurator;
import org.mobilitate.hermes.template.SMSAlert;
import org.mobilitate.hermes.template.SMSIncoming;


/**
 * @author ronald
 */
public class Higate implements HigateV200.EventHandler {

    public static boolean isConnected = false;
    private String username = Config.HigateUserName;
    private String password = Config.HigatePassword;
    private String config = null;
    private boolean terminated = false;
    private HigateV200 higate = null;
    private Logger logger;

    public Higate() {
        PropertyConfigurator.configure(Config.Log4jPath);
        logger = Logger.getLogger(Higate.class.getName());


        this.config =
                "<Higate>"
                        + "<Client Name='" + Config.HigateUserName + "'>"
                        + "  <Mode>" + Config.HigateMode + "</Mode>"
                        + "  <Gateway>Higate</Gateway>"
                        + "  <Log>" + Config.HigateLogPath + "%y%m%d_%N.log</Log>"
                        + "  <Trace>127.0.0.1:58000</Trace>"
                        + "  <EnableSSL>False</EnableSSL>"
                        + "  <EnableBeeps>False</EnableBeeps>"
                        + "  <EnableLogEvents>True</EnableLogEvents>"
                        + "  <AdultRating>2</AdultRating>"
                        + "  <TxWindowSize>8</TxWindowSize>"
                        + "  <EnableMonitor>False</EnableMonitor>"
                        + "  <Monitor>127.0.0.1:45000</Monitor>"
                        + "  <EventMask>1</EventMask>"
                        + "</Client>"
                        + "<Gateway Name='Higate'>"
                        + "  <EnableSSL>False</EnableSSL>"
                        + "  <AddressList>"
                        + "    <Address>" + Config.HigateServer + ":" + Config.HigatePort + "</Address>"
                        + "  </AddressList>"
                        + "</Gateway>"
                        + "</Higate>";

        //start higate connection
        logger.info("Initialize Higate...");
        this.higate = new HigateV200(this);
    }

    public void start() {
        int counter = 1;
        Globals.isEmailSent = false;

        while (!Globals.isHigateConnected) {

            if (counter < 1000) {
                logger.info("Logging on as ..." + this.username+"\tattempt no:"+counter);
                higate.logon(config, username, password);

            } else {
                try {
                    Thread.sleep(10000);
                } catch (InterruptedException ex) {
                    logger.error(ex);
                }
                counter = 1;
            }
            counter++;
        }
    }

    public void onHigateConnect(HigateV200 higate) {
        Globals.isHigateConnected = true;
        logger.info("Higate Connected Successfully...");
        Emailer.onStart(Config.serverName);

    }

    public void onHigateDisconnect(HigateV200 higate) {
        Globals.isHigateConnected = false;
        logger.error("Higate Disconnected.....");
        higate.logoff();

        try {
            Thread.sleep(10000);
        } catch (InterruptedException ex) {
            logger.error(ex);
        }

        if (!Globals.isEmailSent) {
            Emailer.onDisconnect(Config.serverName );
            Globals.isEmailSent = true;
        }

        this.start();
    }

    public void onHigateBeforeLogon(HigateV200 higate) {
        logger.info("OnHigateBefore Logon....");

        try {
            higate.param("EventMask").set(0);
            higate.param("ByteStuff").set(false);
            higate.param("EnableCreditAlarms").set(true);
            higate.param("TimeDeltaMax").set(180);
            logger.info("Higate Parameters: EventMask:0");
            logger.info("Higate Parameters: ByteStuff:false");
            logger.info("Higate Parameters: EnableCreditAlarms:true");
            logger.info("Higate Parameters: TimeDeltaMax:180 secods");
        } catch (HigateException e) {
            logger.error("onHigateBefore Logon error:" + e.getMessage());
        }
    }

    public void onHigateCreditAlarm(HigateV200 higate, long accBalance, long accCreditLimit, long accAlarmLevel) {
        logger.info("CreditAlarm Balance:" + accBalance + "\tCreditLimit:" + accCreditLimit + "\tAlarmLevel:" + accAlarmLevel);
    }

    public void onHigateError(HigateV200 higate, int errorCode, String errorText) {
        //check errors

        logger.error("onHigateError code:" + errorCode + " - <" + errorText + ">");
    }

    public void onHigateLog(HigateV200 higate, boolean fromApp, long threadID, int logType, String text) {
        logger.info("transaction \tLogType:" + logType + "\tText:" + text);

        if(text == "Disconnected"){
          higate.logoff();
        }
    }

    public void onHigateReceive(HigateV200 higate, int toc, long seqNo, int flags, String fromAddr, String toAddr, byte[] data) {
        try {
            SMSIncoming sms = new SMSIncoming();
            sms.setContent(new String(data));
            sms.setMsisdn(fromAddr);
            sms.setSeqNumber(seqNo);
            sms.setNetworkId(higate.param("Receive.NetworkID").asLong());
            sms.setToAddress(toAddr);

            Gson json = new Gson();
            synchronized (this) {
                Main.QIncoming.add(json.toJson(sms));
            }

            logger.info("onHigateReceive SMS msisdn:" + fromAddr + "\tmessage:" + new String(data));

        } catch (Exception e) {
            logger.error("onHigateReceive SMS:" + e.getMessage());
        }
    }

    public void onHigateResult(HigateV200 higate, int toc, long seqNo, long refNo, int flags, int resultCode, int subCode) {
        try {
            SMSAlert sms = new SMSAlert();
            sms.setSeqNumber(seqNo);
            sms.setRefNumber(refNo);
            sms.setRefCode(resultCode);
            //sms.setMessage();

            Gson json = new Gson();
            synchronized (this) {
                Main.QAlert.add(json.toJson(sms));
            }

            logger.info("onHigateResult refno:" + refNo + "\tseqno:" + seqNo + "\trefcode:" + resultCode+ "\tsubcode:"+subCode);
        } catch (Exception e) {
            logger.error("onHigateResult " + e.getMessage());
        }
    }

    public boolean onHigateStream(HigateV200 higate, long refNo, String action, String name, String type, int flags, int index, int size, String buffer, int bufferSize) {
        logger.info("onHigateStream " + action);
        return false;
    }

    public void onHigateDialogue(HigateV200 hv, int i, int i1, int i2, String string, String string1, String string2) {
        throw new UnsupportedOperationException("Not supported yet.");
    }

    public void sendSMS(int refNo, String recipient, String message) {
        logger.info("onHigateSMSSend refno:" + refNo + "\tmsisdn:" + recipient + "\t tag:"+Config.HigateTag  + "\tmessage:" + message);
        higate.send(refNo, HigateV200.TOC_SMS, recipient, Config.HigateTag, 0, message);
    }
}
