<?php

namespace Vanessa\CoreBundle\Services;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Monolog\Logger;

/**
 * Utility manager
 *
 * @author Ronald Conco <ronald.conco@gmail.com>
 * @version 1.0
 * @package VanessaCoreBundle
 * @subpackage Services
 */
final class UtilityManager
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
     * Session
     * @var object 
     */
    private $session = null;    

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
        $this->setSession($this->container->get('session'));
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

    public function getSession()
    {
        return $this->session;
    }

    public function setSession($session)
    {
        $this->session = $session;
    }

    /**
     * Generate password
     * 
     * @param integer $length
     * @param integer $userUpper
     * @param integer $useLower
     * @param integer $useNumber
     * @param integer $useCustom
     * @return string
     */
    public function generatePassword($length = 8, $userUpper = 1, $useLower = 1, $useNumber = 1, $useCustom = "")
    {
        $upper = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $lower = "abcdefghijklmnopqrstuvwxyz";
        $number = "0123456789";
        $seedLength = null;
        $seed = null;
        $password = null;

        if ($userUpper) {
            $seedLength += 26;
            $seed .= $upper;
        }
        if ($useLower) {
            $seedLength += 26;
            $seed .= $lower;
        }
        if ($useNumber) {
            $seedLength += 10;
            $seed .= $number;
        }
        if ($useCustom) {
            $seedLength +=strlen($useCustom);
            $seed .= $useCustom;
        }
        for ($x = 1; $x <= $length; $x++) {
            $password .= $seed{rand(0, $seedLength - 1)};
        }
        return($password);
    }
    
    /**
     * Create alert message
     * 
     * @param string $type
     * @param string $message
     * @return void
     */
    public function alert($type,$message)
    {
        $this->session->getFlashBag()->add($type,$message);
        $this->session->getFlashBag()->add('alert-'.$type,$message);
        return;
    }
    
    public function generateToken()
    {
        return base_convert(bin2hex($this->getRandomNumber()) , 16 , 20);
    }

    private function getRandomNumber()
    {
        return hash('sha256' , uniqid(mt_rand() , true) , true);
    }    

}