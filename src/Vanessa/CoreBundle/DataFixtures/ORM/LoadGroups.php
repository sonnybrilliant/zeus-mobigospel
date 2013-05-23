<?php

namespace Vanessa\CoreBundle\DataFixtures\ORM ;

use Vanessa\CoreBundle\Entity\Group ;
use Doctrine\Common\Persistence\ObjectManager ;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface ;
use Doctrine\Common\DataFixtures\AbstractFixture ;

/**
 * Load default system user groups
 *
 * @author Mfana Ronald Conco <ronald.conco@mobigospel.co.za>
 * @version 1.0
 * @package VanessaCoreBundle
 * @subpackage DataFixtures
 * @version 0.0.1
 */
class LoadGroups extends AbstractFixture implements OrderedFixtureInterface
{

    public function load( ObjectManager $manager )
    {

        $admin = new Group('Administrator') ;
        $admin->setDescription('Super user, has access to everything, please do not grant this role to every one - sensitive data will be compromised');
        $admin->addRole($this->getReference('role-admin')) ;
        $admin->addRole($this->getReference('role-member-manager')) ;
        $admin->addRole($this->getReference('role-member-observer')) ;
        $admin->addRole($this->getReference('role-report-manager')) ;
        $admin->addRole($this->getReference('role-report-observer')) ;
        $admin->addRole($this->getReference('role-artist-manager')) ;
        $admin->addRole($this->getReference('role-artist-observer')) ;
        $admin->addRole($this->getReference('role-label-manager')) ;
        $admin->addRole($this->getReference('role-label-observer')) ;
        $admin->addRole($this->getReference('role-media-manager')) ;
        $admin->addRole($this->getReference('role-media-observer')) ;
        $admin->addRole($this->getReference('role-song-manager')) ;
        $admin->addRole($this->getReference('role-song-observer')) ;
        $admin->addRole($this->getReference('role-download')) ;
        $admin->addRole($this->getReference('role-code')) ;
        $manager->persist($admin) ;
        
        $labelAdmin = new Group('Record label') ;
        $labelAdmin->setDescription('Record label/Content Owner, Creates and shares content with media partner.');
        $labelAdmin->addRole($this->getReference('role-member-manager')) ;
        $labelAdmin->addRole($this->getReference('role-member-observer')) ;
        $labelAdmin->addRole($this->getReference('role-report-manager')) ;
        $labelAdmin->addRole($this->getReference('role-report-observer')) ;
        $labelAdmin->addRole($this->getReference('role-artist-manager')) ;
        $labelAdmin->addRole($this->getReference('role-artist-observer')) ;
        $labelAdmin->addRole($this->getReference('role-label-manager')) ;
        $labelAdmin->addRole($this->getReference('role-label-observer')) ;
        $labelAdmin->addRole($this->getReference('role-song-manager')) ;
        $labelAdmin->addRole($this->getReference('role-song-observer')) ;
        $labelAdmin->addRole($this->getReference('role-download')) ;
        $labelAdmin->addRole($this->getReference('role-code')) ;
        $manager->persist($labelAdmin) ;
   
        $mediaAdmin = new Group('Media partner') ;
        $mediaAdmin->setDescription('Media partner, Consumes content but cannot create it.');
        $mediaAdmin->addRole($this->getReference('role-member-manager')) ;
        $mediaAdmin->addRole($this->getReference('role-member-observer')) ;
        $mediaAdmin->addRole($this->getReference('role-report-manager')) ;
        $mediaAdmin->addRole($this->getReference('role-report-observer')) ;
        $mediaAdmin->addRole($this->getReference('role-artist-observer')) ;
        $mediaAdmin->addRole($this->getReference('role-media-manager')) ;
        $mediaAdmin->addRole($this->getReference('role-media-observer')) ;
        $mediaAdmin->addRole($this->getReference('role-song-observer')) ;
        $mediaAdmin->addRole($this->getReference('role-download')) ;
        $mediaAdmin->addRole($this->getReference('role-code')) ;
        $manager->persist($mediaAdmin) ;        
        
        
        $labelManager = new Group('Record label content loader') ;
        $labelManager->setDescription('Record label content loader, has access to artists and songs upload , as well as download code manager');
        $labelManager->addRole($this->getReference('role-artist-manager')) ;
        $labelManager->addRole($this->getReference('role-artist-observer')) ;
        $labelManager->addRole($this->getReference('role-song-manager')) ;
        $labelManager->addRole($this->getReference('role-song-observer')) ;
        $labelManager->addRole($this->getReference('role-code')) ;
        $labelManager->addRole($this->getReference('role-download')) ;
        $manager->persist($labelManager) ;
        
        $mediaManager = new Group('Media content manager') ;
        $mediaManager->setDescription('Media content manager, has access to view artists and songs but cannot create them, as well as download code manager');
        $mediaManager->addRole($this->getReference('role-artist-observer')) ;
        $mediaManager->addRole($this->getReference('role-song-observer')) ;
        $mediaManager->addRole($this->getReference('role-code')) ;
        $mediaManager->addRole($this->getReference('role-download')) ;
        $manager->persist($mediaManager) ;
        
        
        $manager->flush() ;
        
        $this->addReference('group-admin' , $admin) ;
        $this->addReference('group-label-admin' , $labelAdmin) ;
        $this->addReference('group-media-admin' , $mediaAdmin) ;
        $this->addReference('group-label-manager' , $labelManager) ;
        $this->addReference('group-media-manager' , $mediaManager) ;
    }

    public function getOrder()
    {
        return 2 ;
    }

}
