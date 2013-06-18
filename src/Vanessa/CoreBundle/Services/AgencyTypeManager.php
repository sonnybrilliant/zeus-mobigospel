<?php

namespace Vanessa\CoreBundle\Services;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Monolog\Logger;

/**
 * Agency type manager
 *
 * @author Mfana Ronald Conco <ronald.conco@mobigospel.co.za>
 * @package VanessaCoreBundle
 * @subpackage Services
 * @version 0.0.1
 */
final class AgencyTypeManager
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
     * Get agency type by name
     * 
     * @param type $agencyTypeName
     * @return 
     * @throws \Exception 
     */
    public function getAgencyTypeByName($agencyTypeName)
    {
        $this->logger->info('get agency type ' . $agencyTypeName);

        $agencyType = $this->em
                ->getRepository('VanessaCoreBundle:AgencyType')
                ->getByName($agencyTypeName);

        if (!$agencyType) {
            $this->logger->err('Failed to get agency type ' . $agencyTypeName);
            throw new \Exception('Exception, no  agency type' . $agencyTypeName . ' found');
        }

        return $agencyType;
    }

    /**
     * get Internal agency type
     * @return VanessaCoreBundle:AgencyType 
     */
    public function internal()
    {
        $this->logger->info('get Internal agency type');
        return $this->getAgencyTypeByName('Internal');
    }

    /**
     * get Content provider agency type
     * @return VanessaCoreBundle:AgencyType 
     */
    public function label()
    {
        $this->logger->info('get Content provider agency type');
        return $this->getAgencyTypeByName('Content provider');
    }

    /**
     * get Media partner agency type
     * @return VanessaCoreBundle:AgencyType 
     */
    public function media()
    {
        $this->logger->info('get Media partner agency type');
        return $this->getAgencyTypeByName('Media partner');
    }
    
}