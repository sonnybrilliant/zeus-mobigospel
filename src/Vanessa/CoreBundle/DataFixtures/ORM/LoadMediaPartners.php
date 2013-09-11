<?php

namespace Vanessa\CoreBundle\DataFixtures\ORM;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;

/**
 * Load default system media partner
 *
 * @author Mfana Ronald Conco <ronald.conco@mobigospel.co.za>
 * @version 1.0
 * @package VanessaCoreBundle
 * @subpackage DataFixtures
 * @version 0.0.1
 */
class LoadMediaPartners extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $memberManagerService = $this->container->get('member.manager');
        
        $ludwig = array(
            'firstName' => 'Ludwig',
            'lastName' => 'van Beethoven',
            'idNumber' => '8502205463080',
            'email' => 'admin.media@sulehosting.co.za',
            'mobile' => '27725184762',
            'password' => '654321',
            'agency' => $this->getReference('agency-media-partner'),
            'title' => $this->getReference('title-mr'),
            'gender' => $this->getReference('gender-male'),
            'group' => $this->getReference('group-media-admin'),
            'createdBy' => $this->getReference('member-admin-ronald'),
        );

        $memberManagerService->createDefaultMember($ludwig);        
        
        $nina = array(
            'firstName' => 'Nina',
            'lastName' => 'Simone',
            'idNumber' => '8502205463080',
            'email' => 'manager.media@sulehosting.co.za',
            'mobile' => '27713264129',
            'password' => '654321',
            'agency' => $this->getReference('agency-internal'),
            'title' => $this->getReference('title-mr'),
            'gender' => $this->getReference('gender-male'),
            'group' => $this->getReference('group-media-manager'),
            'createdBy' => $this->getReference('member-admin-ronald'),
        );

        $memberManagerService->createDefaultMember($nina);
    }

    public function getOrder()
    {
        return 4;
    }

}
