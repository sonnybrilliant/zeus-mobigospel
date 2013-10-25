<?php

namespace Vanessa\TransactionBundle\Services;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Monolog\Logger;
use Vanessa\CoreBundle\Entity\Txqueue;

/**
 * Txqueue manager
 *
 * @author Ronald Conco <ronald.conco@gmail.com>
 * @version 1.0
 * @package SuleTransactionBundle
 * @subpackage Services
 */
final class TxqueueManager {

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
     * @param ContainerInterface $container
     * @param Logger $logger
     * @return void 
     */
    public function __construct(
    ContainerInterface $container, Logger $logger) {
        $this->setContainer($container);
        $this->setLogger($logger);
        $this->setEm($container->get('doctrine')->getManager('default'));
        return;
    }

    public function getContainer() {
        return $this->container;
    }

    public function setContainer($container) {
        $this->container = $container;
    }

    public function getLogger() {
        return $this->logger;
    }

    public function setLogger($logger) {
        $this->logger = $logger;
    }

    public function getEm() {
        return $this->em;
    }

    public function setEm($em) {
        $this->em = $em;
    }

    /**
     * Get Txqueue by id
     * 
     * @param integer $id
     * @return VanessaCoreBundle:Txqueue
     * @throws \Exception 
     */
    public function getById($id) {
        $txqueue = $this->em->getRepository('VanessaCoreBundle:Txqueue')
                ->find($id);

        if (!$txqueue) {
            throw new \Exception('Txqueue not found for id:' . $id);
            $this->logger->err('Failed to find Txqueue by id:' . $id);
        }
        return $txqueue;
    }

    /**
     * Get all txqueue query
     * 
     * @param array $options
     * @return query
     */
    public function listAll($options = array()) {
        $this->logger->info('get all txqueues');
        $status = "";

        if (isset($options['filterBy'])) {
            if ($options['filterBy'] != '0') {
                $status = $this->getContainer()->get('status.manager')->getStatusByName($options['filterBy']);
                if ($status) {
                    $options['status'] = $status;
                }
            }
        }

        $member = $this->getContainer()->get('member.manager')->getActiveUser();

        $options['user'] = $member;

        return $this->em
                        ->getRepository('VanessaCoreBundle:Txqueue')
                        ->getAllTxqueueQuery($options);
    }

    /**
     * Get all inbound sms query
     * 
     * @param array $options
     * @return query
     */
    public function getAll($options = array()) {
        $this->logger->info('get all inbound sms');

        $member = $this->getContainer()->get('member.manager')->getActiveUser();

        $options['user'] = $member;

        return $this->em
                        ->getRepository('VanessaCoreBundle:Rxqueue')
                        ->getAllQuery($options);
    }

    /**
     * Save txqueue
     * 
     * @param stdClass $params
     * @return \Vanessa\CoreBundle\Entity\Txqueue
     */
    public function saveNew($params) {
        $this->logger->info('save txqueue data');

        $txqueue = new Txqueue();
        $txqueue->setBody($params->body);
        $txqueue->setMsisdn($params->msisdn);
        $txqueue->setRxqueue($params->rxqueue);
        $txqueue->setIsValid($params->isValid);
        $txqueue->setNetwork($params->network);
        $txqueue->setStatus($this->container->get('status.manager')->queued());

        $this->em->persist($txqueue);
        $this->em->flush();
        return $txqueue;
    }
    
    /**
     * Update status
     * 
     * @param integer $seqno
     * @param integer $refno
     * @param integer $subcode
     * @return \Vanessa\CoreBundle\Entity\Txqueue
     */
    public function statusUpdate($refno, $seqno  = "", $subcode = "") {
        $this->logger->info("status update");

        $txqueue = $this->getById($refno);

        $txqueue->setSeqno($seqno);
        $txqueue->setRefcode($subcode);

        if ($subcode == 1) {
            $txqueue->setStatus($this->container->get('status.manager')->queued());
        } elseif ($subcode == 2) {
            $txqueue->setStatus($this->container->get('status.manager')->submitted());
        } elseif($subcode == 3){
           $txqueue->setStatus($this->container->get('status.manager')->acknowledged()); 
        } elseif($subcode == 4){
           $txqueue->setStatus($this->container->get('status.manager')->receipted());    
        } elseif($subcode == 5){
           $txqueue->setStatus($this->container->get('status.manager')->expired()); 
        } else {
           $txqueue->setStatus($this->container->get('status.manager')->error()); 
        }

        $this->em->persist($txqueue);
        $this->em->flush();
        return $txqueue;
    }

}