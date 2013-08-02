<?php

namespace Sule\TransactionBundle\Services;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Monolog\Logger;

/**
 * Transaction manager
 *
 * @author Ronald Conco <ronald.conco@gmail.com>
 * @version 1.0
 * @package SuleTransactionBundle
 * @subpackage Services
 */
final class TransactionManager
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
     * Initialize transaction
     * 
     * @param integer $rxqueueId
     * @return \Sule\CoreBundle\Entity\Download|boolean
     */
    public function init($rxqueueId)
    {
        $this->logger->info("initialize transaction for rxqueueId:" . $rxqueueId);

        $rxqueue = $this->container->get('rxqueue.manager')->getById($rxqueueId);

        //is code valid
        $code = $this->container->get('code.manager')->getByCode($rxqueue->getBody());

        if ($code) {
            $arguments = new \stdClass();
            $arguments->code = $code;
            $arguments->rxqueue = $rxqueue;
            
            $download = $this->container->get('download.manager')->saveNew($arguments);
            //update download counter
            $this->container->get('code.manager')->updateCounter($code);
            return $download;
        }
        return false;
    }

}