<?php

namespace Vanessa\ArtistBundle\Services;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Monolog\Logger;
use Vanessa\CoreBundle\Entity\Artist;

/**
 * Artist manager
 *
 * @author Mfana Ronald Conco <ronald.conco@mobigospel.co.za>
 * @version 0.0.1
 * @package VanessaAgencyBundle
 * @subpackage Services
 */
final class ArtistManager
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
     * Get artist by id
     * @param integer $id
     * @return VanessaCoreBundle:Artist
     * @throws \Exception 
     */
    public function getById($id)
    {
        $this->logger->info('get artist by id:' . $id);
        $reseller = $this->em->getRepository('VanessaCoreBundle:Artist')
            ->find($id);

        if (!$reseller) {
            throw new \Exception('Artit not found for id:' . $id);
            $this->logger->err('Failed to find artist by id:' . $id);
        }

        return $reseller;
    }

    /**
     * Get artist by slug
     * @param integer $slug
     * @return VanessaCoreBundle:Artist
     * @throws \Exception 
     */
    public function getBySlug($slug)
    {
        $this->logger->info('get artist by slug:' . $slug);
        $reseller = $this->em->getRepository('VanessaCoreBundle:Artist')
            ->findOneBySlug($slug);

        if (!$reseller) {
            throw new \Exception('Artist not found for slug:' . $slug);
            $this->logger->err('Failed to find artist by slug:' . $slug);
        }

        return $reseller;
    }

    /**
     * Get all artists query
     * 
     * @param array $options
     * @return query
     */
    public function listAll($options = array())
    {
        $this->logger->info('get all artists');

        if (isset($options['filterBy'])) {
            if ($options['filterBy'] != '0') {
                $status = $this->getContainer()->get('status.manager')->getStatusByName($options['filterBy']);
                if ($status) {
                    $options['status'] = $status;
                }
            }
        }

        $member = $this->getContainer()->get('member.manager')->getActiveUser();

        $options['is_admin'] = $member->getIsAdmin();
        $options['agency'] = $member->getAgency();

        return $this->em
                ->getRepository('VanessaCoreBundle:Artist')
                ->getAllArtistsQuery($options);
    }
    
    /**
     * Get all agency artists query
     * 
     * @param array $options
     * @return query
     */
    public function listAgencyArtists($options = array())
    {
        $this->logger->info('get all agency artists');
        if (isset($options['filterBy'])) {
            if ($options['filterBy'] != '0') {
                $status = $this->getContainer()->get('status.manager')->getStatusByName($options['filterBy']);
                if ($status) {
                    $options['status'] = $status;
                }
            }
        }

        return $this->em
                ->getRepository('VanessaCoreBundle:Artist')
                ->getAllArtistsByAgencyQuery($options);
    }    

    /**
     * Create artist
     * 
     * @param VanessaCoreBundle:Artist
     * @return type
     */
    public function create($artist)
    {
        $this->logger->info('create new artist');

        $member = $this->getContainer()->get('member.manager')->getActiveUser();

        $artist->setStatus($this->getContainer()->get('status.manager')->active());

        if (!$member->getIsAdmin()) {
            $artist->setAgency($member->getAgency());
        }

        $artist->setCreatedBy($member);

        $this->em->persist($artist);
        $this->em->flush();
        return;
    }

    /**
     * Update artist
     * 
     * @param VanessaCoreBundle:Artist
     * @return type
     */
    public function update($artist)
    {
        $this->logger->info('update artist:' . $artist->getSlug());
        $this->em->persist($artist);
        $this->em->flush();
        return;
    }

    /**
     * Delete artist
     * 
     * @param VanessaCoreBundle:Artist
     * @return void
     */
    public function delete($artist)
    {
        $this->logger->info('delete artist:' . $artist->getSlug());

        //TODO
        //delete codes
        //delete songs

        $artist->setStatus($this->container->get('status.manager')->deleted());
        $artist->setIsDeleted(true);
        $artist->setEnabled(false);
        $artist->setStageName($artist->getStageName() . '-' . time());
        $artist->setDeletedAt(new \DateTime());
        $artist->setDeletedBy($this->container->get('member.manager')->getActiveUser());
        $this->em->persist($artist);
        $this->em->flush();

        return;
    }

    /**
     * Activate artist account
     * 
     * @param VanessaCoreBundle:Artist
     * @return void
     */
    public function activate($artist)
    {
        $this->logger->info('activate artist:' . $artist->getSlug());

        //TODO
        //activate codes
        //activate songs        

        $artist->setStatus($this->container->get('status.manager')->active());
        $artist->setIsDeleted(false);
        $artist->setEnabled(true);
        $this->em->persist($artist);
        $this->em->flush();
        return;
    }

    /**
     * Lock content owner account
     * 
     * @param VanessaCoreBundle:Artist
     * @return void
     */
    public function lock($artist)
    {
        $this->logger->info('lock artist:' . $artist->getSlug());

        //TODO
        //lock codes
        //lock songs        

        $artist->setStatus($this->container->get('status.manager')->locked());
        $artist->setEnabled(false);
        $this->em->persist($artist);
        $this->em->flush();
        return;
    }

    /**
     * Lock all artist by agency
     * 
     * @param VanessaCodeBundle:Agency $agency
     * @return void
     */
    public function lockAllByAgency($agency)
    {
        $this->logger->info('lock all artists by agency:' . $agency->getSlug());

        $options = array('searchText' => '',
            'sort' => '',
            'direction' => '',
            'filterBy' => '',
            'agency' => $agency
        );

        $artists = $this->em->getRepository('VanessaCoreBundle:Artist')
            ->getAllArtistsByAgencyQuery($options);

        $status = $this->container->get('status.manager')->locked();
        foreach ($artists as $artist) {
            $artist->setStatus($status);
            $artist->setEnabled(false);
            $this->em->persist($artist);
        }
        $this->em->flush();
        return;
    }

    /**
     * Activate all artist by agency
     * 
     * @param VanessaCodeBundle:Agency $agency
     * @return void
     */
    public function activateAllByAgency($agency)
    {
        $this->logger->info('activate all artists by agency:' . $agency->getSlug());

        $options = array('searchText' => '',
            'sort' => '',
            'direction' => '',
            'filterBy' => '',
            'agency' => $agency
        );

        $artists = $this->em->getRepository('VanessaCoreBundle:Artist')
            ->getAllArtistsByAgencyQuery($options);

        $status = $this->container->get('status.manager')->active();
        foreach ($artists as $artist) {
            $artist->setStatus($status);
            $artist->setIsDeleted(false);
            $artist->setEnabled(true);
            $this->em->persist($artist);
        }
        $this->em->flush();
        return;
    }

    /**
     * Delete all artist by agency
     * 
     * @param VanessaCodeBundle:Agency $agency
     * @return void
     */
    public function deleteAllByAgency($agency)
    {
        $this->logger->info('activate all artists by agency:' . $agency->getSlug());

        $options = array('searchText' => '',
            'sort' => '',
            'direction' => '',
            'filterBy' => '',
            'agency' => $agency
        );

        $artists = $this->em->getRepository('VanessaCoreBundle:Artist')
            ->getAllArtistsByAgencyQuery($options);

        $status = $this->container->get('status.manager')->deleted();
        $member = $this->container->get('member.manager')->getActiveUser();
        foreach ($artists as $artist) {
            $artist->setStatus($status);
            $artist->setIsDeleted(true);
            $artist->setEnabled(false);
            $artist->setStageName($artist->getStageName() . '-' . time());
            $artist->setDeletedAt(new \DateTime());
            $artist->setDeletedBy($member);
            $this->em->persist($artist);
        }
        $this->em->flush();
        return;
    }

}
