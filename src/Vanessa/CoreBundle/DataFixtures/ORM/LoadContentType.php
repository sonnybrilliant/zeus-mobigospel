<?php

namespace Vanessa\CoreBundle\DataFixtures\ORM ;

use Vanessa\CoreBundle\Entity\ContentType ;
use Doctrine\Common\Persistence\ObjectManager ;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface ;
use Doctrine\Common\DataFixtures\AbstractFixture ;

/**
 * Load default system content types
 *
 * @author Mfana Ronald Conco <ronald.conco@mobigospel.co.za>
 * @version 1.0
 * @package VanessaCoreBundle
 * @subpackage DataFixtures
 * @version 0.0.1
 */
class LoadContentType extends AbstractFixture implements OrderedFixtureInterface
{

    public function load( ObjectManager $manager )
    {

        $audio = new ContentType('Audio',1) ;
        $manager->persist($audio) ;

        $video = new ContentType('Video',2) ;
        $manager->persist($video) ;
 
        $manager->flush() ;

         $this->addReference('content-type-audio' , $audio) ;
         $this->addReference('content-type-video' , $video) ;
    }

    public function getOrder()
    {
        return 1 ;
    }

}
