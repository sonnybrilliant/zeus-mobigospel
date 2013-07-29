<?php

namespace Vanessa\CodeBundle\Services;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Monolog\Logger;
use Vanessa\CoreBundle\Entity\Code;

/**
 * Code manager
 *
 * @author Mfana Ronald Conco <ronald.conco@mobigospel.co.za>
 * @version 0.0.1
 * @package VanessaCodeBundle
 * @subpackage Services
 */
final class CodeManager
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
     * Get code by id
     * @param integer $id
     * @return VanessaCoreBundle:Code
     * @throws \Exception 
     */
    public function getById($id)
    {
        $this->logger->info('get code by id:' . $id);
        $code = $this->em->getRepository('VanessaCoreBundle:Code')
            ->find($id);

        if (!$code) {
            throw new \Exception('Code not found for id:' . $id);
            $this->logger->err('Failed to find code by id:' . $id);
        }

        return $code;
    }

    /**
     * Get by code
     * @param integer $code
     * @return VanessaCoreBundle:Code
     * @throws \Exception 
     */
    public function getByCode($code)
    {
        $this->logger->info('get code by code:' . $code);
        $song = $this->em->getRepository('VanessaCoreBundle:Code')
            ->findOneByCode($code);

        if (!$song) {
            throw new \Exception('Code not found for code:' . $code);
            $this->logger->err('Failed to find code by code:' . $code);
        }

        return $song;
    }

    /**
     * Get all codes query
     * 
     * @param array $options
     * @return query
     */
    public function listAll($options = array())
    {
        $this->logger->info('get all codes');
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
                ->getRepository('VanessaCoreBundle:Code')
                ->getAllCodesQuery($options);

    }

    /**
     * Get all code query
     * 
     * @param array $options
     * @return query
     */
    public function getAll($options = array())
    {
        $this->logger->info('get all code');

        $member = $this->getContainer()->get('member.manager')->getActiveUser();

        $options['user'] = $member;

        return $this->em
                ->getRepository('VanessaCoreBundle:Code')
                ->getAllQuery($options);
    }

    /**
     * Get all agency codes query
     * 
     * @param array $options
     * @return query
     */
    public function listAgencyCodes($options = array())
    {
        $this->logger->info('get all agency codes');
        if (isset($options['filterBy'])) {
            if ($options['filterBy'] != '0') {
                $status = $this->getContainer()->get('status.manager')->getStatusByName($options['filterBy']);
                if ($status) {
                    $options['status'] = $status;
                }
            }
        }

        return $this->em
                ->getRepository('VanessaCoreBundle:Code')
                ->getAllByAgencyTypeQuery($options);
    }      
    
    
    /**
     * Create new code
     * 
     * @param \Vanessa\CoreBundle\Entity\Code $code
     * @return void
     */
    public function newCode($code)
    {
        $this->logger->info('create a new code');
        $member = $this->getContainer()->get('member.manager')->getActiveUser();

        $code->setAgency($code->getSong()->getAgency());
        $code->setSearchAgency($code->getSong()->getAgency()->getName());
        $code->setArtist($code->getSong()->getArtist());
        $code->setSearchArtist($code->getSong()->getArtist()->getStageName());
        $code->setSearchSong($code->getSong()->getTitle());
        $code->setStatus($this->container->get('status.manager')->active());
        $code->setCode(strtoupper($code->getCode()));
        $code->setCreatedBy($member);
        $this->em->persist($code);
        $this->em->flush();
        return;
    }

    /**
     * Create internal
     * 
     * @param \Vanessa\CoreBundle\Entity\Code $code
     * @return void
     */
    public function internalCode($song)
    {
        $this->logger->info('create internal');
                
        $str = "MOB";
        $str .= str_pad((int) $song->getId(), 5, "0", STR_PAD_LEFT); 
        
        $agency = $this->getContainer()->get('reseller.manager')->getById(1);
        
        $code = new Code();
        $code->setAgency($agency);
        $code->setSearchAgency($agency->getName());
        $code->setArtist($song->getArtist());
        $code->setSearchArtist($song->getArtist()->getStageName());
        $code->setSong($song);
        $code->setSearchSong($song->getTitle());
        $code->setStatus($this->container->get('status.manager')->active());
        $code->setCode(strtoupper($str));
        $code->setCreatedBy($song->getCreatedBy());
        $this->em->persist($code);
        $this->em->flush();
        return;
    }

    /**
     * Create new code
     * 
     * @param \Vanessa\CoreBundle\Entity\Code $code
     * @return void
     */
    public function newCodeAuto($song)
    {
        $this->logger->info('create a new code');
        
        $agency = $song->getAgency()->getName();
        $artist = $song->getArtist()->getStageName();        
        
        $str = "";
        $str .= $agency[0];
        $str .= $artist[0];
        $str .= str_pad((int) $song->getId(), 5, "0", STR_PAD_LEFT); 
        
        $code = new Code();
        $code->setAgency($song->getAgency());
        $code->setSearchAgency($song->getAgency()->getName());
        $code->setArtist($song->getArtist());
        $code->setSearchArtist($song->getArtist()->getStageName());
        $code->setSong($song);
        $code->setSearchSong($song->getTitle());
        $code->setStatus($this->container->get('status.manager')->active());
        $code->setCode(strtoupper($str));
        $code->setCreatedBy($song->getCreatedBy());
        $this->em->persist($code);
        $this->em->flush();
        return;
    }
    
    /**
     * Update new code
     * 
     * @param \Vanessa\CoreBundle\Entity\Code $code
     * @return void
     */
    public function update($code)
    {
        $this->logger->info('update code');
        $member = $this->getContainer()->get('member.manager')->getActiveUser();

        $code->setAgency($code->getSong()->getAgency());
        $code->setSearchAgency($code->getSong()->getAgency()->getName());
        $code->setArtist($code->getSong()->getArtist());
        $code->setSearchArtist($code->getSong()->getArtist()->getStageName());
        $code->setSearchSong($code->getSong()->getTitle());
        $code->setStatus($this->container->get('status.manager')->active());
        $code->setCode(strtoupper($code->getCode()));
        $code->setCreatedBy($member);
        $this->em->persist($code);
        $this->em->flush();
        return;
    }    
    
    /**
     * disable code
     * 
     * @param \Vanessa\CoreBundle\Entity\Code $code
     * @return void
     */
    public function disable($code)
    {
        $this->logger->info('disable code');
        $code->setStatus($this->container->get('status.manager')->disabled());
        $code->setDisabledBy($this->getContainer()->get('member.manager')->getActiveUser());
        $code->setDisabledAt(new \DateTime());
        $this->em->persist($code);
        $this->em->flush();
        return;
    }    
    
    /**
     * activate code
     * 
     * @param \Vanessa\CoreBundle\Entity\Code $code
     * @return void
     */
    public function active($code)
    {
        $this->logger->info('activate code');
        $code->setStatus($this->container->get('status.manager')->active());
        $code->setDisabledBy(null);
        $code->setDisabledAt(null);        
        $this->em->persist($code);
        $this->em->flush();
        return;
    }    

}
