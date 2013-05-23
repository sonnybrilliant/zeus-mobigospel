<?php

namespace Vanessa\CoreBundle\Services;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Monolog\Logger;

/**
 * Status manager
 *
 * @author Mfana Ronald Conco <ronald.conco@mobigospel.co.za>
 * @package VanessaCoreBundle
 * @subpackage Services
 * @version 0.0.1
 */
final class StatusManager
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
    ContainerInterface $container , Logger $logger)
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
     * Get status by name
     * 
     * @param type $statusName
     * @return 
     * @throws \LogicException 
     */
    public function getStatusByName($statusName)
    {
        $this->logger->info('get ' . $statusName.' status');

        $status = $this->em
                ->getRepository('VanessaCoreBundle:Status')
                ->getStatus($statusName);

        if (!$status) {
            $this->logger->err('Failed to get ' . $statusName . ' status');
            throw new \Exception('Logical exception, no ' . $statusName . ' status found');
        }

        return $status;
    }

    /**
     * get active status
     * @return object 
     */
    public function active()
    {
        $this->logger->info('get active status');
        return $this->getStatusByName('Active');
    }

    /**
     * get pending status
     * @return object 
     */
    public function pending()
    {
        $this->logger->info('get pending status');
        return $this->getStatusByName('Pending');
    }
    
    /**
     * get deleted status
     * @return object 
     */
    public function deleted()
    {
        $this->logger->info('get deleted status');
        return $this->getStatusByName('Deleted');
    } 
    
    /**
     * get enconding status
     * @return object 
     */
    public function encoding()
    {
        $this->logger->info('get encoding status');
        return $this->getStatusByName('Encoding');
    }    
    
    /**
     * get completed status
     * @return object 
     */
    public function completed()
    {
        $this->logger->info('get completed status');
        return $this->getStatusByName('Completed');
    }    
    
}