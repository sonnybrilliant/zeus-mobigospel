<?php

namespace Sule\TransactionBundle\Services;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Monolog\Logger;
use Sule\CoreBundle\Entity\Download;

/**
 * Download manager
 *
 * @author Ronald Conco <ronald.conco@gmail.com>
 * @version 1.0
 * @package SuleTransactionBundle
 * @subpackage Services
 */
final class DownloadManager
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
     * Get Download by id
     * 
     * @param integer $id
     * @return SuleCoreBundle:Download
     * @throws \Exception 
     */
    public function getById($id)
    {
        $download = $this->em->getRepository('SuleCoreBundle:Download')
            ->find($id);

        if (!$download) {
            throw new \Exception('Download not found for id:' . $id);
            $this->logger->err('Failed to find Download by id:' . $id);
        }
        return $download;
    }

    /**
     * Get Download by token
     * 
     * @param string $token
     * @return SuleCoreBundle:Download
     * @throws \Exception 
     */
    public function getByToken($token)
    {
        $downloads = $this->em->getRepository('SuleCoreBundle:Download')
            ->findByToken($token);

        if (!$downloads) {
            throw new \Exception('Download not found for token:' . $token);
            $this->logger->err('Failed to find Download by token:' . $token);
        }
        return $downloads[0];
    }

    /**
     * Create download
     * 
     * @param stdClass $params
     * @return \Sule\CoreBundle\Entity\Download
     */
    public function saveNew($params)
    {
        $this->logger->info("create new download entry");

        $download = new Download();
        $download->setCode($params->code);
        $download->setSong($params->code->getSong());
        $download->setAgency($params->code->getAgency());
        $download->setRxqueue($params->rxqueue);
        $download->setToken($this->container->get('token.generator')->generateToken());
        $download->setSearchAgency($params->code->getAgency()->getName());
        $download->setSearchCode($params->code->getCode());
        $download->setSearchSong($params->code->getSong()->getTitle());
        $download->setMsisdn($params->rxqueue->getMsisdn());
        $checkoutAt = new \DateTime();
        $download->setCheckoutAt($checkoutAt->setTimestamp(strtotime("+91 days")));

        $this->em->persist($download);
        $this->em->flush();
        return $download;
    }

    /**
     * Save download instance
     * @param \Sule\CoreBundle\Entity\Download $download
     * @return \Sule\CoreBundle\Entity\Download
     */
    public function download($download)
    {
        $this->logger->info("handle song download");

        $download->setDownloadCounter($download->getDownloadCounter() + 1);

        if (!$download->getIsDownloaded()) {
            $download->setIsDownloaded(true);
            $download->setDownloadedAt(new \DateTime());
        }

        $this->em->persist($download);
        $this->em->flush();
        return $download;
    }

    /**
     * Get all  recorded download
     * 
     * @param array $options
     * @return query
     */
    public function listAll($options = array())
    {
        $this->logger->info("list all downloads");
        return $this->em
                ->getRepository('SuleCoreBundle:Download')
                ->getAllQuery($options);
    }

    /**
     * Get all  today's downloads
     * 
     * @param array $options
     * @return query
     */
    public function listAllToday($options = array())
    {
        $this->logger->info("list all today's downloads");

        $securityContext = $this->container->get('security.context');
        $user = $securityContext->getToken()->getUser();

        $options['user'] = $user;

        return $this->em
                ->getRepository('SuleCoreBundle:Download')
                ->getAllTodayDownloadsQuery($options);
    }

    /**
     * Get all  checkout awaiting downloads
     * 
     * @param array $options
     * @return query
     */
    public function listCheckoutAwaiting($options = array())
    {
        $this->logger->info("list all checkout awaiting downloads");

        return $this->em
                ->getRepository('SuleCoreBundle:Download')
                ->getAllCheckoutAwaitingQuery($options);
    }

    /**
     * Get all  checkout ready downloads
     * 
     * @param array $options
     * @return query
     */
    public function listCheckoutReady($options = array())
    {
        $this->logger->info("list all checkout ready downloads");

        return $this->em
                ->getRepository('SuleCoreBundle:Download')
                ->getAllCheckoutReadyQuery($options);
    }

    /**
     * Get all  checkout ready downloads
     * 
     * @param array $options
     * @return query
     */
    public function listCheckedOut($options = array())
    {
        $this->logger->info("list all checked out downloads");

        return $this->em
                ->getRepository('SuleCoreBundle:Download')
                ->getAllCheckedOutQuery($options);
    }

    /**
     * Get system wide top downloads
     * 
     * @return array
     */
    public function getSystemTop10Downloads()
    {
        $this->logger->info("list system wide top 10 downloads");

        $codes = $this->em
            ->getRepository('SuleCoreBundle:Code')
            ->getSystemTopTenChart();

        $tmp = array();
        $results = array();
        foreach ($codes as $code) {
            if (!in_array($code->getSong()->getId(), $tmp)) {
                if($code->getAgency()->getId() == 1){
                    $results[] = $code;
                }
            }
            $tmp[] = $code->getSong()->getId();
        }
        return $results;
    }

}