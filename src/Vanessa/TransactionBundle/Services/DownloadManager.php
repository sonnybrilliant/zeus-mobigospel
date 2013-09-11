<?php

namespace Vanessa\TransactionBundle\Services;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Monolog\Logger;
use Vanessa\CoreBundle\Entity\Download;

/**
 * Download manager
 *
 * @author Ronald Conco <ronald.conco@gmail.com>
 * @version 1.0
 * @package VanessaTransactionBundle
 * @subpackage Services
 */
class DownloadManager
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
     * Get Download by id
     * 
     * @param integer $id
     * @return VanessaCoreBundle:Download
     * @throws \Exception 
     */
    public function getById($id)
    {
        $download = $this->em->getRepository('VanessaCoreBundle:Download')
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
     * @return VanessaCoreBundle:Download
     * @throws \Exception 
     */
    public function getByToken($token)
    {
        $download = $this->em->getRepository('VanessaCoreBundle:Download')
            ->findByToken($token);

        if (!$download) {
            throw new \Exception('Download not found for token:' . $token);
            $this->logger->err('Failed to find Download by token:' . $token);
        }
        return $download[0];
    }

    /**
     * Create download
     * 
     * @param stdClass $params
     * @return VanessaCoreBundle:Download
     */
    public function saveNew($params)
    {
        $this->logger->info("create new download entry");

        $download = new Download();
        $download->setCode($params->code);
        $download->setSong($params->code->getSong());
        $download->setAgency($params->code->getAgency());
        $download->setRxqueue($params->rxqueue);
        $download->setToken($this->container->get('utility.manager')->generateToken());
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
     * 
     * @param VanessaCoreBundle:Download $download
     * @return void
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
        return;
    }

}