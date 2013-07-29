<?php

namespace Vanessa\SongBundle\Services;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Monolog\Logger;
use Vanessa\CoreBundle\Entity\SongTemp;
use Vanessa\CoreBundle\Entity\Song;

/**
 * Pending manager
 *
 * @author Mfana Ronald Conco <ronald.conco@mobigospel.co.za>
 * @version 0.0.1
 * @package VanessaSongBundle
 * @subpackage Services
 */
final class PendingManager
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
     * Get pedning song by id
     * @param integer $id
     * @return VanessaCoreBundle:SongTemp
     * @throws \Exception 
     */
    public function getById($id)
    {
        $this->logger->info('get pending by id:' . $id);
        $reseller = $this->em->getRepository('VanessaCoreBundle:SongTemp')
            ->find($id);

        if (!$reseller) {
            throw new \Exception('Pending song not found for id:' . $id);
            $this->logger->err('Failed to find pending song by id:' . $id);
        }

        return $reseller;
    }

    /**
     * Get song by slug
     * @param integer $slug
     * @return VanessaCoreBundle:SongTemp
     * @throws \Exception 
     */
    public function getBySlug($slug)
    {
        $this->logger->info('get song by slug:' . $slug);
        $song = $this->em->getRepository('VanessaCoreBundle:SongTemp')
            ->findOneBySlug($slug);

        if (!$song) {
            throw new \Exception('Song not found for slug:' . $slug);
            $this->logger->err('Failed to find songt by slug:' . $slug);
        }

        return $song;
    }

    /**
     * Get all songs query
     * 
     * @param array $options
     * @return query
     */
    public function listAll($options = array())
    {
        $this->logger->info('get all pending songs');
        $status = "";
        
        if (isset($options['filterBy'])) {
            if ($options['filterBy'] != '0') {
                $status = $this->getContainer()->get('status.manager')->getStatusByName($options['filterBy']);
                if ($status) {
                    $options['status'] = $status;
                }
            }else{
                $options['status'] = $this->container->get('status.manager')->pending();
            }
        }
        
        $member = $this->getContainer()->get('member.manager')->getActiveUser();

        $options['user'] = $member;

        return $this->em
                ->getRepository('VanessaCoreBundle:SongTemp')
                ->getAllSongsQuery($options);
    }  
    

    /**
     * Get all songs query
     * 
     * @param array $options
     * @return query
     */
    public function getAll($options = array())
    {
        $this->logger->info('get all pending songs');
        
        $member = $this->getContainer()->get('member.manager')->getActiveUser();

        $options['user'] = $member;

        return $this->em
                ->getRepository('VanessaCoreBundle:SongTemp')
                ->getAllQuery($options);
    }      

    /**
     * Add a new song
     * 
     * @param VanessaCoreBundle:SongTemp $songTemp
     * @return void
     */
    public function newSong($songTemp)
    {
        $this->logger->info("save a new song");

        
        $user = $this->container->get('member.manager')->getActiveUser();

        if (false === $user->getIsAdmin()) {
            $songTemp->setAgency($user->getAgency());
        }
        
        $songTemp->setAgency($songTemp->getArtist()->getAgency());
        $songTemp->setStatus($this->container->get('status.manager')->pending());
        $songTemp->setCreatedBy($user);
        $this->em->persist($songTemp);
        $this->em->flush();

        return;
    }    

    /**
     * Update a song
     * 
     * @param VanessaCoreBundle:SongTemp $songTemp
     * @return void
     */
    public function update($songTemp)
    {
        $this->logger->info("update song");

        
        $user = $this->container->get('member.manager')->getActiveUser();

        if (false === $user->getIsAdmin()) {
            $songTemp->setAgency($user->getAgency());
        }
        
        $songTemp->setAgency($songTemp->getArtist()->getAgency());
        $songTemp->setStatus($this->container->get('status.manager')->pending());
        $songTemp->setRejectedBy(null);
        $songTemp->setRejectedAt(null);
        $this->em->persist($songTemp);
        $this->em->flush();

        return;
    }    

    /**
     * reject a song
     * 
     * @param VanessaCoreBundle:SongTemp $songTemp
     * @return void
     */
    public function reject($songTemp)
    {
        $this->logger->info("reject song:".$songTemp->getSlug());

        
        $user = $this->container->get('member.manager')->getActiveUser();
                
        $songTemp->setRejectedBy($user);
        $songTemp->setStatus($this->container->get('status.manager')->rejected());
        $songTemp->setRejectedAt(new \DateTime());
        $this->em->persist($songTemp);
        $this->em->flush();

        return;
    }    

    /**
     * approve a song
     * 
     * @param VanessaCoreBundle:SongTemp $song
     * @return void
     */
    public function approve($song)
    {
        $this->logger->info("reject song:".$song->getSlug());

        $song->setStatus($this->container->get('status.manager')->approved());
        $song->setRejectedBy(null);
        $song->setRejectedAt(null);
        $song->setRejectMessage(null);
        $this->em->persist($song);
        $this->em->flush();

        return;
    }    
    
    /**
     * start song encode 
     * 
     * @param VanessaCoreBundle:SongTemp $songTemp
     * @return void
     */
    public function startEncoding($song)
    {
        $this->logger->info("song encoding:".$song->getSlug());
        $song->setStatus($this->container->get('status.manager')->encoding());
        $this->em->persist($song);
        $this->em->flush();
        return;
    }
    
    /**
     * update song preview 
     * 
     * @param VanessaCoreBundle:SongTemp $songTemp
     * @return void
     */
    public function updateSongPreview($song)
    {
        $this->logger->info("song preview encoding:".$song->getSlug());
        $song->setIsPreviewVersionDone(true);
        $this->em->persist($song);
        $this->em->flush();
        return;
    }
   
    
    /**
     * update songfull 
     * 
     * @param VanessaCoreBundle:SongTemp $songTemp
     * @return void
     */
    public function updateSongFull($song)
    {
        $this->logger->info("song full encoding:".$song->getSlug());
        $song->setIsFullVersionDone(true);
        $this->em->persist($song);
        $this->em->flush();
        return;
    }
    
}
