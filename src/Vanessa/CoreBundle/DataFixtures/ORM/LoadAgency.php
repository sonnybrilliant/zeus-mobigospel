<?php

namespace Vanessa\CoreBundle\DataFixtures\ORM ;

use Vanessa\CoreBundle\Entity\Agency ;
use Doctrine\Common\Persistence\ObjectManager ;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface ;
use Doctrine\Common\DataFixtures\AbstractFixture ;

/**
 * Load default system default company
 *
 * @author Mfana Ronald Conco <ronald.conco@mobigospel.co.za>
 * @version 1.0
 * @package VanessaCoreBundle
 * @subpackage DataFixtures
 * @version 0.0.1
 */
class LoadAgency extends AbstractFixture implements OrderedFixtureInterface
{

    public function load( ObjectManager $manager )
    {
        $internal = new Agency() ;
        $internal->setName('Mobigospel agency');
        $internal->setSlogan('Your partner in good music.');
        $internal->setDescription('This is description');
        $internal->setAddress1('17 Forest Walk Crescent, Pretoria , Gauteng');
        $internal->setPostalCode('0081');
        $internal->setSuburbCode('0081');
        $internal->setSuburb('Boardwalk Meander');
        $internal->setPostalBox('P.O. Box 25850');
        $internal->setStatus($this->getReference('status-active'));
        $internal->setContactPerson('Sally Joy');
        $internal->setContactNumber('0114567894');
        $internal->setContactEmail('info@mobigospel.co.za');        
        $internal->setAgencyType($this->getReference('agency-type-internal'));
        $manager->persist($internal) ;
        
        $contentProvider = new Agency() ;
        $contentProvider->setName('Gospel gold');
        $contentProvider->setSlogan('Your partner in gospel music.');
        $contentProvider->setDescription('We love god, we love music.');
        $contentProvider->setAddress1('17 Forest Walk Crescent, Pretoria , Gauteng');
        $contentProvider->setSuburbCode('0081');
        $contentProvider->setPostalBox('P.O. Box 11850');
        $contentProvider->setSuburb('Boardwalk Meander');
        $contentProvider->setPostalCode('0081');
        $contentProvider->setStatus($this->getReference('status-active'));
        $contentProvider->setContactPerson('Nina Simone');
        $contentProvider->setContactNumber('0124567894');
        $contentProvider->setContactEmail('gospel.gold@sulehosting.co.za');
        $contentProvider->setAgencyType($this->getReference('agency-type-content-provider'));
        $manager->persist($contentProvider) ;
        
        $mediaPartner = new Agency() ;
        $mediaPartner->setName('The Gospel Radio show');
        $mediaPartner->setSlogan('Listen with your heart.');
        $mediaPartner->setDescription('We love god, we love music.');
        $mediaPartner->setAddress1('17 Forest Walk Crescent, Pretoria , Gauteng');
        $mediaPartner->setSuburbCode('0081');
        $mediaPartner->setPostalBox('P.O. Box 11850');
        $mediaPartner->setSuburb('Boardwalk Meander');
        $mediaPartner->setPostalCode('0081');
        $mediaPartner->setStatus($this->getReference('status-active'));
        $mediaPartner->setContactPerson('Nina Simone');
        $mediaPartner->setContactNumber('0733264125');
        $mediaPartner->setContactEmail('gospel.radio.show@sulehosting.co.za');
        $mediaPartner->setAgencyType($this->getReference('agency-type-media-partner'));
        $manager->persist($mediaPartner) ;
    
        $manager->flush() ;

        $this->addReference('agency-internal' , $internal) ;         
        $this->addReference('agency-content-provider' , $contentProvider) ;         
        $this->addReference('agency-media-partner' , $mediaPartner) ;         
    }

    public function getOrder()
    {
        return 2 ;
    }

}
