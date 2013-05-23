<?php

namespace Vanessa\CoreBundle\DataFixtures\ORM ;

use Vanessa\CoreBundle\Entity\AgencyType;
use Doctrine\Common\Persistence\ObjectManager ;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface ;
use Doctrine\Common\DataFixtures\AbstractFixture ;

/**
 * Load default system agency types
 *
 * @author Mfana Ronald Conco <ronald.conco@mobigospel.co.za>
 * @version 1.0
 * @package VanessaCoreBundle
 * @subpackage DataFixtures
 * @version 0.0.1
 */
class LoadAgencyType extends AbstractFixture implements OrderedFixtureInterface
{

    public function load( ObjectManager $manager )
    {
        $internal = new AgencyType("Internal");
        $manager->persist($internal) ;

        $contentProvider = new AgencyType("Content provider");
        $manager->persist($contentProvider) ;
        
        $mediaPartner = new AgencyType("Media partner");
        $manager->persist($mediaPartner) ;
        
        $manager->flush() ;

        $this->addReference('agency-type-internal' , $internal) ;
        $this->addReference('agency-type-content-provider' , $contentProvider) ;
        $this->addReference('agency-type-media-partner' , $mediaPartner) ;

    }

    public function getOrder()
    {
        return 1 ;
    }

}
