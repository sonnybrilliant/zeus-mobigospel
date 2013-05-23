<?php

namespace Vanessa\MemberBundle\Controller ;

use Symfony\Bundle\FrameworkBundle\Controller\Controller ;
use Symfony\Component\Security\Core\SecurityContext ;
use Symfony\Component\Form\Extension\Csrf\CsrfProvider\DefaultCsrfProvider;


/**
 * Site security
 * 
 * @author Mfana Ronald Conco <ronald.conco@mobigospel.co.za>
 * @package VanessaCoreBundle
 * @subpackage Controller
 * @version 0.0.1
 */
class SecurityController extends Controller
{
    /**
     * Login page
     */
    public function loginAction()
    {
        $mobileDetector = $this->get('mobile_detect.mobile_detector');
        
        if($mobileDetector->isMobile() && !$mobileDetector->isTablet()){
            //return $this->redirect($this->generateUrl('sule_mobile_welcome'));
        }
        
        $error = null;

        if ($this->getRequest()->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
           $error = $this->getRequest()->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $this->getRequest()->getSession()->get(SecurityContext::AUTHENTICATION_ERROR);
        }

        $token = new DefaultCsrfProvider($this->container->getParameter('secret'));
        $csrf = $token->generateCsrfToken(md5(time()));

        return $this->render('VanessaMemberBundle:Security:login.html.twig', array(
          'last_username' => $this->getRequest()->getSession()->get(SecurityContext::LAST_USERNAME),
          'error' => $error,
          'csrf_token' => $csrf
        ));
    }

}
