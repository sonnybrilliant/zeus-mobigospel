<?php

namespace Vanessa\SongBundle\Services;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Monolog\Logger;
use Vanessa\CoreBundle\Entity\Song;

/**
 * Song manager
 *
 * @author Mfana Ronald Conco <ronald.conco@mobigospel.co.za>
 * @version 0.0.1
 * @package VanessaSongBundle
 * @subpackage Services
 */
final class SongManager
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
     * Get active song by id
     * @param integer $id
     * @return VanessaCoreBundle:Song
     * @throws \Exception 
     */
    public function getById($id)
    {
        $this->logger->info('get pending by id:' . $id);
        $song = $this->em->getRepository('VanessaCoreBundle:Song')
            ->find($id);

        if (!$song) {
            throw new \Exception('Full song not found for id:' . $id);
            $this->logger->err('Failed to find full song by id:' . $id);
        }

        return $song;
    }

    /**
     * Get song by slug
     * @param integer $slug
     * @return VanessaCoreBundle:Song
     * @throws \Exception 
     */
    public function getBySlug($slug)
    {
        $this->logger->info('get song by slug:' . $slug);
        $song = $this->em->getRepository('VanessaCoreBundle:Song')
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
        $this->logger->info('get all songs');
        $status = "";
        
        if (isset($options['filterBy'])) {
            if ($options['filterBy'] != '0') {
                $status = $this->getContainer()->get('status.manager')->getStatusByName($options['filterBy']);
                if ($status) {
                    $options['status'] = $status;
                }
            }else{
                $options['status'] = $this->container->get('status.manager')->active();
            }
        }
        
        $member = $this->getContainer()->get('member.manager')->getActiveUser();

        $options['user'] = $member;

        return $this->em
                ->getRepository('VanessaCoreBundle:Song')
                ->getAllSongsQuery($options);
    }    

    
    /**
     * Get all agency songs query
     * 
     * @param array $options
     * @return query
     */
    public function listAgencySongs($options = array())
    {
        $this->logger->info('get all agency songs');
        if (isset($options['filterBy'])) {
            if ($options['filterBy'] != '0') {
                $status = $this->getContainer()->get('status.manager')->getStatusByName($options['filterBy']);
                if ($status) {
                    $options['status'] = $status;
                }
            }
        }

        return $this->em
                ->getRepository('VanessaCoreBundle:Song')
                ->getAllByAgencyTypeQuery($options);
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

        $song = new Song();
        $song->setAgency($songTemp->getAgency());
        $song->setSongTemp($songTemp);
        $song->setArtist($songTemp->getArtist());
        $song->setTitle($songTemp->getTitle());
        $song->setStageName($songTemp->getArtist()->getStageName());
        $song->setIsActive(true);
        $song->setCreatedBy($songTemp->getCreatedBy());
        $song->setFeaturedArtist($songTemp->getFeaturedArtist());
        $song->setStatus($this->container->get('status.manager')->active());
        
        $genres = $songTemp->getGenres();
        
        foreach($genres as $genre){
            $song->addGenre($genre);
        }
        
        $this->em->persist($song);
        $this->em->flush();

        $this->getContainer()->get('code.manager')->internalCode($song);
        $this->getContainer()->get('code.manager')->newCodeAuto($song);
        return;
    }    

    /**
     * Get all songs query
     * 
     * @param array $options
     * @return query
     */
    public function getAll($options = array())
    {
        $this->logger->info('get all active songs');
        
        $member = $this->getContainer()->get('member.manager')->getActiveUser();

        $options['user'] = $member;

        return $this->em
                ->getRepository('VanessaCoreBundle:Song')
                ->getAllQuery($options);
    }       
 
}
