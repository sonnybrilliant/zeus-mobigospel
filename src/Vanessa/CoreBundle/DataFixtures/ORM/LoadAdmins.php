<?php

namespace Vanessa\CoreBundle\DataFixtures\ORM;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;

/**
 * Load default system admins
 *
 * @author Ronald Conco <ronald.conco@gmail.com>
 * @version 1.0
 * @package VanessaCoreBundle
 * @subpackage DataFixtures
 * @version 0.0.1
 */
class LoadAdmins extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
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

        $ronald = array(
            'firstName' => 'Mfana',
            'lastName' => 'Conco',
            'idNumber' => '8202205463080',
            'email' => 'ronald.conco@mobigospel.co.za',
            'mobile' => '27713264125',
            'password' => '654321',
            'agency' => $this->getReference('agency-internal'),
            'title' => $this->getReference('title-mr'),
            'gender' => $this->getReference('gender-male'),
            'group' => $this->getReference('group-admin'),
            'createdBy' => null,
        );

        $ronald = $memberManagerService->createDefaultMember($ronald);

        $mxolisi = array(
            'firstName' => 'Mxolisi',
            'lastName' => 'Khutama',
            'idNumber' => '8002205463080',
            'email' => 'mxolisi.khutama@mobigospel.co.za',
            'mobile' => '27721101642',
            'password' => 'mrx26021',
            'agency' => $this->getReference('agency-internal'),
            'title' => $this->getReference('title-mr'),
            'gender' => $this->getReference('gender-male'),
            'group' => $this->getReference('group-admin'),
            'createdBy' => null,
        );

        $memberManagerService->createDefaultMember($mxolisi);


        $don = array(
            'firstName' => 'Don',
            'lastName' => 'Khutama',
            'idNumber' => '8502205463080',
            'email' => 'don@mobigospel.co.za',
            'mobile' => '27725184768',
            'password' => '654321',
            'agency' => $this->getReference('agency-internal'),
            'title' => $this->getReference('title-mr'),
            'gender' => $this->getReference('gender-male'),
            'group' => $this->getReference('group-admin'),
            'createdBy' => null,
        );

        $memberManagerService->createDefaultMember($don);        
        
        $this->addReference('member-admin-ronald' , $ronald) ;
    }

    public function getOrder()
    {
        return 3;
    }

}
