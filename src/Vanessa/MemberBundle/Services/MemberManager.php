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
        $this->setEm($container->get('doctrine')->getEntityManager('default'));

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
     * @param string $slug
     * @return void
     */
    public function delete($slug)
    {
        $member = $this->getBySlug($slug);
        $member->setStatus($this->container->get('status.manager')->deleted());
        $member->setIsDeleted(true);
        $member->setEnabled(false);
        $member->setDeletedAt(new \DateTime());
        $member->setDeletedBy($this->getActiveUser());
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
        $id = 1;
        $member = $this->em->getRepository('VanessaCoreBundle:Member')
            ->find($id);

        if (!$member) {
            throw new \Exception('Default member not found for id:' . $id);
            $this->logger->err('Failed to find default member by id:' . $id);
        }

        return $member;
    }

}
