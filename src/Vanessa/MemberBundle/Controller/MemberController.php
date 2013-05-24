<?php

namespace Vanessa\MemberBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Vanessa\MemberBundle\Form\MemberCreateType;
use Vanessa\MemberBundle\Form\MemberUpdateType;
use Vanessa\MemberBundle\Form\MemberViewType;
use Vanessa\CoreBundle\Entity\Member;

/**
 * Member manager 
 * 
 * @author Ronald Conco <ronald.conco@gmail.com>
 * @package VanessaMemberBundle
 * @subpackage Controller
 * @version 0.0.1
 */
class MemberController extends Controller
{

    /**
     * List all available members
     * 
     * @param integer $page
     * @return Response
     * @Secure(roles="ROLE_ADMIN,ROLE_MEMBER")
     */
    public function listAction($page = 1)
    {
        $this->get('logger')->info('list all members');

        $isDirectionSet = $this->get('request')->query->get('direction', false);

        $searchText = $this->get('request')->query->get('searchText');
        $sort = $this->get('request')->query->get('sort', 'm.id');
        $direction = $this->get('request')->query->get('direction', 'asc');
        $filterBy = $this->get('request')->query->get('filterBy', 0);

        $options = array('searchText' => $searchText,
            'sort' => $sort,
            'direction' => $direction,
            'filterBy' => $filterBy
        );

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $this->container->get('member.manager')->listAll($options), $this->getRequest()->query->get('page', $page), 10);


        return $this->render('VanessaMemberBundle:Member:list.html.twig', array(
                'pagination' => $pagination,
                'direction' => $direction,
                'isDirectionSet' => $isDirectionSet
            ));
    }

    /**
     * Download list of all available members
     * 
     * @param integer $page
     * @return Response
     * @Secure(roles="ROLE_ADMIN,ROLE_MEMBER")
     */
    public function downloadExcelAction()
    {
        $this->get('logger')->info('Download list of all available members');


        $searchText = $this->get('request')->query->get('searchText');
        $sort = $this->get('request')->query->get('sort', 'm.id');
        $direction = $this->get('request')->query->get('direction', 'asc');
        $filterBy = $this->get('request')->query->get('filterBy', 0);

        $options = array('searchText' => $searchText,
            'sort' => $sort,
            'direction' => $direction,
            'filterBy' => $filterBy
        );

        $members = $this->get('member.manager')->listAll($options);

        $excel = $this->get('excel.manager');
        
        $response = $excel->memberList($members);
        
        return $response;
    }

    /**
     * Create a new member
     * 
     * @return Response
     * @throws AccessDeniedException
     * 
     * @Secure(roles="ROLE_ADMIN")
     */
    public function newAction()
    {
        $this->get('logger')->info('Create a new member');

        $member = new Member();
        $form = $this->createForm(new MemberCreateType(), $member);
        return $this->render('VanessaMemberBundle:Member:create.html.twig', array('form' => $form->createView()));
    }

    /**
     * Create a new member
     * 
     * @return Response
     * @throws AccessDeniedException
     * 
     * @Secure(roles="ROLE_ADMIN")
     */
    public function createAction()
    {
        $this->get('logger')->info('Create a new member');

        $password = null;
        $member = new Member();

        //set password
        $password = $this->get('utility.manager')->generatePassword(16);
        $member->setPassword($password);

        $form = $this->createForm(new MemberCreateType(), $member);

        if ($this->getRequest()->getMethod() == 'POST') {
            $form->bindRequest($this->getRequest());

            if ($form->isValid()) {
                $isValid = true;

                //admin role can only be assign to default agency members
                if (1 == $member->getGroup()->getId()) {
                    if (1 != $member->getAgency()->getId()) {
                        $isValid = false;
                        $agency = $this->get('agency.manager')->getById(1);
                        $this->get('utility.manager')->alert('error', 'Could not create member,the administrator group can only be assigned to members of ' . $agency->getName() . ' agency');
                    }
                }

                if ($isValid) {
                    $this->get('member.manager')->createNewMember($member);

                    $arguments = array(
                        'member' => $member,
                        'password' => $password,
                        'link' => $this->generateUrl('_security_login', array(), true)
                    );
                    //send mail
                    $this->get('notification.manager')->memberRegistration($arguments);
                    $this->get('utility.manager')->alert('success', 'Member was sucessfully created');
                    return $this->redirect($this->generateUrl('vanessa_member_list').'.html');
                }
            } else {
                $this->getRequest()->getSession()->setFlash(
                    'error', 'Could not create member, please fix form errors!');
            }
        }

        return $this->render('VanessaMemberBundle:Member:create.html.twig', array('form' => $form->createView()));
    }

    /**
     * Edit member details
     * 
     * @param integer $slug
     * @return Response
     * @throws AccessDeniedException
     * @throws createNotFoundException
     * 
     * @Secure(roles="ROLE_ADMIN,ROLE_MEMBER")
     */
    public function editAction($slug)
    {
        $this->get('logger')->info('edit member slug:' . $slug);

        try {
            $member = $this->get('member.manager')->getBySlug($slug);
        } catch (\Exception $e) {
            $this->get('logger')->warn($e->getMessage());
            return $this->createNotFoundException($e->getMessage());
        }

        $form = $this->createForm(new MemberUpdateType($this->container), $member);

        return $this->render('VanessaMemberBundle:Member:edit.html.twig', array(
                'form' => $form->createView(),
                'member' => $member));
    }

    /**
     * Update member
     * 
     * @param integer $slug
     * @return Response
     * @throws AccessDeniedException
     * 
     * @Secure(roles="ROLE_ADMIN,ROLE_MEMBER")
     */
    public function updateAction($slug)
    {
        $this->get('logger')->info('update member slug:' . $slug);

        try {
            $member = $this->get('member.manager')->getBySlug($slug);
        } catch (\Exception $e) {
            $this->get('logger')->warn($e->getMessage());
            return $this->createNotFoundException($e->getMessage());
        }

        $form = $this->createForm(new MemberUpdateType($this->container), $member);

        if ($this->getRequest()->getMethod() == 'POST') {
            $form->bindRequest($this->getRequest());
            if ($form->isValid()) {
                $isValid = true;

                //admin role can only be assign to default agency members
                if (1 == $member->getGroup()->getId()) {
                    if (1 != $member->getAgency()->getId()) {
                        $isValid = false;
                        $agency = $this->get('agency.manager')->getById(1);
                        $this->get('utility.manager')->alert('error', 'Could not create member,the administrator group can only be assigned to members of ' . $agency->getName() . ' agency');
                    }
                }

                if ($isValid) {
                    $this->get('member.manager')->update($member);
                    $this->get('utility.manager')->alert('success', 'Member was sucessfully updated.');
                    $securityContext = $this->container->get('security.context');
                    $user = $securityContext->getToken()->getUser();

                    if ($user->getIsAdmin()) {
                        return $this->redirect($this->generateUrl('vanessa_member_list'));
                    } else {
//                        return $this->redirect($this->generateUrl('sule_agency_list_members', array(
//                                    'id' => $user->getAgency()->getId(),
//                                    'agency' => $user->getAgency()->getSlug()
//                                )));
                    }
                }
            } else {
                $this->getRequest()->getSession()->setFlash('error', 'Could not update member, please fix form errors!');
            }
        }

        return $this->render('VanessaMemberBundle:Member:edit.html.twig', array(
                'form' => $form->createView(),
                'member' => $member));
    }

    /**
     * Show member profile
     * 
     * @param string $slug
     * @return type
     * @throws AccessDeniedException
     * 
     * @Secure(roles="ROLE_ADMIN,ROLE_MEMBER")
     */
    public function profileAction($slug)
    {
        $this->get('logger')->info('show member slug:' . $slug);

        try {
            $member = $this->get('member.manager')->getBySlug($slug);
        } catch (\Exception $e) {
            $this->get('logger')->warn($e->getMessage());
            return $this->createNotFoundException($e->getMessage());
        }

        $form = $this->createForm(new MemberViewType(), $member);

        return $this->render('VanessaMemberBundle:Member:show.html.twig', array(
                'form' => $form->createView(),
                'member' => $member));
    }

    /**
     * Delete member
     * 
     * @param integer $slug
     * @return Response
     * @throws AccessDeniedException
     * 
     * @Secure(roles="ROLE_ADMIN,ROLE_MEMBER")
     */
    public function deleteAction($slug)
    {
        $this->get('logger')->info('delete member slug:' . $slug);

        try {
            $this->get('member.manager')->delete($slug);
        } catch (\Exception $e) {
            $this->get('logger')->warn($e->getMessage());
            return $this->createNotFoundException($e->getMessage());
        }

        $this->get('utility.manager')->alert('success', 'Member was sucessfully deleted');
        $user = $this->get('member.manager')->getActiveUser();

        if ($user->getIsAdmin()) {
            return $this->redirect($this->generateUrl('vanessa_member_list').'.html');
        } else {
//            return $this->redirect($this->generateUrl('sule_agency_list_members', array(
//                        'id' => $user->getAgency()->getId(),
//                        'agency' => $user->getAgency()->getSlug()
//                    )));
        }
    }

}
