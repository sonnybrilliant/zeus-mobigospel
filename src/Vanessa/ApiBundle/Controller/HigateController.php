<?php

namespace Vanessa\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Vanessa\CoreBundle\Entity\Rxqueue;

/**
 * Higate manager 
 * 
 * @author Mfana Ronald Conco <ronald.conco@mobigospel.co.za>
 * @package VanessaApiBundle
 * @subpackage Controller
 * @version 0.0.1
 */
class HigateController extends Controller
{

    /**
     * Incoming sms
     * 
     * @param string $msisdn
     * @param string $serviceCode
     * @param string $message
     * @param string $value
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function incomingAction($msisdn = '', $message = '', $network = '', $toAddress = '', $seqno = '')
    {
        $this->get('logger')->info("incoming sms, msisdn:$msisdn - message:$message ");

        $results = new \stdClass;

        $results->msisdn = $msisdn;
        $results->content = $message;


        try {
            $results->status = "success";
            $rxqueue = new Rxqueue();
            $rxqueue->setMsisdn($msisdn);
            $rxqueue->setBody(urldecode($message));
            $rxqueue->setNetwork($network);
            $rxqueue->setToAddress($toAddress);
            $rxqueue->setSeqno($seqno);
            $rxqueue->setStatus($this->get('status.manager')->pending());
            $this->get('rxqueue.manager')->create($rxqueue);
            $results->rxqueue = $rxqueue->getId();
        } catch (\Exception $e) {
            $results->status = "error";
            $results->error = $e->getMessage();
            $this->get('notification.manager')->smsIncoming($results);
            $msg = array('msisdn' => $results->msisdn, 'content' => $results->content, 'error' => $e->getMessage(), 'key' => 'sms.incoming');
            $this->get('old_sound_rabbit_mq.sms_error_producer')->publish(serialize($msg), 'sms.higate.error');
        }

        $response = new Response(json_encode($results));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * Process transaction
     * 
     * @param integer $rxqueue
     * @param string $msisdn
     * @param string $message
     * 
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function purchaseAction($rxqueue = "", $msisdn = "", $message = "")
    {
        $this->get('logger')->info("sms purchase , rxqueue:$rxqueue ");

        $results = new \stdClass;

        $results->rxqueue = $rxqueue;
        $results->msisdn = $msisdn;
        $results->content = $message;

        try {
            $rxqueue =  $this->get('rxqueue.manager')->getById($rxqueue);
            $download = $this->get('transaction.manager')->process($rxqueue);
            $results->status = "success";
            
        } catch (\Exception $e) {
            $results->status = "error";
            $results->error = $e->getMessage();
            $this->get('notification.manager')->smsIncoming($results);
            $msg = array('rxqueue' => $rxqueue, 'error' => $e->getMessage(), 'key' => 'sms.incoming');
            $this->get('old_sound_rabbit_mq.sms_error_producer')->publish(serialize($msg), 'sms.higate.error');
        }

        $response = new Response(json_encode($results));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
    
    /**
     * Update sms status
     * 
     * @param type $refno
     * @param type $seqno
     * @param type $subcode
     * 
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function statusUpdateAction($refno, $seqno ,$subcode)
    {
        $this->get('logger')->info("sms status update "); 
        
        $results = new \stdClass;
        
        try {
            
            $this->get('txqueue.manager')->statusUpdate($refno, $seqno, $subcode);
            $results->status = "success";
            
        } catch (\Exception $e) {
            $results->status = "error";
            $results->error = $e->getMessage();
            $this->get('notification.manager')->smsIncoming($results);
            $msg = array('refcode' => $refno,'seqno' => $seqno ,'code' => $subcode, 'error' => $e->getMessage(), 'key' => 'sms.status');
            $this->get('old_sound_rabbit_mq.sms_error_producer')->publish(serialize($msg), 'sms.higate.error');
        }
        
        $response = new Response(json_encode($results));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
        
    }

}
