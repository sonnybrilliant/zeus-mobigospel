<?php

namespace Vanessa\AgencyBundle\Services;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Monolog\Logger;
use Vanessa\CoreBundle\Entity\Agency;

/**
 * Content owner manager
 *
 * @author Mfana Ronald Conco <ronald.conco@mobigospel.co.za>
 * @version 0.0.1
 * @package VanessaAgencyBundle
 * @subpackage Services
 */
final class ContentOwnerManager
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
     * Get content owner by id
     * @param integer $id
     * @return VanessaCoreBundle:Agency
     * @throws \Exception 
     */
    public function getById($id)
    {
        $this->logger->info('get content owner by id:' . $id);
        $contentOwner = $this->em->getRepository('VanessaCoreBundle:Agency')
            ->find($id);

        if (!$contentOwner) {
            throw new \Exception('Content owner not found for id:' . $id);
            $this->logger->err('Failed to find Content owner by id:' . $id);
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
        $this->logger->info('get content owner by slug:' . $slug);
        $contentOwner = $this->em->getRepository('VanessaCoreBundle:Agency')
            ->findOneBySlug($slug);

        if (!$contentOwner) {
            throw new \Exception('Content owner not found for slug:' . $slug);
            $this->logger->err('Failed to find content owner by slug:' . $slug);
        }

        return $contentOwner;
    }

    /**
     * Get all content owner query
     * 
     * @param array $options
     * @return query
     */
    public function listAll($options = array())
    {
        $this->logger->info('get all content owners');

        if (isset($options['filterBy'])) {
            if ($options['filterBy'] != '0') {
                $status = $this->getContainer()->get('status.manager')->getStatusByName($options['filterBy']);
                if ($status) {
                    $options['status'] = $status;
                }
            }
        }

        $options['agency_type'] = $this->getContainer()->get('agency.type.manager')->label();

        return $this->em
                ->getRepository('VanessaCoreBundle:Agency')
                ->getAllByAgencyTypeQuery($options);
    }

    /**
     * Create content owner
     * 
     * @param \Vanessa\CoreBundle\Entities\Agency $contentOwner
     * @return type
     */
    public function create($contentOwner)
    {
        $this->logger->info('create new content owner');

        $contentOwner->setStatus($this->getContainer()->get('status.manager')->active());
        $contentOwner->setCreatedBy($this->getContainer()->get('member.manager')->getActiveUser());
        $contentOwner->setAgencyType($this->getContainer()->get('agency.type.manager')->label());
        $this->em->persist($contentOwner);
        $this->em->flush();
        return;
    }

    /**
     * Update content owner
     * 
     * @param \Vanessa\CoreBundle\Entities\Agency $contentOwner
     * @return type
     */
    public function update($contentOwner)
    {
        $this->logger->info('update content owner:' . $contentOwner->getSlug());
        $this->em->persist($contentOwner);
        $this->em->flush();
        return;
    }

    /**
     * Delete content owner
     * 
     * @param \Vanessa\CoreBundle\Entities\Agency $contentOwner
     * @return void
     */
    public function delete($contentOwner)
    {
        $this->logger->info('delete content owner:' . $contentOwner->getSlug());

        //delete all members who belong to content owners
        $this->container->get('member.manager')->deleteAllByAgency($contentOwner);

        //TODO
        //delete artist
        //delete codes
        //delete songs

        $contentOwner->setStatus($this->container->get('status.manager')->deleted());
        $contentOwner->setIsDeleted(true);
        $contentOwner->setName($contentOwner->getName() . '-' . time());
        $contentOwner->setDeletedAt(new \DateTime());
        $contentOwner->setDeletedBy($this->container->get('member.manager')->getActiveUser());
        $this->em->persist($contentOwner);
        $this->em->flush();

        return;
    }

    /**
     * Activate content owner account
     * 
     * @param VanessaCoreBundle:Agency
     * @return void
     */
    public function activate($contentOwner)
    {
        $this->logger->info('activate content owner:' . $contentOwner->getSlug());

        //activate all agency members
        $this->container->get('member.manager')->activateAllByAgency($contentOwner);

        //TODO
        //activate artist
        //activate codes
        //activate songs        
        
        $contentOwner->setStatus($this->container->get('status.manager')->active());
        $contentOwner->setIsDeleted(false);
        $contentOwner->setEnabled(true);
        $this->em->persist($contentOwner);
        $this->em->flush();
        return;
    }

    /**
     * Lock content owner account
     * 
     * @param VanessaCoreBundle:Agency
     * @return void
     */
    public function lock($contentOwner)
    {
        $this->logger->info('lock content owner:' . $contentOwner->getSlug());

        //lock all agency members
        $this->container->get('member.manager')->lockAllByAgency($contentOwner);

        //TODO
        //lock artist
        //lock codes
        //lock songs        
        
        $contentOwner->setStatus($this->container->get('status.manager')->locked());
        $contentOwner->setEnabled(false);
        $this->em->persist($contentOwner);
        $this->em->flush();
        return;
    }

}
