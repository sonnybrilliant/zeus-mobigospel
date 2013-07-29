<?php

namespace Vanessa\SongBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Vanessa\CoreBundle\Entity\SongTemp;
use Vanessa\SongBundle\Form\SongCreateType;
use Vanessa\SongBundle\Form\SongUpdateType;
use Vanessa\SongBundle\Form\SongRejectType;
use Vanessa\SongBundle\Form\SongShowType;
use Vanessa\CoreBundle\Dictionary\StaticData\Alert;

/**
 * Pending song manager 
 * 
 * @author Mfana Ronald Conco <ronald.conco@mobigospel.co.za>
 * @package VanessaSongBundle
 * @subpackage Controller
 * @version 0.0.1
 */
class PendingController extends Controller
{

    /**
     * List all pending songs
     * 
     * @param integer $page
     * @return Response
     * @Secure(roles="ROLE_ADMIN,ROLE_SONG")
     */
    public function listAction($page = 1)
    {
        $this->get('logger')->info('list all pending songs');
        
        $isDirectionSet = $this->get('request')->query->get('direction', false);
        $searchText = $this->get('request')->query->get('searchText');
        $sort = $this->get('request')->query->get('sort', 's.id');
        $direction = $this->get('request')->query->get('direction', 'asc');
        $filterBy = $this->get('request')->query->get('filterBy', 0);

        $options = array('searchText' => $searchText,
            'sort' => $sort,
            'direction' => $direction,
            'filterBy' => $filterBy
        );

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $this->container->get('song.pending.manager')->listAll($options), $this->getRequest()->query->get('page', $page), 10);


        return $this->render('VanessaSongBundle:Pending:list.html.twig', array(
                'pagination' => $pagination,
                'direction' => $direction,
                'isDirectionSet' => $isDirectionSet
            ));
    }

    /**
     * Add a new song
     * 
     * @return Response
     * 
     * @Secure(roles="ROLE_ADMIN,ROLE_SONG")
     */
    public function newAction()
    {
        $this->get('logger')->info('Add a new song');

        $pending = new SongTemp();
        $form = $this->createForm(new SongCreateType($this->get('member.manager')->getActiveUser()), $pending);

        $mobileDetector = $this->get('mobile_detect.mobile_detector');
        $isIpad = $mobileDetector->isIpad();

        return $this->render('VanessaSongBundle:Pending:create.html.twig', array(
                'form' => $form->createView(),
                'isIpad' => $isIpad)
        );
    }

    /**
     * upload a new song
     * 
     * @return Response
     * @throws AccessDeniedException
     * 
     * @Secure(roles="ROLE_ADMIN,ROLE_SONG")
     */
    public function addAction()
    {
        $this->get('logger')->info('upload a new song');

        $song = new SongTemp();
        $form = $this->createForm(new SongCreateType($this->get('member.manager')->getActiveUser()), $song);

        if ($this->getRequest()->getMethod() == 'POST') {
            $form->bindRequest($this->getRequest());

            if ($form->isValid()) {
                $this->get('song.pending.manager')->newSong($song);
                $this->get('utility.manager')->alert(
                    'success', 'Song was sucessfully added');

                //send alert and email
                $this->get('notification.manager')->songUpload($song);
                return $this->redirect($this->generateUrl('vanessa_pending_list') . '.html');
            } else {
                if ($form->getErrors()) {
                    foreach ($form->getErrors() as $error) {
                        if ($error->getMessageTemplate() == "The uploaded file was too large. Please try to upload a smaller file.") {
                            $this->get('utility.manager')->alert(
                                'error', $error->getMessageTemplate());
                        } else {
                            $this->get('utility.manager')->alert(
                                'error', 'Could not add song, please fix form errors!');
                        }
                    }
                }
            }
        }

        $mobileDetector = $this->get('mobile_detect.mobile_detector');
        $isIpad = $mobileDetector->isIpad();

        return $this->render('VanessaSongBundle:Pending:create.html.twig', array(
                'form' => $form->createView(),
                'isIpad' => $isIpad
            ));
    }

    /**
     * edit song
     * 
     * @return Response
     * @param string $slug 
     * 
     * @Secure(roles="ROLE_ADMIN,ROLE_SONG")
     */
    public function editAction($slug)
    {
        $this->get('logger')->info('edit song slug:' . $slug);

        $song = $this->get('song.pending.manager')->getBySlug($slug);
        $form = $this->createForm(new SongUpdateType($this->get('member.manager')->getActiveUser()), $song);

        $mobileDetector = $this->get('mobile_detect.mobile_detector');
        $isIpad = $mobileDetector->isIpad();

        return $this->render('VanessaSongBundle:Pending:edit.html.twig', array(
                'form' => $form->createView(),
                'isIpad' => $isIpad,
                'song' => $song
            ));
    }

    /**
     * upload a new song
     * 
     * @return Response
     * @param string $slug 
     * 
     * @Secure(roles="ROLE_ADMIN,ROLE_SONG")
     */
    public function updateAction($slug)
    {
        $this->get('logger')->info('update song slug:' . $slug);

        $song = $this->get('song.pending.manager')->getBySlug($slug);
        $form = $this->createForm(new SongUpdateType($this->get('member.manager')->getActiveUser()), $song);

        if ($this->getRequest()->getMethod() == 'POST') {
            $form->bindRequest($this->getRequest());

            if ($form->isValid()) {
                $this->get('song.pending.manager')->update($song);
                $this->get('utility.manager')->alert(
                    'success', 'Song was sucessfully updated');

                //send alert and email
                $this->get('notification.manager')->songUpload($song);
                return $this->redirect($this->generateUrl('vanessa_pending_list') . '.html');
            } else {
                if ($form->getErrors()) {
                    foreach ($form->getErrors() as $error) {
                        if ($error->getMessageTemplate() == "The uploaded file was too large. Please try to upload a smaller file.") {
                            $this->get('utility.manager')->alert(
                                'error', $error->getMessageTemplate());
                        } else {
                            $this->get('utility.manager')->alert(
                                'error', 'Could not update song, please fix form errors!');
                        }
                    }
                }
            }
        }

        $mobileDetector = $this->get('mobile_detect.mobile_detector');
        $isIpad = $mobileDetector->isIpad();

        return $this->render('VanessaSongBundle:Pending:edit.html.twig', array(
                'form' => $form->createView(),
                'isIpad' => $isIpad,
                'song' => $song
            ));
    }

    /**
     * reject new song
     * 
     * @return Response
     * @param string $slug 
     * 
     * @Secure(roles="ROLE_ADMIN,ROLE_SONG")
     */
    public function rejectAction($slug)
    {
        $this->get('logger')->info('update song slug:' . $slug);

        $song = $this->get('song.pending.manager')->getBySlug($slug);
        $form = $this->createForm(new SongRejectType());

        if ($this->getRequest()->getMethod() == 'POST') {
            $form->bindRequest($this->getRequest());

            $data = $form->getData();
            $message = $data['message'];

            if ($message != "") {
                $message = strip_tags($message);
                $song->setRejectMessage($message);
                $this->get('song.pending.manager')->reject($song);
                $this->get('notification.manager')->songRejected($song);
                $this->get('utility.manager')->alert(
                    'success', 'Song was sucessfully rejected');
                return $this->redirect($this->generateUrl('vanessa_pending_list') . '.html');
            } else {
                $this->get('utility.manager')->alert('error', 'Please state a reason for the rejection!');
            }
        }

        return $this->render('VanessaSongBundle:Pending:reject.html.twig', array(
                'form' => $form->createView(),
                'song' => $song
            ));
    }

    /**
     * approved song
     * 
     * @return Response
     * @param string $slug 
     * 
     * @Secure(roles="ROLE_ADMIN,ROLE_SONG")
     */
    public function approveAction($slug)
    {
        $this->get('logger')->info('update song slug:' . $slug);

        $song = $this->get('song.pending.manager')->getBySlug($slug);
        $this->get('song.pending.manager')->startEncoding($song);
        
        $msg = array('song_id' => $song->getId());
        $this->get('old_sound_rabbit_mq.song_full_encode_producer')->publish(serialize($msg),'song.full.encode');
        
        $this->get('utility.manager')->alert(
            'success', 'Song was sucessfully approved');
        return $this->redirect($this->generateUrl('vanessa_pending_list') . '.html');
    }

    /**
     * show song
     * 
     * @return Response
     * @param string $slug 
     * 
     * @Secure(roles="ROLE_ADMIN,ROLE_SONG")
     */
    public function showAction($slug)
    {
        $this->get('logger')->info('show song slug:' . $slug);

        $song = $this->get('song.pending.manager')->getBySlug($slug);
        $form = $this->createForm(new SongShowType(), $song);

        return $this->render('VanessaSongBundle:Pending:show.html.twig', array(
                'form' => $form->createView(),
                'song' => $song
            ));
    }
    
    
    /**
     * Download list of all pending songs
     * 
     * @param integer $page
     * @return Response
     * @Secure(roles="ROLE_ADMIN,ROLE_SONG")
     */
    public function downloadExcelAction()
    {
        $this->get('logger')->info('Download list of all pending songs');


        $searchText = $this->get('request')->query->get('searchText');
        $sort = $this->get('request')->query->get('sort', 's.id');
        $direction = $this->get('request')->query->get('direction', 'asc');
        $filterBy = $this->get('request')->query->get('filterBy', 0);

        $options = array('searchText' => $searchText,
            'sort' => $sort,
            'direction' => $direction,
            'filterBy' => $filterBy
        );

        $songs = $this->get('song.pending.manager')->getAll($options);
        $excel = $this->get('excel.manager');
        $response = $excel->pendingSongList($songs);

        return $response;
    }      
    

}
