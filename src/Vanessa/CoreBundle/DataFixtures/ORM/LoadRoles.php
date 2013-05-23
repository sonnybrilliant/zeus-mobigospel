<?php

namespace Vanessa\CoreBundle\DataFixtures\ORM ;

use Vanessa\CoreBundle\Entity\Role ;
use Doctrine\Common\Persistence\ObjectManager ;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface ;
use Doctrine\Common\DataFixtures\AbstractFixture ;

/**
 * Load default system user roles
 *
 * @author Mfana Ronald Conco <ronald.conco@mobigospel.co.za>
 * @version 1.0
 * @package VanessaCoreBundle
 * @subpackage DataFixtures
 * @version 0.0.1
 */
class LoadRoles extends AbstractFixture implements OrderedFixtureInterface
{

    public function load( ObjectManager $manager )
    {
        $admin = new Role('ROLE_ADMIN') ;
        $manager->persist($admin) ;
        
        $memberManager = new Role('ROLE_MEMBER_MANAGER') ;
        $manager->persist($memberManager) ;
        
        $memberObserver = new Role('ROLE_MEMBER_OBSERVER') ;
        $manager->persist($memberObserver) ;

        $reportManager = new Role('ROLE_REPORT_MANAGER') ;
        $manager->persist($reportManager) ;
        
        $reportObserver = new Role('ROLE_REPORT_OBSERVER') ;
        $manager->persist($reportObserver) ;

        $artistManager = new Role('ROLE_ARTIST_MANAGER') ;
        $manager->persist($artistManager) ;
        
        $artistObserver = new Role('ROLE_ARTIST_OBSERVER') ;
        $manager->persist($artistObserver) ;

        $labelManager = new Role('ROLE_LABEL_MANAGER') ;
        $manager->persist($labelManager) ;
        
        $labelObserver = new Role('ROLE_LABEL_OBSERVER') ;
        $manager->persist($labelObserver) ;

        $mediaManager = new Role('ROLE_MEDIA_MANAGER') ;
        $manager->persist($mediaManager) ;
        
        $mediaObserver = new Role('ROLE_MEDIA_OBSERVER') ;
        $manager->persist($mediaObserver) ;

        $songManager = new Role('ROLE_SONG_MANAGER') ;
        $manager->persist($songManager) ;
        
        $songObserver = new Role('ROLE_SONG_OBSERVER') ;
        $manager->persist($songObserver) ;

        $code = new Role('ROLE_CODE') ;
        $manager->persist($code) ;

        $downloads = new Role('ROLE_DOWNLOAD') ;
        $manager->persist($downloads) ;

        $manager->flush() ;

        $this->addReference('role-admin' , $admin) ;
        $this->addReference('role-member-manager' , $memberManager) ;
        $this->addReference('role-member-observer' , $memberObserver) ;
        $this->addReference('role-report-manager' , $reportManager) ;
        $this->addReference('role-report-observer' , $reportObserver) ;
        $this->addReference('role-artist-manager' , $artistManager) ;
        $this->addReference('role-artist-observer' , $artistObserver) ;
        $this->addReference('role-label-manager' , $labelManager) ;
        $this->addReference('role-label-observer' , $labelObserver) ;
        $this->addReference('role-media-manager' , $mediaManager) ;
        $this->addReference('role-media-observer' , $mediaObserver) ;
        $this->addReference('role-song-manager' , $songManager) ;
        $this->addReference('role-song-observer' , $songObserver) ;
        $this->addReference('role-code' , $code) ;
        $this->addReference('role-download' , $downloads) ;
        

    }

    public function getOrder()
    {
        return 1 ;
    }

}
