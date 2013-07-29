<?php

namespace Vanessa\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;



/**
 * Alert manager 
 * 
 * @author Mfana Ronald Conco <ronald.conco@mobigospel.co.za>
 * @package VanessaCoreBundle
 * @subpackage Controller
 * @version 0.0.1
 */
class AlertController extends Controller
{

    /**
     * create a new artist
     * 
     * @return Response
     * 
     */
    public function getMessagesAction()
    {
        $this->get('logger')->info('get message for user');
        $messages = $this->get('alert.manager')->getUserMessages();
        $results = array();
        foreach($messages as $message){
           $results[] = array(
               'content' => $message->getContent(), 
               'type' => $message->getMessageType()->getId()
           ); 
        }
            
        $response = array("code" => 100 ,"count" => sizeof($results) ,  "messages" => $results);
        //you can return result as JSON
        return new Response(json_encode($response));
    }

}
