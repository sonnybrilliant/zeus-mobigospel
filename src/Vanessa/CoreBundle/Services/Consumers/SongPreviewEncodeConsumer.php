<?php

namespace Vanessa\CoreBundle\Services\Consumers;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Monolog\Logger;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * Song priview encode consumer
 *
 * @author Mfana Ronald Conco <ronald.conco@mobigospel.co.za>
 * @version 0.0.1
 * @package VanessaSongBundle
 * @subpackage Services/Consumer
 */
final class SongPreviewEncodeConsumer implements ConsumerInterface
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
     * Execute
     * 
     * @param \PhpAmqpLib\Message\AMQPMessage $msg
     * @return boolean
     */
    public function execute(AMQPMessage $msg)
    {
        $this->logger->info('Song Preview Encoder consumer');
        $message = unserialize($msg->body);

        try {
            $song = $this->getContainer()->get('song.pending.manager')->getById($message['song_id']);
            $this->getContainer()->get('encoder.manager')->previewSong($song);
            $this->getContainer()->get('song.manager')->newSong($song);
            $this->getContainer()->get('song.pending.manager')->approve($song);
            //send alert
            $this->getContainer()->get('notification.manager')->songReady($song);
            
        } catch (\Exception $e) {
            //send alert and email
            $newMsg = array(
                'message' => $msg->body,
                'error' => $e->getMessage()
            );
            $this->getContainer()->get('old_sound_rabbit_mq.song_error_producer')->publish(serialize($newMsg), 'song.error');
        }

        return true;
    }

}
