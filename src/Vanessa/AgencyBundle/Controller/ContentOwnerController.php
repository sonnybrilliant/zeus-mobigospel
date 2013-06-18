<?php

namespace Vanessa\AgencyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Vanessa\AgencyBundle\Form\ContentOwnerCreateType;
use Vanessa\AgencyBundle\Form\ContentOwnerProfileType;
use Vanessa\AgencyBundle\Form\ContentOwnerAccountStatusUpdateType;
use Vanessa\CoreBundle\Entity\Agency;

/**
 * Content owner manager 
 * 
 * @author Mfana Ronald Conco <ronald.conco@mobigospel.co.za>
 * @package VanessaAgencyBundle
 * @subpackage Controller
 * @version 0.0.1
 */
class ContentOwnerController extends Controller
{

    /**
     * List all available content owners
     * 
     * @param integer $page
     * @return Response
     * @Secure(roles="ROLE_ADMIN,ROLE_MEMBER")
     */
    public function listAction($page = 1)
    {
        $this->get('logger')->info('list all content owners');

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
            $this->container->get('content.owner.manager')->listAll($options), $this->getRequest()->query->get('page', $page), 10);


        return $this->render('VanessaAgencyBundle:ContentOwner:list.html.twig', array(
                'pagination' => $pagination,
                'direction' => $direction,
                'isDirectionSet' => $isDirectionSet
            ));
    }

    /**
     * List all available content owner members
     * 
     * @param string $slug
     * @param integer $page
     * @return Response
     * @Secure(roles="ROLE_ADMIN,ROLE_MEMBER")
     */
    public function listMembersAction($slug, $page = 1)
    {
        $this->get('logger')->info('list all content owner members');

        try {
            $isDirectionSet = $this->get('request')->query->get('direction', false);

            $searchText = $this->get('request')->query->get('searchText');
            $sort = $this->get('request')->query->get('sort', 'm.id');
            $direction = $this->get('request')->query->get('direction', 'asc');
            $filterBy = $this->get('request')->query->get('filterBy', 0);
            
            $contentOwner = $this->get('content.owner.manager')->getBySlug($slug);
            
            $options = array('searchText' => $searchText,
                'sort' => $sort,
                'direction' => $direction,
                'filterBy' => $filterBy,
                'agency' => $contentOwner
            );

            $paginator = $this->get('knp_paginator');
            $pagination = $paginator->paginate(
                $this->container->get('member.manager')->listAgencyMembers($options), $this->getRequest()->query->get('page', $page), 10);

            
        } catch (\Exception $e) {
            $this->get('logger')->warn($e->getMessage());
            return $this->createNotFoundException($e->getMessage());
        }

        return $this->render('VanessaAgencyBundle:ContentOwner:list.members.html.twig', array(
                'pagination' => $pagination,
                'direction' => $direction,
                'isDirectionSet' => $isDirectionSet,
                'contentOwner' => $contentOwner
            ));
    }

    /**
     * Create a new content owner
     * 
     * @return Response
     * @throws AccessDeniedException
     * 
     * @Secure(roles="ROLE_ADMIN")
     */
    public function newAction()
    {
        $this->get('logger')->info('Create a new content owner');

        $contentOwner = new Agency();
        $form = $this->createForm(new ContentOwnerCreateType(), $contentOwner);
        return $this->render('VanessaAgencyBundle:ContentOwner:create.html.twig', array('form' => $form->createView()));
    }

    /**
     * Create a new content owner
     *  
     * @return Response
     * @throws AccessDeniedException 
     * 
     * @Secure(roles="ROLE_ADMIN")
     */
    public function createAction()
    {
        $this->get('logger')->info('Create a new content owner');

        $contentOwner = new Agency();
        $form = $this->createForm(new ContentOwnerCreateType(), $contentOwner);

        if ($this->getRequest()->getMethod() == 'POST') {
            $form->bindRequest($this->getRequest());

            if ($form->isValid()) {
                $this->get('content.owner.manager')->create($contentOwner);
                $this->get('utility.manager')->alert('success', 'Content owner was sucessfully created');
                return $this->redirect($this->generateUrl('vanessa_agency_content_owner_list') . '.html');
            } else {
                $this->getRequest()->getSession()->setFlash(
                    'error', 'Could not create content owner, please fix form errors!');
            }
        }
        return $this->render('VanessaAgencyBundle:ContentOwner:create.html.twig', array('form' => $form->createView()));
    }

    /**
     * Edit content owner
     *  
     * @param String $slug 
     * @return Response
     * @throws createNotFoundException
     * 
     * @Secure(roles="ROLE_ADMIN")
     */
    public function editAction($slug)
    {
        $this->get('logger')->info('edit content owner:' . $slug);

        try {
            $contentOwner = $this->get('content.owner.manager')->getBySlug($slug);
        } catch (\Exception $e) {
            $this->get('logger')->warn($e->getMessage());
            return $this->createNotFoundException($e->getMessage());
        }

        $form = $this->createForm(new ContentOwnerCreateType(), $contentOwner);

        return $this->render('VanessaAgencyBundle:ContentOwner:edit.html.twig', array(
                'form' => $form->createView(),
                'contentOwner' => $contentOwner
            ));
    }

    /**
     * Update content owner
     *  
     * @param String $slug 
     * @return Response
     * @throws createNotFoundException
     * 
     * @Secure(roles="ROLE_ADMIN")
     */
    public function updateAction($slug)
    {
        $this->get('logger')->info('update content owner:' . $slug);

        try {
            $contentOwner = $this->get('content.owner.manager')->getBySlug($slug);
        } catch (\Exception $e) {
            $this->get('logger')->warn($e->getMessage());
            return $this->createNotFoundException($e->getMessage());
        }

        $form = $this->createForm(new ContentOwnerCreateType(), $contentOwner);

        if ($this->getRequest()->getMethod() == 'POST') {
            $form->bindRequest($this->getRequest());

            if ($form->isValid()) {
                $this->get('content.owner.manager')->update($contentOwner);
                $this->get('utility.manager')->alert('success', 'Content owner was sucessfully updated');
                return $this->redirect($this->generateUrl('vanessa_agency_content_owner_list') . '.html');
            } else {
                $this->getRequest()->getSession()->setFlash(
                    'error', 'Could not update content owner, please fix form errors!');
            }
        }
        return $this->render('VanessaAgencyBundle:ContentOwner:update.html.twig', array('form' => $form->createView()));
    }

    /**
     * View content owner profile
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
        $this->get('logger')->info('profile content owner:' . $slug);

        try {
            $contentOwner = $this->get('content.owner.manager')->getBySlug($slug);
        } catch (\Exception $e) {
            $this->get('logger')->warn($e->getMessage());
            return $this->createNotFoundException($e->getMessage());
        }

        if ($contentOwner->getStatus()->getName() == "Deleted") {
            $deletedBy = $contentOwner->getDeletedBy();
            $deletedDate = $contentOwner->getDeletedAt();
            $message = 'NB, This account was deleted by "' . $deletedBy->getFullName() . '" on ' . $deletedDate->format('Y-m-d H:i A') . '.';
            $this->getRequest()->getSession()->setFlash('notice', $message);
        }

        $form = $this->createForm(new ContentOwnerProfileType(), $contentOwner);
        return $this->render('VanessaAgencyBundle:ContentOwner:profile.html.twig', array(
                'form' => $form->createView(),
                'contentOwner' => $contentOwner
            ));
    }

    /**
     * Delete content owner profile
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
        $this->get('logger')->info('profile content owner:' . $slug);

        try {
            $contentOwner = $this->get('content.owner.manager')->getBySlug($slug);
            $contentOwner = $this->get('content.owner.manager')->delete($contentOwner);
        } catch (\Exception $e) {
            $this->get('logger')->warn($e->getMessage());
            return $this->createNotFoundException($e->getMessage());
        }

        $this->get('utility.manager')->alert('success', 'Content owner was sucessfully deleted');
        return $this->redirect($this->generateUrl('vanessa_agency_content_owner_list') . '.html');
    }

    /**
     * Show content owner account status
     * 
     * @param string $slug
     * @return type
     * @throws createNotFoundException
     * 
     * @Secure(roles="ROLE_ADMIN,ROLE_MEMBER")
     */
    public function accountStatusAction($slug)
    {
        $this->get('logger')->info('content owner account status slug:' . $slug);


        try {
            $contentOwner = $this->get('content.owner.manager')->getBySlug($slug);
        } catch (\Exception $e) {
            $this->get('logger')->warn($e->getMessage());
            return $this->createNotFoundException($e->getMessage());
        }

        if ($contentOwner->getStatus()->getName() == "Deleted") {
            $deletedBy = $contentOwner->getDeletedBy();
            $deletedDate = $contentOwner->getDeletedAt();
            $message = 'NB, This account was deleted by "' . $deletedBy->getFullName() . '" on ' . $deletedDate->format('Y-m-d H:i A') . '.';
            $this->getRequest()->getSession()->setFlash('notice', $message);
        }


        return $this->render('VanessaAgencyBundle:ContentOwner:account.status.show.html.twig', array(
                'contentOwner' => $contentOwner));
    }

    /**
     * Edit content owner account status
     * 
     * @param string $slug
     * @return type
     * @throws createNotFoundException
     * 
     * @Secure(roles="ROLE_ADMIN")
     */
    public function accountStatusEditAction($slug)
    {
        $this->get('logger')->info('edit content owner account status slug:' . $slug);

        try {
            $contentOwner = $this->get('content.owner.manager')->getBySlug($slug);
        } catch (\Exception $e) {
            $this->get('logger')->warn($e->getMessage());
            return $this->createNotFoundException($e->getMessage());
        }

        if ($contentOwner->getStatus()->getName() == "Deleted") {
            $deletedBy = $contentOwner->getDeletedBy();
            $deletedDate = $contentOwner->getDeletedAt();
            $message = 'NB, This account was deleted by "' . $deletedBy->getFullName() . '" on ' . $deletedDate->format('Y-m-d H:i A') . '.';
            $this->getRequest()->getSession()->setFlash('notice', $message);
        }

        $form = $this->createForm(new ContentOwnerAccountStatusUpdateType());

        if ($this->getRequest()->getMethod() == 'POST') {
            $form->bindRequest($this->getRequest());
            if ($form->isValid()) {
                if ($contentOwner->getStatus()->getName() == "Deleted") {
                    $this->getRequest()->getSession()->setFlash('error', 'Could not update content owner status - deleted accounts can only be restored manually, consult administrator!');
                } else {
                    $data = $form->getData();
                    $accountStatus = $data['accountStatus'];
                    if ($accountStatus != '') {
                        if ($accountStatus == 'activate') {
                            $this->get('content.owner.manager')->activate($contentOwner);
                            $this->getRequest()->getSession()->setFlash('success', 'You have successfully activated content owner account.');
                        } elseif ($accountStatus == 'lock') {
                            $this->get('content.owner.manager')->lock($contentOwner);
                            $this->getRequest()->getSession()->setFlash('success', 'You have successfully locked content owner account.');
                        }
                        return $this->redirect($this->generateUrl('vanessa_agency_content_owner_list') . '.html');
                    } else {
                        $this->getRequest()->getSession()->setFlash('error', 'Could not update content owner status, please fix form errors!');
                    }
                }
            } else {
                $this->getRequest()->getSession()->setFlash('error', 'Could not update content owner status, please fix form errors!');
            }
        }

        return $this->render('VanessaAgencyBundle:ContentOwner:edit.account.status.html.twig', array(
                'contentOwner' => $contentOwner,
                'form' => $form->createView(),
            ));
    }

    /**
     * Download list of all available content owners
     * 
     * @param integer $page
     * @return Response
     * @Secure(roles="ROLE_ADMIN")
     */
    public function downloadExcelAction()
    {
        $this->get('logger')->info('Download list of all available content owners');


        $searchText = $this->get('request')->query->get('searchText');
        $sort = $this->get('request')->query->get('sort', 'a.id');
        $direction = $this->get('request')->query->get('direction', 'asc');
        $filterBy = $this->get('request')->query->get('filterBy', 0);

        $options = array('searchText' => $searchText,
            'sort' => $sort,
            'direction' => $direction,
            'filterBy' => $filterBy
        );

        $contentOwners = $this->get('content.owner.manager')->listAll($options);
        $excel = $this->get('excel.manager');
        $response = $excel->contentOwnerList($contentOwners);

        return $response;
    }

}
