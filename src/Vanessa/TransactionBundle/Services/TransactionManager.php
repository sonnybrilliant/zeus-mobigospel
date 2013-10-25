<?php

namespace Vanessa\TransactionBundle\Services;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Monolog\Logger;

/**
 * Transaction manager
 *
 * @author Mfana Ronald Conco <ronald.conco@mobigospel.co.za>
 * @package VanessaTransactionBundle
 * @subpackage Services
 * @version 0.0.1
 */
final class TransactionManager
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
     * Initialize transaction
     * 
     * @param VanessaCoreBundle:Rxqueue $rxqueue $rxqueue
     * @return \Sule\CoreBundle\Entity\Download|boolean
     */
    public function process($rxqueue)
    {
        $this->logger->info("initialize transaction for rxqueueId:" . $rxqueue->getId());


        try {
            //is code valid
            $code = false;
            try{
              $code = $this->getContainer()->get('code.manager')->getByCode($rxqueue->getBody());  
            }catch(\Exception $e){
              $code = false;  
            }

            $sms = new \stdClass();

            if ($code) {
                $arguments = new \stdClass();
                $arguments->code = $code;
                $arguments->rxqueue = $rxqueue;
                $arguments->msisdn = $rxqueue->getMsisdn();
                $arguments->body = "";
                $arguments->network = $rxqueue->getNetwork();
                $arguments->isValid = true;

                $download = $this->getContainer()->get('download.manager')->saveNew($arguments);
                //update download counter
                if ($this->getContainer()->hasParameter('site_detail_url')) {
                    $arguments->body = "Follow link to download song, ";
                    $arguments->body .= $this->getContainer()->getParameter('site_detail_url').'vfg/';
                    $arguments->body .= $download->getToken().'.dlg';
                }

                $txqueue = $this->getContainer()->get('txqueue.manager')->saveNew($arguments);

                $this->getContainer()->get('code.manager')->updateCounter($code);
                $this->getContainer()->get('rxqueue.manager')->updateSuccessful($rxqueue);


                $sms->recipient = $arguments->msisdn;
                $sms->message = $arguments->body;
                $sms->refNo = $txqueue->getId();
            } else {
                $arguments = new \stdClass();
                $arguments->rxqueue = $rxqueue;
                $arguments->msisdn = $rxqueue->getMsisdn();
                $arguments->body = "Invalid code, please check your code again.";
                $arguments->isValid = false;
                $arguments->network = $rxqueue->getNetwork();
                $txqueue = $this->getContainer()->get('txqueue.manager')->saveNew($arguments);

                $sms->recipient = $arguments->msisdn;
                $sms->message = $arguments->body;
                $sms->refNo = $txqueue->getId();
                $this->getContainer()->get('rxqueue.manager')->updateCompleted($rxqueue);
            }

            $this->getContainer()->get('old_sound_rabbit_mq.sms_outgoing_producer')->publish(json_encode($sms), 'song.outgoing');
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        return true;
    }

}