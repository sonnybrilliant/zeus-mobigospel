<?php

namespace Vanessa\MemberBundle\EventListener;

use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Routing\Router;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\SecurityContext;

/**
 * Vanessa\MemberBundle\EventListener\SecurityListener
 *
 * @author Mfana Ronald Conco <ronald.conco@mobigospel.co.za>
 * @version 0.0.1
 * @package VanessaMemberBundle
 * @subpackage EventListener
 */
class SecurityListener
{

    /**
     * @var Router $router
     */
    private $router;

    /**
     * @var SecurityContext $security
     */
    private $security;

    /**
     * @var boolean $redirectToAdmin
     */
    private $redirectToAdmin = false;

    /**
     *
     * @var boolean $isLoggedIn
     */
    private $isLoggedIn = false;

    /**
     * Constructs a new instance of SecurityListener.
     *
     * @param Router          $router   The router
     * @param SecurityContext $security The security context
     */
    public function __construct(Router $router, SecurityContext $security)
    {
        $this->router = $router;
        $this->security = $security;
    }

    /**
     * Invoked after a successful login.
     *
     * @param InteractiveLoginEvent $event The event
     */
    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        if ($this->security->getToken()->getUser()) {
            $this->isLoggedIn = true;
        }

        if ($this->security->isGranted('ROLE_ADMIN')) {
            $this->redirectToAdmin = true;
        }
    }

    /**
     * Invoked after the response has been created.
     *
     * @param FilterResponseEvent $event The event
     */
    public function onKernelResponse(FilterResponseEvent $event)
    {
        if ($this->isLoggedIn) {

            if ($this->redirectToAdmin) {
                $event->setResponse(new RedirectResponse($this->router->generate('vanessa_member_list').".html"));
            } else {
                //$event->setResponse(new RedirectResponse($this->router->generate('sule_artist_list')));
            }
        }
    }

}
