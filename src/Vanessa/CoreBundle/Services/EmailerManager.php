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
        $this->setTemplate($container->get('templating'));
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

}