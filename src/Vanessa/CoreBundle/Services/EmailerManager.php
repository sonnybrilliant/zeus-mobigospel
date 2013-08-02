<?php

namespace Vanessa\CoreBundle\Services;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Monolog\Logger;

/**
 * Emailer manager
 *
 * @author Mfana Ronald Conco <ronald.conco@mobigospel.co.za>
 * @package VanessaCoreBundle
 * @subpackage Services
 * @version 0.0.1
 */
final class EmailerManager
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
     * Template engine
     * @var object 
     */
    private $template;

    /**
     * Router
     * @var object
     */
    private $router;

    /**
     * Class construct
     * 
     * @param ContainerInterface $container
     * @param Logger $logger
     * @return void 
     */
    public function __construct(
    ContainerInterface $container, Logger $logger , $router)
    {
        $this->setContainer($container);
        $this->setLogger($logger);
        $this->setEm($container->get('doctrine')->getEntityManager('default'));
        $this->setTemplate($container->get('templating'));
        $this->setRouter($router);
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

    public function setTemplate($template)
    {
        $this->template = $template;
    }

    public function getRouter()
    {
        return $this->router;
    }

    public function setRouter($router)
    {
        $this->router = $router;
    }

    /**
     * Send simple email
     * 
     * @param array $params
     * @return void
     */
    public function sendMail($params)
    {
        $this->logger->info('sending mail to:' . $params['email']);
        $message = \Swift_Message::newInstance()
            ->setSubject($params['subject'])
            ->setFrom(array(
                $this->container->getParameter('mail_send_from_email')
                => $this->container->getParameter('mail_send_from_name'))
            )
            ->setTo(array($params['email'] => $params['fullName']))
            ->setBody($params['bodyHTML'], 'text/html')
            ->addPart($params['bodyTEXT'], 'text/plain');

        ;

        $this->container->get('mailer')->send($message);
        return;
    }

    /**
     * Send forgot password email
     * 
     * @param array $params
     * @return void
     */
    public function memberForgotPassword($params)
    {
        $this->logger->info('sending forgot password email');
        $options['subject'] = "Mobigospel: Reset password";

        $member = $params['member'];

        $arguments = array(
            'fullName' => $member->getFullName(),
            'link' => $params['link'],
            'email' => $member->getEmail(),
            'date' => date('Y')
        );

        $emailBodyHtml = $this->template->render(
            'VanessaCoreBundle:Email/Html:member.password.reset.html.twig', $arguments
        );

        $emailBodyTxt = $this->template->render(
            'VanessaCoreBundle:Email/Text:member.password.reset.txt.twig', $arguments
        );

        $options['bodyHTML'] = $emailBodyHtml;
        $options['bodyTEXT'] = $emailBodyTxt;
        $options['email'] = $member->getEmail();
        $options['fullName'] = $member->getFullName();

        $this->sendMail($options);
        return;
    }

    /**
     * Send registration email
     * 
     * @param array $params
     * @return void
     */
    public function memberRegistration($params)
    {
        $this->logger->info('sending registration email');
        $options['subject'] = "Mobigospel: Your account has been created";

        $member = $params['member'];

        $arguments = array(
            'fullName' => $member->getFullName(),
            'agency' => $member->getAgency()->getName(),
            'password' => $params['password'],
            'email' => $member->getEmail(),
            'link' => $params['link']
        );

        $emailBodyHtml = $this->template->render(
            'VanessaCoreBundle:Email/Html:member.created.html.twig', $arguments
        );

        $emailBodyTxt = $this->template->render(
            'VanessaCoreBundle:Email/Text:member.created.txt.twig', $arguments
        );

        $options['bodyHTML'] = $emailBodyHtml;
        $options['bodyTEXT'] = $emailBodyTxt;
        $options['email'] = $member->getEmail();
        $options['fullName'] = $member->getFullName();

        $this->sendMail($options);
        return;
    }

    /**
     * Pending song
     * 
     * @param array $params
     * @return void
     */
    public function songPending($params)
    {
        $this->logger->info('sending song pending approval email');
        $song = $params['song'];

        $options['subject'] = "Mobigospel: Song " . $song->getTitle() . ' by ' . $song->getArtist()->getStageName() . ' pending approval';

        $member = $params['member'];

        $arguments = array(
            'fullName' => $member->getFullName(),
            'link' => $this->router->generate("vanessa_pending_list",array(),true).".html",
            'song' => $song
        );

        $emailBodyHtml = $this->template->render(
            'VanessaCoreBundle:Email/Html:song.pending.html.twig', $arguments
        );

        $emailBodyTxt = $this->template->render(
            'VanessaCoreBundle:Email/Text:song.pending.txt.twig', $arguments
        );

        $options['bodyHTML'] = $emailBodyHtml;
        $options['bodyTEXT'] = $emailBodyTxt;
        $options['email'] = $member->getEmail();
        $options['fullName'] = $member->getFullName();

        $this->sendMail($options);
        return;
    }

    /**
     * Song preview encode
     * 
     * @param array $params
     * @return void
     */
    public function songPreviewEncode($params)
    {
        $this->logger->info('sending song preview encode email');
        $song = $params['song'];

        $options['subject'] = "Mobigospel: Error on song preview encode " . $song->getTitle() . ' by ' . $song->getArtist()->getStageName();

        $member = $params['member'];

        $arguments = array(
            'fullName' => $member->getFullName(),
            'link' => $this->router->generate("vanessa_pending_list",array(),true).".html",
            'song' => $song
        );

        $emailBodyHtml = $this->template->render(
            'VanessaCoreBundle:Email/Html:song.error.preview.encode.html.twig', $arguments
        );

        $emailBodyTxt = $this->template->render(
            'VanessaCoreBundle:Email/Text:song.error.preview.encode.txt.twig', $arguments
        );

        $options['bodyHTML'] = $emailBodyHtml;
        $options['bodyTEXT'] = $emailBodyTxt;
        $options['email'] = $member->getEmail();
        $options['fullName'] = $member->getFullName();

        $this->sendMail($options);
        return;
    }

    /**
     * Song rejected
     * 
     * @param array $params
     * @return void
     */
    public function songRejected($params)
    {
        $this->logger->info('sending song rejected email');
        $song = $params['song'];

        $options['subject'] = "Mobigospel: Song " . $song->getTitle() . ' by ' . $song->getArtist()->getStageName() . ' was rejected';

        $member = $params['member'];

        $arguments = array(
            'fullName' => $member->getFullName(),
            'link' => $this->router->generate("vanessa_pending_show",array('slug'=>$song->getSlug()),true).".html",
            'song' => $song
        );

        $emailBodyHtml = $this->template->render(
            'VanessaCoreBundle:Email/Html:song.rejected.html.twig', $arguments
        );

        $emailBodyTxt = $this->template->render(
            'VanessaCoreBundle:Email/Text:song.rejected.txt.twig', $arguments
        );

        $options['bodyHTML'] = $emailBodyHtml;
        $options['bodyTEXT'] = $emailBodyTxt;
        $options['email'] = $member->getEmail();
        $options['fullName'] = $member->getFullName();

        $this->sendMail($options);
        return;
    }
    
    /**
     * Error with incoming sms
     * 
     * @param array $params
     * @return void
     */
    public function incomingSMS($params)
    {
        $this->logger->info('sending incoming sms error email');
        $message = $params['message'];

        $options['subject'] = "Mobigospel: Error SMS " . $message->msisdn . ' -  ' . $message->content;

        $member = $params['member'];

        $arguments = array(
            'fullName' => $member->getFullName(),
            'message' => $message
        );

        $emailBodyHtml = $this->template->render(
            'VanessaCoreBundle:Email/Html:sms.incoming.error.html.twig', $arguments
        );

        $emailBodyTxt = $this->template->render(
            'VanessaCoreBundle:Email/Text:sms.incoming.error.txt.twig', $arguments
        );

        $options['bodyHTML'] = $emailBodyHtml;
        $options['bodyTEXT'] = $emailBodyTxt;
        $options['email'] = $member->getEmail();
        $options['fullName'] = $member->getFullName();

        $this->sendMail($options);
        return;
    }

    /**
     * Song ready
     * 
     * @param array $params
     * @return void
     */
    public function songReady($params)
    {
        $this->logger->info('sending song encoded successful email');
        $song = $params['song'];

        $options['subject'] = "Mobigospel: Song " . $song->getTitle() . ' by ' . $song->getArtist()->getStageName() . ' has been approved';

        $member = $params['member'];

        $arguments = array(
            'fullName' => $member->getFullName(),
            'link' => $this->router->generate("vanessa_pending_show",array('slug'=>$song->getSlug()),true).".html",
            'song' => $song
        );

        $emailBodyHtml = $this->template->render(
            'VanessaCoreBundle:Email/Html:song.ready.html.twig', $arguments
        );

        $emailBodyTxt = $this->template->render(
            'VanessaCoreBundle:Email/Text:song.ready.txt.twig', $arguments
        );

        $options['bodyHTML'] = $emailBodyHtml;
        $options['bodyTEXT'] = $emailBodyTxt;
        $options['email'] = $member->getEmail();
        $options['fullName'] = $member->getFullName();

        $this->sendMail($options);
        return;
    }

}