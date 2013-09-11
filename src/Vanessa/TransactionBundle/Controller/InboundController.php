<?php

namespace Vanessa\TransactionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Vanessa\TransactionBundle\Form\InboundViewType;

/**
 * Inbound manager
 * 
 * @author Mfana Ronald Conco <ronald.conco@mobigospel.co.za>
 * @package VanessaTransactionBundle
 * @subpackage Controller
 * @version 0.0.1
 */
class InboundController extends Controller
{

    /**
     * List all inbound
     * 
     * @param integer $page
     * @return Response
     * @Secure(roles="ROLE_ADMIN")
     */
    public function listAction($page = 1)
    {
        $this->get('logger')->info('list all inbound sms');

        $isDirectionSet = $this->get('request')->query->get('direction', false);
        $searchText = $this->get('request')->query->get('searchText');
        $sort = $this->get('request')->query->get('sort', 'r.id');
        $direction = $this->get('request')->query->get('direction', 'asc');
        $filterBy = $this->get('request')->query->get('filterBy', 0);

        $options = array('searchText' => $searchText,
            'sort' => $sort,
            'direction' => $direction,
            'filterBy' => $filterBy
        );

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $this->container->get('rxqueue.manager')->listAll($options), $this->getRequest()->query->get('page', $page), 10);


        return $this->render('VanessaTransactionBundle:Inbound:list.html.twig', array(
                'pagination' => $pagination,
                'direction' => $direction,
                'isDirectionSet' => $isDirectionSet
            ));
    }

    /**
     * View inbound message
     * 
     * @param integer $id
     * @return Response
     * @Secure(roles="ROLE_ADMIN")
     */
    public function showAction($id)
    {
        $this->get('logger')->info('view inbound message :'.$id);

        try {
            $rxqueue = $this->get('rxqueue.manager')->getById($id);
            $form = $this->createForm(new InboundViewType(), $rxqueue);
        } catch (\Exception $e) {
            //$this->get('utility.manager')->alert('error', $e->getMessage());
            //return $this->redirect($this->generateUrl('vanessa_transaction_inbound_list') . '.html');
        }

        return $this->render('VanessaTransactionBundle:Inbound:show.html.twig', array(
                'form' => $form->createView(),
                'rxqueue' => $rxqueue
            ));
    }

    /**
     * Download list of all inbound sms
     * 
     * @param integer $page
     * @return Response
     * @Secure(roles="ROLE_ADMIN")
     */
    public function downloadExcelAction()
    {
        $this->get('logger')->info('Download list of all inbound sms');

        $searchText = $this->get('request')->query->get('searchText');
        $sort = $this->get('request')->query->get('sort', 'r.id');
        $direction = $this->get('request')->query->get('direction', 'asc');
        $filterBy = $this->get('request')->query->get('filterBy', 0);

        $options = array('searchText' => $searchText,
            'sort' => $sort,
            'direction' => $direction,
            'filterBy' => $filterBy
        );

        $inbounds = $this->container->get('rxqueue.manager')->getAll($options);
        $excel = $this->get('excel.manager');
        $response = $excel->InboundList($inbounds);

        return $response;
    }

}
