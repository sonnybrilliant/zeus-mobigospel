<?php

namespace Vanessa\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Info helper 
 * 
 * @author Mfana Ronald Conco <ronald.conco@mobigospel.co.za>
 * @package VanessaCoreBundle
 * @subpackage Controller
 * @version 0.0.1
 */
class InfoController extends Controller
{
    /**
     * Roles
     * 
     * @return 
     */
    public function rolesAction()
    {
        $this->get('logger')->info('get member roles info');
        $em = $this->getDoctrine()->getEntityManager();
        $roles = $em->getRepository('VanessaCoreBundle:Group')->findAll();

        return $this->render('VanessaCoreBundle:Info:member.role.info.html.twig' ,
                        array ('roles' => $roles));
    }
}
