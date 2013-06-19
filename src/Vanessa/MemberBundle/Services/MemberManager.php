<?php

namespace Vanessa\MemberBundle\Services;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Monolog\Logger;
use Vanessa\CoreBundle\Entity\Member;

/**
 * Member manager
 *
 * @author Mfana Ronald Conco <ronald.conco@mobigospel.co.za>
 * @version 0.0.1
 * @package VanessaMemberBundle
 * @subpackage Services
 */
final class MemberManager
{

    /**
     * Service Container
     * @var object
     */
    private $container = null;

    /**
     * Monolog logger
     * @var object
     */
    private $logger = null;

    /**
     * Entity manager
     * @var object
     */
    private $em;

    /**
     * Class construct
     *
     * @param  ContainerInterface $container
     * @param  Logger             $logger
     * @return void
     */
    public function __construct(
    ContainerInterface $container, Logger $logger)
    {
        $this->setContainer($container);
        $this->setLogger($logger);
        $this->setEm($container->get('doctrine')->getManager('default'));

        return;
    }

    public function getContainer()
    {
        return $this->container;
    }

    public function setContainer($container)
    {
        $this->container = $container;
    }

    public function getLogger()
    {
        return $this->logger;
    }

    public function setLogger($logger)
    {
        $this->logger = $logger;
    }

    public function getEm()
    {
        return $this->em;
    }

    public function setEm($em)
    {
        $this->em = $em;
    }

    /**
     * Get member by id
     * @param integer $id
     * @return VanessaCoreBundle:Member
     * @throws \Exception 
     */
    public function getById($id)
    {
        $this->logger->info('get member by id:' . $id);
        $member = $this->em->getRepository('VanessaCoreBundle:Member')
            ->find($id);

        if (!$member) {
            throw new \Exception('Member not found for id:' . $id);
            $this->logger->err('Failed to find member by id:' . $id);
        }

        return $member;
    }

    /**
     * Get member by slug
     * @param integer $slug
     * @return VanessaCoreBundle:Member
     * @throws \Exception 
     */
    public function getBySlug($slug)
    {
        $this->logger->info('get member by slug:' . $slug);
        $member = $this->em->getRepository('VanessaCoreBundle:Member')
            ->findOneBySlug($slug);

        if (!$member) {
            throw new \Exception('Member not found for slug:' . $slug);
            $this->logger->err('Failed to find member by slug:' . $slug);
        }

        return $member;
    }

    /**
     * Get all members query
     * 
     * @param array $options
     * @return query
     */
    public function listAll($options = array())
    {
        $this->logger->info('get all members');

        if (isset($options['filterBy'])) {
            if ($options['filterBy'] != '0') {
                $status = $this->getContainer()->get('status.manager')->getStatusByName($options['filterBy']);
                if ($status) {
                    $options['status'] = $status;
                }
            }
        }

        return $this->em
                ->getRepository('VanessaCoreBundle:Member')
                ->getAllMembersQuery($options);
    }

    /**
     * Get all agency members query
     * 
     * @param array $options
     * @return query
     */
    public function listAgencyMembers($options = array())
    {
        $this->logger->info('get all agency members');
        if (isset($options['filterBy'])) {
            if ($options['filterBy'] != '0') {
                $status = $this->getContainer()->get('status.manager')->getStatusByName($options['filterBy']);
                if ($status) {
                    $options['status'] = $status;
                }
            }
        }

        return $this->em
                ->getRepository('VanessaCoreBundle:Member')
                ->getAllAgencyMembersQuery($options);
    }

    /**
     * Create default system members 
     * 
     * @param array $params
     * @return void
     */
    public function createDefaultMember($params)
    {
        $this->logger->info('create default member');
        $member = new Member();

        $member->setFirstName($params['firstName']);
        $member->setLastName($params['lastName']);
        $member->setEmail($params['email']);
        $member->setMobileNumber($params['mobile']);
        $member->setPassword($params['password']);
        $member->setAgency($params['agency']);
        $member->setTitle($params['title']);
        $member->setGender($params['gender']);
        $member->setGroup($params['group']);
        $member->setStatus($this->container->get('status.manager')->active());

        $group = $this->em->getRepository('VanessaCoreBundle:Group')->find($member->getGroup()->getId());

        foreach ($group->getRoles() as $role) {

            if ("ROLE_ADMIN" == $role->getName()) {
                $member->setIsAdmin(true);
            }

            $member->addMemberRole($role);
        }

        if (!is_null($params['createdBy'])) {
            $member->setCreatedBy($params['createdBy']);
        }

        $this->em->persist($member);
        $this->em->flush();
        return $member;
    }

    /**
     * Create a new member
     *  
     * @param \Vanessa\CoreBundle\Entities\Member $member
     * @return void
     */
    public function createNewMember($member)
    {
        $this->logger->info('create a new member');
        //set status
        $member->setStatus($this->container->get('status.manager')->active());

        //get user
        $securityContext = $this->container->get('security.context');
        $user = $securityContext->getToken()->getUser();
        $member->setCreatedBy($user);

        //assign roles
        $group = $this->em->getRepository('VanessaCoreBundle:Group')->find($member->getGroup()->getId());

        foreach ($group->getRoles() as $role) {

            if ("ROLE_ADMIN" == $role->getName()) {
                $member->setIsAdmin(true);
            }

            $member->addMemberRole($role);
        }

        $this->em->persist($member);
        $this->em->flush();
        return;
    }

    /**
     * Update member
     *  
     * @param \Vanessa\CoreBundle\Entities\Member $member
     * @return void
     */
    public function update($member)
    {
        $this->logger->info('update member ' . $member->getFullName());
        //reset roles
        $member->getMemberRoles()->clear();
        //assign roles
        $group = $this->em->getRepository('VanessaCoreBundle:Group')->find($member->getGroup()->getId());

        foreach ($group->getRoles() as $role) {

            if ("ROLE_ADMIN" == $role->getName()) {
                $member->setIsAdmin(true);
            }

            $member->addMemberRole($role);
        }

        $this->em->persist($member);
        $this->em->flush();
        return;
    }

    /**
     * Delete member
     * 
     * @param \Vanessa\CoreBundle\Entities\Member $member
     * @return void
     */
    public function delete($member)
    {
        $this->logger->info('delete member slug:' . $member->getSlug());
        $member->setStatus($this->container->get('status.manager')->deleted());
        $member->setIsDeleted(true);
        $member->setEnabled(false);
        $member->setDeletedAt(new \DateTime());
        $member->setDeletedBy($this->getActiveUser());
        //remove email
        $member->setEmail(time() . '-' . $member->getEmail());
        $member->setUsername(time() . '-' . $member->getEmail());
        $this->em->persist($member);
        $this->em->flush();
        return;
    }

    /**
     * Get member by email address
     * 
     * @param string $email
     * @return boolean 
     */
    public function getByEmail($email)
    {
        $this->logger->info('get member by email:' . $email);
        $members = $this->em->getRepository('VanessaCoreBundle:Member')
            ->findByEmail($email);

        if ($members) {
            return $members[0];
        }
        return false;
    }

    /**
     * Get member by token
     * @param string $token
     * @return boolean 
     */
    public function getByToken($token)
    {
        $this->logger->info('get member by token:' . $token);
        $members = $this->em->getRepository('VanessaCoreBundle:Member')
            ->findByConfirmationToken($token);

        if ($members) {
            return $members[0];
        }
        return false;
    }

    /**
     * Get all admin users
     * 
     * @return array
     */
    public function getAllAdmin($exception = false)
    {
        $this->logger->info('get all admin users');
        $results = array();
        $members = $this->em->getRepository('VanessaCoreBundle:Member')
            ->findByIsAdmin(true);

        if ($members) {
            if ($exception) {
                foreach ($members as $member) {
                    if ($member->getAgency() == 1 && $member->getIsDeleted == false) {
                        $results[] = $member;
                    }
                }
            } else {
                $results = $members;
            }
        }
        return $results;
    }

    /**
     * Get active user
     * 
     * @return VanessaCoreBundle:Member
     */
    public function getActiveUser()
    {
        $this->logger->info('get active user');
        $securityContext = $this->container->get('security.context');
        $user = $securityContext->getToken()->getUser();
        return $user;
    }

    /**
     * Get default admin user member
     * 
     * @return VanessaCoreBundle:Member
     * @throws \Exception 
     */
    public function getDefault()
    {
        $this->logger->info('get default member');
        $id = 1;
        $member = $this->em->getRepository('VanessaCoreBundle:Member')
            ->find($id);

        if (!$member) {
            throw new \Exception('Default member not found for id:' . $id);
            $this->logger->err('Failed to find default member by id:' . $id);
        }

        return $member;
    }

    /**
     * Activate member account
     * 
     * @param VanessaCoreBundle:Member
     * @return void
     */
    public function activateMember($member)
    {
        $member->setStatus($this->container->get('status.manager')->active());
        $member->setIsDeleted(false);
        $member->setEnabled(true);
        $this->em->persist($member);
        $this->em->flush();
        return;
    }

    /**
     * disable/lock member account
     * 
     * @param VanessaCoreBundle:Member
     * @return void
     */
    public function lockMember($member)
    {
        $member->setStatus($this->container->get('status.manager')->locked());
        $member->setEnabled(false);
        $this->em->persist($member);
        $this->em->flush();
        return;
    }

    /**
     * Activate all members by agency
     * 
     * @param \Vanessa\CoreBundle\Entities\Agency $agency
     * @return void
     */
    public function activateAllByAgency($agency)
    {
        $this->logger->info('activate members by agency slug:' . $agency->getSlug());

        $options = array('searchText' => '',
            'sort' => 'm.id',
            'direction' => 'asc',
            'filterBy' => '',
            'agency' => $agency
        );

        $members = $this->em->getRepository('VanessaCoreBundle:Member')
            ->getAllAgencyMembersQuery($options);

        $status = $this->container->get('status.manager')->active();

        foreach ($members as $member) {
            $member->setStatus($status);
            $member->setIsDeleted(false);
            $member->setEnabled(true);
            $this->em->persist($member);
        }
        $this->em->flush();
        return;
    }

    /**
     * Lock all members by agency
     * 
     * @param \Vanessa\CoreBundle\Entities\Agency $agency
     * @return void
     */
    public function lockAllByAgency($agency)
    {
        $this->logger->info('lock members by agency slug:' . $agency->getSlug());

        $options = array('searchText' => '',
            'sort' => 'm.id',
            'direction' => 'asc',
            'filterBy' => '',
            'agency' => $agency
        );

        $members = $this->em->getRepository('VanessaCoreBundle:Member')
            ->getAllAgencyMembersQuery($options);

        $status = $this->container->get('status.manager')->locked();

        foreach ($members as $member) {
            $member->setStatus($status);
            $member->setEnabled(false);
            $this->em->persist($member);
        }
        $this->em->flush();
        return;
    }

    /**
     * Delete all members by agency
     * 
     * @param \Vanessa\CoreBundle\Entities\Agency $agency
     * @return void
     */
    public function deleteAllByAgency($agency)
    {
        $this->logger->info('delete members by agency slug:' . $agency->getSlug());

        $options = array('searchText' => '',
            'sort' => 'm.id',
            'direction' => 'asc',
            'filterBy' => '',
            'agency' => $agency
        );

        $members = $this->em->getRepository('VanessaCoreBundle:Member')
            ->getAllAgencyMembersQuery($options);

        $status = $this->container->get('status.manager')->deleted();

        foreach ($members as $member) {
            $member->setStatus($status);
            $member->setIsDeleted(true);
            $member->setEnabled(false);
            $member->setDeletedAt(new \DateTime());
            $member->setDeletedBy($this->getActiveUser());
            //remove email
            $member->setEmail(time() . '-' . $member->getEmail());
            $member->setUsername(time() . '-' . $member->getEmail());
            $this->em->persist($member);
        }
        $this->em->flush();
        return;
    }

}
