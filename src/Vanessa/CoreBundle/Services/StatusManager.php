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
     * Get status by name
     * 
     * @param type $statusName
     * @return 
     * @throws \Exception 
     */
    public function getStatusByName($statusName)
    {
        $this->logger->info('get ' . $statusName . ' status');

        $status = $this->em
            ->getRepository('VanessaCoreBundle:Status')
            ->getStatus($statusName);

        if (!$status) {
            $this->logger->err('Failed to get ' . $statusName . ' status');
            throw new \Exception('Exception, no ' . $statusName . ' status found');
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
     * get error status
     * @return object 
     */
    public function error()
    {
        $this->logger->info('get error status');
        return $this->getStatusByName('Error');
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

    /**
     * get locked status
     * @return object 
     */
    public function locked()
    {
        $this->logger->info('get locked status');
        return $this->getStatusByName('Locked');
    }

    /**
     * get rejected status
     * @return object 
     */
    public function rejected()
    {
        $this->logger->info('get rejected status');
        return $this->getStatusByName('Rejected');
    }

    /**
     * get approved status
     * @return object 
     */
    public function approved()
    {
        $this->logger->info('get approved status');
        return $this->getStatusByName('Approved');
    }

    /**
     * get disabled status
     * @return object 
     */
    public function disabled()
    {
        $this->logger->info('get disabled status');
        return $this->getStatusByName('Disabled');
    }

    /**
     * get Successful status
     * 
     * @return object 
     */
    public function successful()
    {
        $this->logger->info('get Successful status');
        return $this->getStatusByName('Successful');
    }

    /**
     * get Queued status
     * 
     * @return object 
     */
    public function queued()
    {
        $this->logger->info('get Queued status');
        return $this->getStatusByName('Queued');
    }

    /**
     * get Submitted status
     * 
     * @return object 
     */
    public function submitted()
    {
        $this->logger->info('get Submitted status');
        return $this->getStatusByName('Submitted');
    }

    /**
     * get Acknowledged status
     * 
     * @return object 
     */
    public function acknowledged()
    {
        $this->logger->info('get Acknowledged status');
        return $this->getStatusByName('Acknowledged');
    }

    /**
     * get Receipted status
     * 
     * @return object 
     */
    public function receipted()
    {
        $this->logger->info('get Receipted status');
        return $this->getStatusByName('Receipted');
    }

    /**
     * get Expired status
     * 
     * @return object 
     */
    public function expired()
    {
        $this->logger->info('get Expired status');
        return $this->getStatusByName('Expired');
    }

}