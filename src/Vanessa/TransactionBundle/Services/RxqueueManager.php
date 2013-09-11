<?php

namespace Vanessa\TransactionBundle\Services;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Monolog\Logger;
use Vanessa\CoreBundle\Entity\Rxqueue;

/**
 * Rxqueue manager
 *
 * @author Mfana Ronald Conco <ronald.conco@mobigospel.co.za>
 * @package VanessaTransactionBundle
 * @subpackage Services
 * @version 0.0.1
 */
final class RxqueueManager
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
     * Get Rxqueue by id
     * @param integer $id
     * @return VanessaCoreBundle:Rxqueue
     * @throws \Exception 
     */
    public function getById($id)
    {
        $this->logger->info('get rxqueue by id:' . $id);
        $rxqueue = $this->em->getRepository('VanessaCoreBundle:Rxqueue')
            ->find($id);

        if (!$rxqueue) {
            throw new \Exception('Rxqueue not found for id:' . $id);
            $this->logger->err('Failed to find Rxqueue by id:' . $id);
        }

        return $rxqueue;
    }

    /**
     * Get all rxqueue query
     * 
     * @param array $options
     * @return query
     */
    public function listAll($options = array())
    {
        $this->logger->info('get all rxqueues');
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
                ->getRepository('VanessaCoreBundle:Rxqueue')
                ->getAllRxqueueQuery($options);
    }
    

    /**
     * Get all inbound sms query
     * 
     * @param array $options
     * @return query
     */
    public function getAll($options = array())
    {
        $this->logger->info('get all inbound sms');

        $member = $this->getContainer()->get('member.manager')->getActiveUser();

        $options['user'] = $member;

        return $this->em
                ->getRepository('VanessaCoreBundle:Rxqueue')
                ->getAllQuery($options);
    }    

    /**
     * Create Rxqueue
     * 
     * @param VanessaCoreBundle:Rxqueue $rxqueue
     * @return type
     */
    public function create($rxqueue)
    {
        $this->logger->info("create rxqueue");

        $this->em->persist($rxqueue);
        $this->em->flush();
        return $rxqueue;
    }
    
    /**
     * Transaction was no completed but code was not matched
     * 
     * @param VanessaCoreBundle:Rxqueue $rxqueue
     * @return type
     */
    public function updateCompleted($rxqueue)
    {
        $this->logger->info("update completed rxqueue");

        $rxqueue->setStatus($this->getContainer()->get('status.manager')->completed());
        $this->em->persist($rxqueue);
        $this->em->flush();
        return;
    }
    
    /**
     * Transaction was no completed but code was not matched
     * 
     * @param VanessaCoreBundle:Rxqueue $rxqueue
     * @return type
     */
    public function updateSuccessful($rxqueue)
    {
        $this->logger->info("update successful rxqueue");

        $rxqueue->setStatus($this->getContainer()->get('status.manager')->successful());
        $this->em->persist($rxqueue);
        $this->em->flush();
        return;
    }

}