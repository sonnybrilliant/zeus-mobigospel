<?php

namespace Vanessa\CoreBundle\DataFixtures\ORM ;

use Vanessa\CoreBundle\Entity\MimeType ;
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
class LoadMimeType extends AbstractFixture implements OrderedFixtureInterface
{

    public function load( ObjectManager $manager )
    {

        $audioAcc = new MimeType('audio/aac') ;
        $audioAcc->setDescription('.aac');
        $manager->persist($audioAcc) ;

        $audioMp3 = new MimeType('audio/mpeg') ;
        $audioMp3->setDescription('.mp1 .mp2 .mp3 .mpg .mpeg');
        $manager->persist($audioMp3) ;

        $audioMp4 = new MimeType('audio/mp4') ;
        $audioMp4->setDescription('.mp4 .m4a');
        $manager->persist($audioMp4) ;

        $audioOgg = new MimeType('audio/ogg') ;
        $audioOgg->setDescription('oga .ogg');
        $manager->persist($audioOgg) ;

        $audioWav = new MimeType('audio/wav') ;
        $audioWav->setDescription('.wav');
        $manager->persist($audioWav) ;
        
        $audioWebm = new MimeType('audio/webm') ;
        $audioWebm->setDescription('.webm');
        $manager->persist($audioWebm) ;
        
        $videoMp4 = new MimeType('video/mp4') ;
        $videoMp4->setDescription('.mp4 .m4v');
        $manager->persist($videoMp4) ;
        
        $videoOgg = new MimeType('video/ogg') ;
        $videoOgg->setDescription('.ogv');
        $manager->persist($videoOgg) ;
                
        $videoWebm = new MimeType('video/webm') ;
        $videoWebm->setDescription('.webm');
        $manager->persist($videoWebm) ;
        
        $manager->flush() ;

    }

    public function getOrder()
    {
        return 1 ;
    }

}
