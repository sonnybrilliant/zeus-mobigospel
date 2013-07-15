<?php

namespace Vanessa\CoreBundle\DataFixtures\ORM;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;

/**
 * Load default system content provider
 *
 * @author Mfana Ronald Conco <ronald.conco@mobigospel.co.za>
 * @version 1.0
 * @package VanessaCoreBundle
 * @subpackage DataFixtures
 * @version 0.0.1
 */
class LoadContentProviders extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
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

                
        $handel = array(
            'firstName' => 'George',
            'lastName' => 'Handel',
            'idNumber' => '8502205463080',
            'email' => 'admin.label@sulehosting.co.za',
            'mobile' => '27725184761',
            'password' => '654321',
            'agency' => $this->getReference('agency-content-provider'),
            'title' => $this->getReference('title-mr'),
            'gender' => $this->getReference('gender-male'),
            'group' => $this->getReference('group-label-admin'),
            'createdBy' => $this->getReference('member-admin-ronald'),
        );

        $memberManagerService->createDefaultMember($handel);
        
        $miles = array(
            'firstName' => 'Miles',
            'lastName' => 'Davies',
            'idNumber' => '8502205463080',
            'email' => 'manager.label@sulehosting.co.za',
            'mobile' => '27713264126',
            'password' => '654321',
            'agency' => $this->getReference('agency-content-provider'),
            'title' => $this->getReference('title-mr'),
            'gender' => $this->getReference('gender-male'),
            'group' => $this->getReference('group-label-manager'),
            'createdBy' => $this->getReference('member-admin-ronald'),
        );

        $memberManagerService->createDefaultMember($miles);
    }

    public function getOrder()
    {
        return 4;
    }

}
