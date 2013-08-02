<?php

namespace Vanessa\CoreBundle\Services;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Monolog\Logger;
use Vanessa\CoreBundle\Dictionary\StaticData\Alert;

/**
 * Notifications manager
 *
 * @author Mfana Ronald Conco <ronald.conco@mobigospel.co.za>
 * @package VanessaCoreBundle
 * @subpackage Services
 * @version 0.0.1
 */
final class NotificationsManager
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
     * member forgot password
     * 
     * @param Array $params
     * @return void
     */
    public function memberForgotPassword($params)
    {
        $this->logger->info("member forgot password notification");
        $this->container->get('email.manager')->memberForgotPassword($params);
        return;
    }

    /**
     * Notifify admins about song upload
     * 
     * @param VanessaCoreBundle:SongTemp $song
     * @return void
     */
    public function songUpload($song)
    {
        $this->logger->info("notification song uploaded " . $song->getTitle());

        $members = $this->getContainer()->get('member.manager')->getAllAdmin();

        $alertMessage = 'New song <strong>' . $song->getTitle() . '</strong> by <i>' . $song->getArtist()->getStageName() . '</i> was just uploaded, please review song for approval.';

        if ($members) {
            foreach ($members as $member) {

                //send alerts
                $this->container->get('alert.manager')->info($alertMessage, $member);

                //send email
                $this->container->get('email.manager')->songPending(array(
                    'member' => $member,
                    'song' => $song
                ));
            }
        }

        return;
    }

    /**
     * Notifify admins about song upload
     * 
     * @param VanessaCoreBundle:SongTemp $song
     * @return void
     */
    public function smsIncoming($message)
    {
        $this->logger->info("notification sms incoiming ");

        $members = $this->getContainer()->get('member.manager')->getAllAdmin();

        $alertMessage = 'Error, The was an error with an incoming sms. Please check your email.';

        if ($members) {
            foreach ($members as $member) {

                //send alerts
                $this->container->get('alert.manager')->error($alertMessage, $member);

                //send email
                $this->container->get('email.manager')->incomingSMS(array(
                    'member' => $member,
                    'message' => $message
                ));
            }
        }

        return;
    }

    /**
     * Notifify admins about song preview encode
     * 
     * @param VanessaCoreBundle:SongTemp $song
     * @return void
     */
    public function songPreviewEncode($song)
    {
        $this->logger->info("notification song preview encode " . $song->getTitle());

        $members = $this->getContainer()->get('member.manager')->getAllAdmin();

        $alertMessage = 'There was an error encoding song <strong>' . $song->getTitle() . '</strong> by <i>' . $song->getArtist()->getStageName() . '</i> please check error queue for more details.';

        if ($members) {
            foreach ($members as $member) {
                //send alerts
                $this->container->get('alert.manager')->error($alertMessage, $member);

                //send email
                $this->container->get('email.manager')->songPreviewEncode(array(
                    'member' => $member,
                    'song' => $song
                ));
            }
        }

        return;
    }

    /**
     * Notifify song uploader about rejection
     * 
     * @param VanessaCoreBundle:SongTemp $song
     * @return void
     */
    public function songRejected($song)
    {
        $this->logger->info("notification song rejected " . $song->getTitle());

        $alertMessage = 'Your song <strong>' . $song->getTitle() . '</strong> by <i>' . $song->getArtist()->getStageName() . '</i> was rejected by administrator, please view song profile for more details.';
        $member = $song->getCreatedBy();

        //send alerts
        $this->container->get('alert.manager')->error($alertMessage, $member);

        //send email
        $this->container->get('email.manager')->songRejected(array(
            'member' => $member,
            'song' => $song
        ));


        return;
    }

    /**
     * Notifify song uploader that song is ready
     * 
     * @param VanessaCoreBundle:SongTemp $song
     * @return void
     */
    public function songReady($song)
    {
        $this->logger->info("notification song encoded successfully " . $song->getTitle());

        $alertMessage = 'Your song  <strong>' . $song->getTitle() . '</strong> by <i>' . $song->getArtist()->getStageName() . '</i> was approved.';
        $member = $song->getCreatedBy();

        //send alerts
        $this->container->get('alert.manager')->success($alertMessage, $member);

        //send email
        $this->container->get('email.manager')->songReady(array(
            'member' => $member,
            'song' => $song
        ));


        return;
    }

    /**
     * member creation email 
     * 
     * @param Array $params
     * @return void
     */
    public function memberRegistration($params)
    {
        $this->logger->info("member registration notification");
        $this->container->get('email.manager')->memberRegistration($params);
        return;
    }

}