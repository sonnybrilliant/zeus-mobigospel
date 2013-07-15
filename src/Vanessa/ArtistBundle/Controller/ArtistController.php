<?php

namespace Vanessa\ArtistBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Vanessa\CoreBundle\Entity\Artist;
use Vanessa\ArtistBundle\Form\ArtistCreateType;
use Vanessa\ArtistBundle\Form\ArtistShowType;
use Vanessa\ArtistBundle\Form\AccountStatusUpdateType;

class ArtistController extends Controller
{

    /**
     * List all available artists
     * 
     * @param integer $page
     * @return Response
     * @Secure(roles="ROLE_ADMIN,ROLE_ARTIST")
     */
    public function listAction($page = 1)
    {
        $this->get('logger')->info('list all artists');

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
            $this->container->get('artist.manager')->listAll($options), $this->getRequest()->query->get('page', $page), 10);


        return $this->render('VanessaArtistBundle:Artist:list.html.twig', array(
                'pagination' => $pagination,
                'direction' => $direction,
                'isDirectionSet' => $isDirectionSet
            ));
    }

    /**
     * create a new artist
     * 
     * @return Response
     * 
     * @Secure(roles="ROLE_ADMIN,ROLE_ARTIST")
     */
    public function newAction()
    {
        $this->get('logger')->info('create a new artist');

        $artist = new Artist();
        $form = $this->createForm(new ArtistCreateType($this->container), $artist);

        $mobileDetector = $this->get('mobile_detect.mobile_detector');
        $isIpad = $mobileDetector->isIpad();

        return $this->render('VanessaArtistBundle:Artist:create.html.twig', array(
                'form' => $form->createView(),
                'isIpad' => $isIpad,
            ));
    }

    /**
     * create a new artist
     * 
     * @return Response
     * @throws AccessDeniedException
     * 
     * @Secure(roles="ROLE_ADMIN,ROLE_ARTIST")
     */
    public function createAction()
    {
        $this->get('logger')->info('create a new artist');

        $artist = new Artist();
        $form = $this->createForm(new ArtistCreateType($this->container), $artist);

        if ($this->getRequest()->getMethod() == 'POST') {
            $form->bindRequest($this->getRequest());

            if ($form->isValid()) {

                $this->get('artist.manager')->create($artist);
                $this->get('utility.manager')->alert('success', 'Artist was sucessfully created.');
                return $this->redirect($this->generateUrl('vanessa_artist_list') . '.html');
            } else {
                $this->get('utility.manager')->alert('error', 'Could not create artist, please fix form errors!');
            }
        }

        $mobileDetector = $this->get('mobile_detect.mobile_detector');
        $isIpad = $mobileDetector->isIpad();

        return $this->render('VanessaArtistBundle:Artist:create.html.twig', array(
                'form' => $form->createView(),
                'isIpad' => $isIpad,
            ));
    }

    /**
     * Edit artist
     *  
     * @param String $slug 
     * @return Response
     * @throws createNotFoundException
     * 
     * @Secure(roles="ROLE_ADMIN,ROLE_ARTIST")
     */
    public function editAction($slug)
    {
        $this->get('logger')->info('edit artist:' . $slug);

        try {
            $artist = $this->get('artist.manager')->getBySlug($slug);
        } catch (\Exception $e) {
            $this->get('logger')->warn($e->getMessage());
            return $this->createNotFoundException($e->getMessage());
        }

        $form = $this->createForm(new ArtistCreateType($this->container), $artist);

        $mobileDetector = $this->get('mobile_detect.mobile_detector');
        $isIpad = $mobileDetector->isIpad();

        return $this->render('VanessaArtistBundle:Artist:edit.html.twig', array(
                'form' => $form->createView(),
                'isIpad' => $isIpad,
                'artist' => $artist
            ));
    }

    /**
     * Update artist
     *  
     * @param String $slug 
     * @return Response
     * @throws createNotFoundException
     * 
     * @Secure(roles="ROLE_ADMIN,ROLE_ARTIST")
     */
    public function updateAction($slug)
    {
        $this->get('logger')->info('update artist:' . $slug);

        try {
            $artist = $this->get('artist.manager')->getBySlug($slug);
        } catch (\Exception $e) {
            $this->get('logger')->warn($e->getMessage());
            return $this->createNotFoundException($e->getMessage());
        }

        $form = $this->createForm(new ArtistCreateType($this->container), $artist);

        if ($this->getRequest()->getMethod() == 'POST') {
            $form->bindRequest($this->getRequest());

            if ($form->isValid()) {
                $artist->setUpdatedAt(new \DateTime());
                $this->get('artist.manager')->update($artist);
                $this->get('utility.manager')->alert('success', 'Artist was sucessfully updated.');
                return $this->redirect($this->generateUrl('vanessa_artist_list') . '.html');
            } else {
                $this->get('utility.manager')->alert('error', 'Could not update artist, please fix form errors!');
            }
        }

        $mobileDetector = $this->get('mobile_detect.mobile_detector');
        $isIpad = $mobileDetector->isIpad();

        return $this->render('VanessaArtistBundle:Artist:edit.html.twig', array(
                'form' => $form->createView(),
                'isIpad' => $isIpad,
                'artist' => $artist
            ));
    }

    /**
     * Delete artist profile
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
        $this->get('logger')->info('delete artist:' . $slug);

        try {
            $artist = $this->get('artist.manager')->getBySlug($slug);

            if ($artist->getIsDeleted()) {
                $this->get('utility.manager')->alert('error', 'Artist is already deleted.');
            } else {
                $artist = $this->get('artist.manager')->delete($artist);
                $this->get('utility.manager')->alert('success', 'Artist was sucessfully deleted.');
            }
        } catch (\Exception $e) {
            $this->get('logger')->warn($e->getMessage());
            return $this->createNotFoundException($e->getMessage());
        }

        return $this->redirect($this->generateUrl('vanessa_artist_list') . '.html');
    }

    /**
     * Artist profile
     *  
     * @param String $slug 
     * @return Response
     * @throws createNotFoundException
     * 
     * @Secure(roles="ROLE_ADMIN,ROLE_ARTIST")
     */
    public function profileAction($slug)
    {
        $this->get('logger')->info('artist profile:' . $slug);

        try {
            $artist = $this->get('artist.manager')->getBySlug($slug);
        } catch (\Exception $e) {
            $this->get('logger')->warn($e->getMessage());
            return $this->createNotFoundException($e->getMessage());
        }

        $form = $this->createForm(new ArtistShowType($this->container), $artist);

        return $this->render('VanessaArtistBundle:Artist:profile.html.twig', array(
                'form' => $form->createView(),
                'artist' => $artist,
                'isGroup' => $artist->getIsGroup()
            ));
    }

    /**
     * Account status show 
     *  
     * @param String $slug 
     * @return Response
     * @throws createNotFoundException
     * 
     * @Secure(roles="ROLE_ADMIN,ROLE_ARTIST")
     */
    public function accountStatusShowAction($slug)
    {
        $this->get('logger')->info('artist account status show:' . $slug);

        try {
            $artist = $this->get('artist.manager')->getBySlug($slug);
        } catch (\Exception $e) {
            $this->get('logger')->warn($e->getMessage());
            return $this->createNotFoundException($e->getMessage());
        }


        return $this->render('VanessaArtistBundle:Artist:account.status.show.html.twig', array(
                'artist' => $artist
            ));
    }

    /**
     * Edit artist account status
     * 
     * @param string $slug
     * @return type
     * @throws createNotFoundException
     * 
     * @Secure(roles="ROLE_ADMIN,ROLE_ARTIST")
     */
    public function accountStatusEditAction($slug)
    {
        $this->get('logger')->info('edit artist account status slug:' . $slug);

        try {
            $artist = $this->get('artist.manager')->getBySlug($slug);
        } catch (\Exception $e) {
            $this->get('logger')->warn($e->getMessage());
            return $this->createNotFoundException($e->getMessage());
        }

        if ($artist->getStatus()->getName() == "Deleted") {
            $deletedBy = $artist->getDeletedBy();
            $deletedDate = $artist->getDeletedAt();
            $message = 'NB, This account was deleted by "' . $deletedBy->getFullName() . '" on ' . $deletedDate->format('Y-m-d H:i A') . '.';
            $this->get('utility.manager')->alert('notice', $message);
        }

        $form = $this->createForm(new AccountStatusUpdateType());

        if ($this->getRequest()->getMethod() == 'POST') {
            $form->bindRequest($this->getRequest());
            if ($form->isValid()) {
                if ($artist->getStatus()->getName() == "Deleted") {
                    $this->get('utility.manager')->alert('error', 'Could not update artist status - deleted accounts can only be restored manually, consult administrator!');
                } else {
                    $data = $form->getData();
                    $accountStatus = $data['accountStatus'];
                    if ($accountStatus != '') {
                        if ($accountStatus == 'activate') {
                            $this->get('artist.manager')->activate($artist);
                            $this->get('utility.manager')->alert('success', 'You have successfully activated artist account.');
                        } elseif ($accountStatus == 'lock') {
                            $this->get('artist.manager')->lock($artist);
                            $this->get('utility.manager')->alert('success', 'You have successfully locked artist account.');
                        }
                        return $this->redirect($this->generateUrl('vanessa_artist_list') . '.html');
                    } else {
                        $this->get('utility.manager')->alert('error', 'Could not update artist status, please fix form errors!');
                    }
                }
            } else {
                $this->get('utility.manager')->alert('error', 'Could not update reseller status, please fix form errors!');
            }
        }

        return $this->render('VanessaArtistBundle:Artist:edit.account.status.html.twig', array(
                'artist' => $artist,
                'form' => $form->createView(),
            ));
    }
    
    /**
     * Download list of all available artists
     * 
     * @param integer $page
     * @return Response
     * @Secure(roles="ROLE_ADMIN")
     */
    public function downloadExcelAction()
    {
        $this->get('logger')->info('Download list of all available artists');


        $searchText = $this->get('request')->query->get('searchText');
        $sort = $this->get('request')->query->get('sort', 'a.id');
        $direction = $this->get('request')->query->get('direction', 'asc');
        $filterBy = $this->get('request')->query->get('filterBy', 0);

        $options = array('searchText' => $searchText,
            'sort' => $sort,
            'direction' => $direction,
            'filterBy' => $filterBy
        );

        $artists = $this->get('artist.manager')->listAll($options);
        $excel = $this->get('excel.manager');
        $response = $excel->artistList($artists);

        return $response;
    }      

}
