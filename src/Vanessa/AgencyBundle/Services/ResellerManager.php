<?php

namespace Vanessa\AgencyBundle\Services;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Monolog\Logger;
use Vanessa\CoreBundle\Entity\Agency;

/**
 * Reseller manager
 *
 * @author Mfana Ronald Conco <ronald.conco@mobigospel.co.za>
 * @version 0.0.1
 * @package VanessaAgencyBundle
 * @subpackage Services
 */
final class ResellerManager
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
     * Get reseller by id
     * @param integer $id
     * @return VanessaCoreBundle:Agency
     * @throws \Exception 
     */
    public function getById($id)
    {
        $this->logger->info('get reseller by id:' . $id);
        $contentOwner = $this->em->getRepository('VanessaCoreBundle:Agency')
            ->find($id);

        if (!$contentOwner) {
            throw new \Exception('Reseller not found for id:' . $id);
            $this->logger->err('Failed to find reseller by id:' . $id);
        }

        return $contentOwner;
    }

    /**
     * Get reseller by slug
     * @param integer $slug
     * @return VanessaCoreBundle:Agency
     * @throws \Exception 
     */
    public function getBySlug($slug)
    {
        $this->logger->info('get reseller by slug:' . $slug);
        $contentOwner = $this->em->getRepository('VanessaCoreBundle:Agency')
            ->findOneBySlug($slug);

        if (!$contentOwner) {
            throw new \Exception('Reseller not found for slug:' . $slug);
            $this->logger->err('Failed to find reseller by slug:' . $slug);
        }

        return $contentOwner;
    }

    /**
     * Get all reseller query
     * 
     * @param array $options
     * @return query
     */
    public function listAll($options = array())
    {
        $this->logger->info('get all resellers');

        if (isset($options['filterBy'])) {
            if ($options['filterBy'] != '0') {
                $status = $this->getContainer()->get('status.manager')->getStatusByName($options['filterBy']);
                if ($status) {
                    $options['status'] = $status;
                }
            }
        }

        $options['agency_type'] = $this->getContainer()->get('agency.type.manager')->media();

        return $this->em
                ->getRepository('VanessaCoreBundle:Agency')
                ->getAllByAgencyTypeQuery($options);
    }

    /**
     * Create reseller
     * 
     * @param \Vanessa\CoreBundle\Entities\Agency $reseller
     * @return type
     */
    public function create($reseller)
    {
        $this->logger->info('create new reseller');

        $reseller->setStatus($this->getContainer()->get('status.manager')->active());
        $reseller->setCreatedBy($this->getContainer()->get('member.manager')->getActiveUser());
        $reseller->setAgencyType($this->getContainer()->get('agency.type.manager')->media());
        $this->em->persist($reseller);
        $this->em->flush();
        return;
    }

    /**
     * Update reseller
     * 
     * @param \Vanessa\CoreBundle\Entities\Agency $reseller
     * @return type
     */
    public function update($reseller)
    {
        $this->logger->info('update reseller:' . $reseller->getSlug());
        $this->em->persist($reseller);
        $this->em->flush();
        return;
    }

    /**
     * Delete reseller
     * 
     * @param \Vanessa\CoreBundle\Entities\Agency $reseller
     * @return void
     */
    public function delete($reseller)
    {
        $this->logger->info('delete reseller:' . $reseller->getSlug());

        //delete all members who belong to content owners
        $this->container->get('member.manager')->deleteAllByAgency($reseller);

        //TODO
        //delete artist
        //delete codes
        //delete songs

        $reseller->setStatus($this->container->get('status.manager')->deleted());
        $reseller->setIsDeleted(true);
        $reseller->setName($reseller->getName() . '-' . time());
        $reseller->setDeletedAt(new \DateTime());
        $reseller->setDeletedBy($this->container->get('member.manager')->getActiveUser());
        $this->em->persist($reseller);
        $this->em->flush();

        return;
    }

    /**
     * Activate content owner account
     * 
     * @param VanessaCoreBundle:Agency
     * @return void
     */
    public function activate($reseller)
    {
        $this->logger->info('activate reseller:' . $reseller->getSlug());

        //activate all agency members
        $this->container->get('member.manager')->activateAllByAgency($reseller);

        //TODO
        //activate artist
        //activate codes
        //activate songs        
        
        $reseller->setStatus($this->container->get('status.manager')->active());
        $reseller->setIsDeleted(false);
        $reseller->setEnabled(true);
        $this->em->persist($reseller);
        $this->em->flush();
        return;
    }

    /**
     * Lock content owner account
     * 
     * @param VanessaCoreBundle:Agency
     * @return void
     */
    public function lock($reseller)
    {
        $this->logger->info('lock reseller:' . $reseller->getSlug());

        //lock all agency members
        $this->container->get('member.manager')->lockAllByAgency($reseller);

        //TODO
        //lock artist
        //lock codes
        //lock songs        
        
        $reseller->setStatus($this->container->get('status.manager')->locked());
        $reseller->setEnabled(false);
        $this->em->persist($reseller);
        $this->em->flush();
        return;
    }

}
