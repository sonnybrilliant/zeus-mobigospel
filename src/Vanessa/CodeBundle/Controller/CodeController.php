<?php

namespace Vanessa\CodeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Vanessa\CoreBundle\Entity\Code;
use Vanessa\CodeBundle\Form\CodeCreateType;

/**
 * code manager 
 * 
 * @author Mfana Ronald Conco <ronald.conco@mobigospel.co.za>
 * @package VanessaCodeBundle
 * @subpackage Controller
 * @version 0.0.1
 */
class CodeController extends Controller
{

    /**
     * List all code
     * 
     * @param integer $page
     * @return Response
     * @Secure(roles="ROLE_ADMIN,ROLE_CODE")
     */
    public function listAction($page = 1)
    {
        $this->get('logger')->info('list all code');

        $isDirectionSet = $this->get('request')->query->get('direction', false);
        $searchText = $this->get('request')->query->get('searchText');
        $sort = $this->get('request')->query->get('sort', 'c.id');
        $direction = $this->get('request')->query->get('direction', 'asc');
        $filterBy = $this->get('request')->query->get('filterBy', 0);

        $options = array('searchText' => $searchText,
            'sort' => $sort,
            'direction' => $direction,
            'filterBy' => $filterBy
        );

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $this->container->get('code.manager')->listAll($options), $this->getRequest()->query->get('page', $page), 10);


        return $this->render('VanessaCodeBundle:Code:list.html.twig', array(
                'pagination' => $pagination,
                'direction' => $direction,
                'isDirectionSet' => $isDirectionSet
            ));
    }

    /**
     * Add a new code
     * 
     * @return Response
     * 
     * @Secure(roles="ROLE_ADMIN,ROLE_CODE")
     */
    public function newAction()
    {
        $this->get('logger')->info('Add a new code');

        $code = new Code();
        $form = $this->createForm(new CodeCreateType($this->get('member.manager')->getActiveUser()), $code);

        return $this->render('VanessaCodeBundle:Code:create.html.twig', array(
                'form' => $form->createView(),
            ));
    }

    /**
     * Add a new code
     * 
     * @return Response
     * 
     * @Secure(roles="ROLE_ADMIN,ROLE_CODE")
     */
    public function createAction()
    {
        $this->get('logger')->info('Add a new code');

        $code = new Code();
        $form = $this->createForm(new CodeCreateType($this->get('member.manager')->getActiveUser()), $code);

        if ($this->getRequest()->getMethod() == 'POST') {
            $form->bindRequest($this->getRequest());

            if ($form->isValid()) {
                $this->get('code.manager')->newCode($code);
                $this->get('utility.manager')->alert(
                    'success', 'Code was sucessfully added');
                return $this->redirect($this->generateUrl('vanessa_code_list') . '.html');
            }
        } else {
            $this->get('utility.manager')->alert('error', 'Could not create code, please fix form errors!');
        }


        return $this->render('VanessaCodeBundle:Code:create.html.twig', array(
                'form' => $form->createView(),
            ));
    }

    /**
     * edit code
     * 
     * @param string $code 
     * @return Response
     * 
     * @Secure(roles="ROLE_ADMIN,ROLE_CODE")
     */
    public function editAction($code)
    {
        $this->get('logger')->info('edit code');

        try {
            $code = $this->get('code.manager')->getByCode($code);
            $form = $this->createForm(new CodeCreateType($this->get('member.manager')->getActiveUser()), $code);
        } catch (\Exception $e) {
            $this->get('utility.manager')->alert('error', $e->getMessage());
            return $this->redirect($this->generateUrl('vanessa_code_list') . '.html');
        }

        return $this->render('VanessaCodeBundle:Code:edit.html.twig', array(
                'form' => $form->createView(),
                'code' => $code
            ));
    }

    /**
     * edit code
     * 
     * @return Response
     * 
     * @Secure(roles="ROLE_ADMIN,ROLE_CODE")
     */
    public function updateAction($code)
    {
        $this->get('logger')->info('update code:' . $code);

        try {
            $code = $this->get('code.manager')->getByCode($code);
            $form = $this->createForm(new CodeCreateType($this->get('member.manager')->getActiveUser()), $code);

            if ($this->getRequest()->getMethod() == 'POST') {
                $form->bindRequest($this->getRequest());

                if ($form->isValid()) {
                    $this->get('code.manager')->update($code);
                    $this->get('utility.manager')->alert(
                        'success', 'Code was sucessfully updated');
                    return $this->redirect($this->generateUrl('vanessa_code_list') . '.html');
                }
            } else {
                $this->get('utility.manager')->alert('error', 'Could not update code, please fix form errors!');
            }
        } catch (\Exception $e) {
            $this->get('utility.manager')->alert('error', $e->getMessage());
            return $this->redirect($this->generateUrl('vanessa_code_list') . '.html');
        }

        return $this->render('VanessaCodeBundle:Code:edit.html.twig', array(
                'form' => $form->createView(),
            ));
    }

    /**
     * disable code
     * 
     * @param string $code 
     * @return Response
     * 
     * @Secure(roles="ROLE_ADMIN,ROLE_CODE")
     */
    public function disableAction($code)
    {
        $this->get('logger')->info('disable code');

        try {
            $code = $this->get('code.manager')->getByCode($code);

            if ($code->getDownloadCounter() > 0) {
                $this->get('utility.manager')->alert(
                    'error', 'Code cannot be disabled, It has active downloads recorded.');
            } else {
                $this->get('code.manager')->disable($code);
                $this->get('utility.manager')->alert(
                    'success', 'Code was sucessfully disabled');
            }
            return $this->redirect($this->generateUrl('vanessa_code_list') . '.html');
        } catch (\Exception $e) {
            $this->get('utility.manager')->alert('error', $e->getMessage());
            return $this->redirect($this->generateUrl('vanessa_code_list') . '.html');
        }
    }

    /**
     * activate code
     * 
     * @param string $code 
     * @return Response
     * 
     * @Secure(roles="ROLE_ADMIN,ROLE_CODE")
     */
    public function activateAction($code)
    {
        $this->get('logger')->info('activate code');

        try {
            $code = $this->get('code.manager')->getByCode($code);
            $this->get('code.manager')->active($code);
            $this->get('utility.manager')->alert(
                'success', 'Code was sucessfully activated');
            return $this->redirect($this->generateUrl('vanessa_code_list') . '.html');
        } catch (\Exception $e) {
            $this->get('utility.manager')->alert('error', $e->getMessage());
            return $this->redirect($this->generateUrl('vanessa_code_list') . '.html');
        }
    }

    /**
     * Download list of all codes
     * 
     * @param integer $page
     * @return Response
     * @Secure(roles="ROLE_ADMIN,ROLE_CODE")
     */
    public function downloadExcelAction()
    {
        $this->get('logger')->info('Download list of all codes');


        $searchText = $this->get('request')->query->get('searchText');
        $sort = $this->get('request')->query->get('sort', 'c.id');
        $direction = $this->get('request')->query->get('direction', 'asc');
        $filterBy = $this->get('request')->query->get('filterBy', 0);

        $options = array('searchText' => $searchText,
            'sort' => $sort,
            'direction' => $direction,
            'filterBy' => $filterBy
        );

        $codes = $this->get('code.manager')->getAll($options);
        $excel = $this->get('excel.manager');
        $response = $excel->codesList($codes);

        return $response;
    }

}
