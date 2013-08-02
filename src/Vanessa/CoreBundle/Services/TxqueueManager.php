<?php

namespace Sule\TransactionBundle\Services;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Monolog\Logger;
use Sule\CoreBundle\Entity\Txqueue;

/**
 * Txqueue manager
 *
 * @author Ronald Conco <ronald.conco@gmail.com>
 * @version 1.0
 * @package SuleTransactionBundle
 * @subpackage Services
 */
final class TxqueueManager
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
     * @param ContainerInterface $container
     * @param Logger $logger
     * @return void 
     */
    public function __construct(
    ContainerInterface $container, Logger $logger)
    {
        $this->setContainer($container);
        $this->setLogger($logger);
        $this->setEm($container->get('doctrine')->getEntityManager('default'));
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
     * Get Txqueue by id
     * 
     * @param integer $id
     * @return SuleCoreBundle:Txqueue
     * @throws \Exception 
     */
    public function getById($id)
    {
        $txqueue = $this->em->getRepository('SuleCoreBundle:Txqueue')
            ->find($id);

        if (!$txqueue) {
            throw new \Exception('Txqueue not found for id:' . $id);
            $this->logger->err('Failed to find Txqueue by id:' . $id);
        }
        return $txqueue;
    }

    /**
     * Save txqueue
     * 
     * @param stdClass $params
     * @return \Sule\CoreBundle\Entity\Txqueue
     */
    public function saveNew($params)
    {
        $this->logger->info('save txqueue data');

        $txqueue = new Txqueue();
        $txqueue->setBody($params->body);
        $txqueue->setMsisdn($params->msisdn);
        $txqueue->setRxqueue($params->rxqueue);

        $this->em->persist($txqueue);
        $this->em->flush();
        return $txqueue;
    }

    /**
     * Txqueue status update
     * 
     * @param stdClass $params
     * @return SuleCoreBundle:Txqueue
     */
    public function statusUpdate($params)
    {
        $this->logger->info("status update");

        $txqueue = $this->getById($params->refno);

        $txqueue->setNetwork($params->networkId);

        if (1 == $params->status) {
            $txqueue->setStatus("Queued");
        } elseif (2 == $params->status) {
            $txqueue->setStatus("Submitted");
        } elseif (3 == $params->status) {
            $txqueue->setStatus("Acknowledged");
        } elseif (4 == $params->status) {
            $txqueue->setStatus("Receipted");
        } elseif (5 == $params->status) {
            $txqueue->setStatus("Expired");
        } else {
            $txqueue->setStatus($params->statusMessage);
        }

        $this->em->persist($txqueue);
        $this->em->flush();
        return $txqueue;
    }
    
    /**
     * Get all txqueue messages
     * 
     * @param array $options
     * @return query
     */
    public function listAll($options = array())
    {
        
        return $this->em
                ->getRepository('SuleCoreBundle:Txqueue')
                ->getAllQuery($options);
    }    

}