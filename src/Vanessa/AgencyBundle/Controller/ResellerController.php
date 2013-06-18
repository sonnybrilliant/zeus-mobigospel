<?php

namespace Vanessa\AgencyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Vanessa\AgencyBundle\Form\ResellerCreateType;
use Vanessa\AgencyBundle\Form\ResellerProfileType;
use Vanessa\AgencyBundle\Form\ResellerAccountStatusUpdateType;
use Vanessa\CoreBundle\Entity\Agency;

/**
 * Reseller manager 
 * 
 * @author Mfana Ronald Conco <ronald.conco@mobigospel.co.za>
 * @package VanessaAgencyBundle
 * @subpackage Controller
 * @version 0.0.1
 */
class ResellerController extends Controller
{

    /**
     * List all available resellers
     * 
     * @param integer $page
     * @return Response
     * @Secure(roles="ROLE_ADMIN,ROLE_MEMBER")
     */
    public function listAction($page = 1)
    {
        $this->get('logger')->info('list all resellers');

        $isDirectionSet = $this->get('request')->query->get('direction', false);

        $searchText = $this->get('request')->query->get('searchText');
        $sort = $this->get('request')->query->get('sort', 'a.id');
        $direction = $this->get('request')->query->get('direction', 'asc');
        $filterBy = $this->get('request')->query->get('filterBy', 0);

        $options = array('searchText' => $searchText,
            'sort' => $sort,
            'direction' => $direction,
            'filterBy' => $filterBy
        );

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $this->container->get('reseller.manager')->listAll($options), $this->getRequest()->query->get('page', $page), 10);


        return $this->render('VanessaAgencyBundle:Reseller:list.html.twig', array(
                'pagination' => $pagination,
                'direction' => $direction,
                'isDirectionSet' => $isDirectionSet
            ));
    }

    /**
     * List all available reseller members
     * 
     * @param string $slug
     * @param integer $page
     * @return Response
     * @Secure(roles="ROLE_ADMIN,ROLE_MEMBER")
     */
    public function listMembersAction($slug, $page = 1)
    {
        $this->get('logger')->info('list all reseller members');

        try {
            $isDirectionSet = $this->get('request')->query->get('direction', false);

            $searchText = $this->get('request')->query->get('searchText');
            $sort = $this->get('request')->query->get('sort', 'm.id');
            $direction = $this->get('request')->query->get('direction', 'asc');
            $filterBy = $this->get('request')->query->get('filterBy', 0);
            
            $reseller = $this->get('reseller.manager')->getBySlug($slug);
            
            $options = array('searchText' => $searchText,
                'sort' => $sort,
                'direction' => $direction,
                'filterBy' => $filterBy,
                'agency' => $reseller
            );

            $paginator = $this->get('knp_paginator');
            $pagination = $paginator->paginate(
                $this->container->get('member.manager')->listAgencyMembers($options), $this->getRequest()->query->get('page', $page), 10);

            
        } catch (\Exception $e) {
            $this->get('logger')->warn($e->getMessage());
            return $this->createNotFoundException($e->getMessage());
        }

        return $this->render('VanessaAgencyBundle:Reseller:list.members.html.twig', array(
                'pagination' => $pagination,
                'direction' => $direction,
                'isDirectionSet' => $isDirectionSet,
                'reseller' => $reseller
            ));
    }

    /**
     * Create a new reseller
     * 
     * @return Response
     * @throws AccessDeniedException
     * 
     * @Secure(roles="ROLE_ADMIN")
     */
    public function newAction()
    {
        $this->get('logger')->info('Create a new reseller');

        $contentOwner = new Agency();
        $form = $this->createForm(new ResellerCreateType(), $contentOwner);
        return $this->render('VanessaAgencyBundle:Reseller:create.html.twig', array('form' => $form->createView()));
    }

    /**
     * Create a new reseller
     *  
     * @return Response
     * @throws AccessDeniedException 
     * 
     * @Secure(roles="ROLE_ADMIN")
     */
    public function createAction()
    {
        $this->get('logger')->info('Create a new reseller');

        $contentOwner = new Agency();
        $form = $this->createForm(new ResellerCreateType(), $contentOwner);

        if ($this->getRequest()->getMethod() == 'POST') {
            $form->bindRequest($this->getRequest());

            if ($form->isValid()) {
                $this->get('reseller.manager')->create($contentOwner);
                $this->get('utility.manager')->alert('success', 'Reseller was sucessfully created');
                return $this->redirect($this->generateUrl('vanessa_agency_reseller_list') . '.html');
            } else {
                $this->getRequest()->getSession()->setFlash(
                    'error', 'Could not create reseller, please fix form errors!');
            }
        }
        return $this->render('VanessaAgencyBundle:Reseller:create.html.twig', array('form' => $form->createView()));
    }
    
    /**
     * Edit a reseller
     *  
     * @param String $slug 
     * @return Response
     * @throws createNotFoundException
     * 
     * @Secure(roles="ROLE_ADMIN")
     */
    public function editAction($slug)
    {
        $this->get('logger')->info('reseller:' . $slug);

        try {
            $reseller = $this->get('reseller.manager')->getBySlug($slug);
        } catch (\Exception $e) {
            $this->get('logger')->warn($e->getMessage());
            return $this->createNotFoundException($e->getMessage());
        }

        $form = $this->createForm(new ResellerCreateType(), $reseller);

        return $this->render('VanessaAgencyBundle:Reseller:edit.html.twig', array(
                'form' => $form->createView(),
                'reseller' => $reseller
            ));
    }

    /**
     * Update reseller
     *  
     * @param String $slug 
     * @return Response
     * @throws createNotFoundException
     * 
     * @Secure(roles="ROLE_ADMIN")
     */
    public function updateAction($slug)
    {
        $this->get('logger')->info('update reseller:' . $slug);

        try {
            $reseller = $this->get('reseller.manager')->getBySlug($slug);
        } catch (\Exception $e) {
            $this->get('logger')->warn($e->getMessage());
            return $this->createNotFoundException($e->getMessage());
        }

        $form = $this->createForm(new ResellerCreateType(), $reseller);

        if ($this->getRequest()->getMethod() == 'POST') {
            $form->bindRequest($this->getRequest());

            if ($form->isValid()) {
                $this->get('reseller.manager')->update($reseller);
                $this->get('utility.manager')->alert('success', 'Reseller was sucessfully updated');
                return $this->redirect($this->generateUrl('vanessa_agency_reseller_list') . '.html');
            } else {
                $this->getRequest()->getSession()->setFlash(
                    'error', 'Could not update reseller, please fix form errors!');
            }
        }
        return $this->render('VanessaAgencyBundle:Reseller:update.html.twig', array('form' => $form->createView()));
    }

    /**
     * View reseller profile
     *  
     * 
     * @param String $slug 
     * @return Response
     * @throws createNotFoundException
     * 
     * @Secure(roles="ROLE_ADMIN")
     */
    public function profileAction($slug)
    {
        $this->get('logger')->info('profile reseller:' . $slug);

        try {
            $reseller = $this->get('reseller.manager')->getBySlug($slug);
        } catch (\Exception $e) {
            $this->get('logger')->warn($e->getMessage());
            return $this->createNotFoundException($e->getMessage());
        }

        if ($reseller->getStatus()->getName() == "Deleted") {
            $deletedBy = $reseller->getDeletedBy();
            $deletedDate = $reseller->getDeletedAt();
            $message = 'NB, This account was deleted by "' . $deletedBy->getFullName() . '" on ' . $deletedDate->format('Y-m-d H:i A') . '.';
            $this->getRequest()->getSession()->setFlash('notice', $message);
        }

        $form = $this->createForm(new ResellerProfileType(), $reseller);
        return $this->render('VanessaAgencyBundle:Reseller:profile.html.twig', array(
                'form' => $form->createView(),
                'reseller' => $reseller
            ));
    }

    /**
     * Delete reseller profile
     *  
     * 
     * @param String $slug 
     * @return Response
     * @throws createNotFoundException
     * 
     * @Secure(roles="ROLE_ADMIN")
     */
    public function deleteAction($slug)
    {
        $this->get('logger')->info('profile reseller:' . $slug);

        try {
            $reseller = $this->get('reseller.manager')->getBySlug($slug);
            $reseller = $this->get('reseller.manager')->delete($reseller);
        } catch (\Exception $e) {
            $this->get('logger')->warn($e->getMessage());
            return $this->createNotFoundException($e->getMessage());
        }

        $this->get('utility.manager')->alert('success', 'Reseller was sucessfully deleted');
        return $this->redirect($this->generateUrl('vanessa_agency_reseller_list') . '.html');
    } 
    
    /**
     * Show reseller account status
     * 
     * @param string $slug
     * @return type
     * @throws createNotFoundException
     * 
     * @Secure(roles="ROLE_ADMIN,ROLE_MEMBER")
     */
    public function accountStatusAction($slug)
    {
        $this->get('logger')->info('reseller account status slug:' . $slug);


        try {
            $reseller = $this->get('reseller.manager')->getBySlug($slug);
        } catch (\Exception $e) {
            $this->get('logger')->warn($e->getMessage());
            return $this->createNotFoundException($e->getMessage());
        }

        if ($reseller->getStatus()->getName() == "Deleted") {
            $deletedBy = $reseller->getDeletedBy();
            $deletedDate = $reseller->getDeletedAt();
            $message = 'NB, This account was deleted by "' . $deletedBy->getFullName() . '" on ' . $deletedDate->format('Y-m-d H:i A') . '.';
            $this->getRequest()->getSession()->setFlash('notice', $message);
        }


        return $this->render('VanessaAgencyBundle:Reseller:account.status.show.html.twig', array(
                'reseller' => $reseller));
    }

    /**
     * Edit reseller account status
     * 
     * @param string $slug
     * @return type
     * @throws createNotFoundException
     * 
     * @Secure(roles="ROLE_ADMIN")
     */
    public function accountStatusEditAction($slug)
    {
        $this->get('logger')->info('edit reseller account status slug:' . $slug);

        try {
            $reseller = $this->get('reseller.manager')->getBySlug($slug);
        } catch (\Exception $e) {
            $this->get('logger')->warn($e->getMessage());
            return $this->createNotFoundException($e->getMessage());
        }

        if ($reseller->getStatus()->getName() == "Deleted") {
            $deletedBy = $reseller->getDeletedBy();
            $deletedDate = $reseller->getDeletedAt();
            $message = 'NB, This account was deleted by "' . $deletedBy->getFullName() . '" on ' . $deletedDate->format('Y-m-d H:i A') . '.';
            $this->getRequest()->getSession()->setFlash('notice', $message);
        }

        $form = $this->createForm(new ResellerAccountStatusUpdateType());

        if ($this->getRequest()->getMethod() == 'POST') {
            $form->bindRequest($this->getRequest());
            if ($form->isValid()) {
                if ($reseller->getStatus()->getName() == "Deleted") {
                    $this->getRequest()->getSession()->setFlash('error', 'Could not update reseller status - deleted accounts can only be restored manually, consult administrator!');
                } else {
                    $data = $form->getData();
                    $accountStatus = $data['accountStatus'];
                    if ($accountStatus != '') {
                        if ($accountStatus == 'activate') {
                            $this->get('reseller.manager')->activate($reseller);
                            $this->getRequest()->getSession()->setFlash('success', 'You have successfully activated reseller account.');
                        } elseif ($accountStatus == 'lock') {
                            $this->get('reseller.manager')->lock($reseller);
                            $this->getRequest()->getSession()->setFlash('success', 'You have successfully locked reseller account.');
                        }
                        return $this->redirect($this->generateUrl('vanessa_agency_reseller_list') . '.html');
                    } else {
                        $this->getRequest()->getSession()->setFlash('error', 'Could not update reseller status, please fix form errors!');
                    }
                }
            } else {
                $this->getRequest()->getSession()->setFlash('error', 'Could not update reseller status, please fix form errors!');
            }
        }

        return $this->render('VanessaAgencyBundle:Reseller:edit.account.status.html.twig', array(
                'reseller' => $reseller,
                'form' => $form->createView(),
            ));
    }

    /**
     * Download list of all available resellers
     * 
     * @param integer $page
     * @return Response
     * @Secure(roles="ROLE_ADMIN")
     */
    public function downloadExcelAction()
    {
        $this->get('logger')->info('Download list of all available resellers');


        $searchText = $this->get('request')->query->get('searchText');
        $sort = $this->get('request')->query->get('sort', 'a.id');
        $direction = $this->get('request')->query->get('direction', 'asc');
        $filterBy = $this->get('request')->query->get('filterBy', 0);

        $options = array('searchText' => $searchText,
            'sort' => $sort,
            'direction' => $direction,
            'filterBy' => $filterBy
        );

        $resellers = $this->get('reseller.manager')->listAll($options);
        $excel = $this->get('excel.manager');
        $response = $excel->resellerList($resellers);

        return $response;
    }    

}
