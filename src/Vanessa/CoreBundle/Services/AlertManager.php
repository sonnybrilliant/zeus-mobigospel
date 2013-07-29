<?php

namespace Vanessa\CoreBundle\Services;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Monolog\Logger;
use Vanessa\CoreBundle\Entity\Messages;
use Vanessa\CoreBundle\Dictionary\StaticData\Alert;

/**
 * Alert manager
 *
 * @author Mfana Ronald Conco <ronald.conco@mobigospel.co.za>
 * @version 0.0.1
 * @package VanessaSongBundle
 * @subpackage Services
 */
final class AlertManager
{

    /**
     * Service Container
     * @var object
     */
    private $container = null;

    /**
     * Monolog logger
     * @var object
     */
    private $logger = null;

    /**
     * Entity manager
     * @var object
     */
    private $em;

    /**
     * Class construct
     *
     * @param  ContainerInterface $container
     * @param  Logger             $logger
     * @return void
     */
    public function __construct(
    ContainerInterface $container, Logger $logger)
    {
        $this->setContainer($container);
        $this->setLogger($logger);
        $this->setEm($container->get('doctrine')->getManager('default'));

        return;
    }

    public function getContainer()
    {
        return $this->container;
    }

    public function setContainer($container)
    {
        $this->container = $container;
    }

    public function getLogger()
    {
        return $this->logger;
    }

    public function setLogger($logger)
    {
        $this->logger = $logger;
    }

    public function getEm()
    {
        return $this->em;
    }

    public function setEm($em)
    {
        $this->em = $em;
    }

    /**
     * Get active member messages
     * 
     * @return array
     */
    public function getUserMessages()
    {
        $member = $this->container->get('member.manager')->getActiveUser();

        $options['user'] = $member;

        $messages = $this->em
            ->getRepository('VanessaCoreBundle:Messages')
            ->getAllMemberMessages($options);

        $this->updateAsRead($messages);
        return $messages;
    }

    /**
     * Create info alert
     * 
     * @param string $content
     * @param string $recipient
     * @return type
     */
    public function info($content, $recipient = null)
    {
        $this->logger->info('add info alert');

        if (is_null($recipient)) {
            $recipient = $this->container->get('member.manager')->getActiveUser();
        }

        $message = new Messages();

        $expireDate = new \DateTime();
        $expireDate->add(new \DateInterval('P1D'));

        $message->setContent($content);
        $message->setRecipient($recipient);
        $message->setMessageType($this->container->get('message.type.manager')->info());
        $message->setExpiredAt($expireDate);
        $this->save($message);
        return;
    }

    /**
     * Create error alert
     * 
     * @param string $content
     * @param string $recipient
     * @return type
     */
    public function error($content, $recipient = null)
    {
        $this->logger->info('add error alert');

        if (is_null($recipient)) {
            $recipient = $this->container->get('member.manager')->getActiveUser();
        }

        $message = new Messages();

        $expireDate = new \DateTime();
        $expireDate->add(new \DateInterval('P1D'));

        $message->setContent($content);
        $message->setRecipient($recipient);
        $message->setMessageType($this->container->get('message.type.manager')->error());
        $message->setExpiredAt($expireDate);
        $this->save($message);
        return;
    }

    /**
     * Create success alert
     * 
     * @param string $content
     * @param string $recipient
     * @return type
     */
    public function success($content, $recipient = null)
    {
        $this->logger->info('add success alert');

        if (is_null($recipient)) {
            $recipient = $this->container->get('member.manager')->getActiveUser();
        }

        $message = new Messages();

        $expireDate = new \DateTime();
        $expireDate->add(new \DateInterval('P1D'));

        $message->setContent($content);
        $message->setRecipient($recipient);
        $message->setMessageType($this->container->get('message.type.manager')->success());
        $message->setExpiredAt($expireDate);
        $this->save($message);
        return;
    }

    /**
     * Create warning alert
     * 
     * @param string $content
     * @param string $recipient
     * @return type
     */
    public function warning($content, $recipient = null)
    {
        $this->logger->info('add warning alert');

        if (is_null($recipient)) {
            $recipient = $this->container->get('member.manager')->getActiveUser();
        }

        $message = new Messages();

        $expireDate = new \DateTime();
        $expireDate->add(new \DateInterval('P1D'));

        $message->setContent($content);
        $message->setRecipient($recipient);
        $message->setMessageType($this->container->get('message.type.manager')->warning());
        $message->setExpiredAt($expireDate);
        $this->save($message);
        return;
    }

    /**
     * Create general alert
     * 
     * @param string $content
     * @param string $recipient
     * @return type
     */
    public function general($content, $recipient = null)
    {
        $this->logger->info('add general alert');

        if (is_null($recipient)) {
            $recipient = $this->container->get('member.manager')->getActiveUser();
        }

        $message = new Messages();

        $expireDate = new \DateTime();
        $expireDate->add(new \DateInterval('P1D'));

        $message->setContent($content);
        $message->setRecipient($recipient);
        $message->setMessageType($this->container->get('message.type.manager')->general());
        $message->setExpiredAt($expireDate);
        $this->save($message);
        return;
    }

    /**
     * Save new message
     * 
     * @param VanessaCoreBundle:Message $message
     * @return void
     */
    public function save($message)
    {
        $this->em->persist($message);
        $this->em->flush();
        return;
    }
    
    /**
     * Send alert to all admins
     * 
     * @param integer $alertType
     * @param string $message
     * @return void
     */
    public function admins($alertType, $message)
    {
        $this->logger->info("send alert to all admin");

        $members = $this->getContainer()->get('member.manager')->getAllAdmin();
        if ($members) {
            foreach ($members as $member) {
                if($member->getId() != $this->container->get('member.manager')->getActiveUser()->getId()){
                    if($alertType == Alert::$info){
                        $this->info($message, $member);
                    }else if($alertType == Alert::$warning){
                        $this->warning($message, $member);
                    }else if($alertType == Alert::$error){
                        $this->error($message, $member);
                    }else if($alertType == Alert::$success){
                        $this->success($message, $member);
                    }else{
                       $this->general($message, $member);  
                    }
                }
            }            
        }
        
        return;
    }

    /**
     * Update messages  as read
     * 
     * @param Array $messages
     * @return void
     */
    public function updateAsRead($messages)
    {
        foreach ($messages as $message) {
            $message->setIsRead(true);
            $this->em->persist($message);
        }

        $this->em->flush();
        return;
    }

}
