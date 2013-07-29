<?php

namespace Vanessa\CoreBundle\DataFixtures\ORM ;

use Vanessa\CoreBundle\Entity\MessageType;
use Doctrine\Common\Persistence\ObjectManager ;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface ;
use Doctrine\Common\DataFixtures\AbstractFixture ;

/**
 * Load default system message types
 *
 * @author Mfana Ronald Conco <ronald.conco@mobigospel.co.za>
 * @version 1.0
 * @package VanessaCoreBundle
 * @subpackage DataFixtures
 * @version 0.0.1
 */
class LoadMessageType extends AbstractFixture implements OrderedFixtureInterface
{

    public function load( ObjectManager $manager )
    {
        $info = new MessageType("Info");
        $manager->persist($info) ;

        $warning = new MessageType("Warning");
        $manager->persist($warning) ;
        
        $error = new MessageType("Error");
        $manager->persist($error) ;
        
        $success = new MessageType("Success");
        $manager->persist($success) ;
        
        $general = new MessageType("General");
        $manager->persist($general) ;
        
        $manager->flush() ;
    }

    public function getOrder()
    {
        return 1 ;
    }

}
