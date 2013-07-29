<?php

namespace Vanessa\CoreBundle\Services;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Monolog\Logger;

/**
 * Message type manager
 *
 * @author Mfana Ronald Conco <ronald.conco@mobigospel.co.za>
 * @package VanessaCoreBundle
 * @subpackage Services
 * @version 0.0.1
 */
final class MessageTypeManager
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
     * Get type by name
     * 
     * @param type $typeName
     * @return 
     * @throws \Exception 
     */
    public function getTypeByName($typeName)
    {
        $this->logger->info('get message type' . $typeName);

        $messageType = $this->em
                ->getRepository('VanessaCoreBundle:MessageType')
                ->getType($typeName);

        if (!$messageType) {
            $this->logger->err('Failed to get message type ' . $typeName );
            throw new \Exception('Exception, message type ' . $typeName . ' not found');
        }

        return $messageType;
    }

    /**
     * get info type
     * @return object 
     */
    public function info()
    {
        $this->logger->info('get info message type');
        return $this->getTypeByName('Info');
    }

    /**
     * get error type
     * @return object 
     */
    public function error()
    {
        $this->logger->info('get error message type');
        return $this->getTypeByName('Error');
    }

    /**
     * get warning type
     * @return object 
     */
    public function warning()
    {
        $this->logger->info('get warning message type');
        return $this->getTypeByName('Warning');
    }

    /**
     * get success type
     * @return object 
     */
    public function success()
    {
        $this->logger->info('get success message type');
        return $this->getTypeByName('Success');
    }

    /**
     * get general type
     * @return object 
     */
    public function general()
    {
        $this->logger->info('get general message type');
        return $this->getTypeByName('General');
    }
    
}