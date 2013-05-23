<?php

namespace Vanessa\CoreBundle\DataFixtures\ORM ;

use Vanessa\CoreBundle\Entity\Gender ;
use Doctrine\Common\Persistence\ObjectManager ;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface ;
use Doctrine\Common\DataFixtures\AbstractFixture ;

/**
 * Load default system user genders
 *
 * @author Mfana Ronald Conco <ronald.conco@mobigospel.co.za>
 * @version 1.0
 * @package VanessaCoreBundle
 * @subpackage DataFixtures
 * @version 0.0.1
 */
class LoadGenders extends AbstractFixture implements OrderedFixtureInterface
{

    public function load( ObjectManager $manager )
    {
        $female = new Gender('Female') ;
        $manager->persist($female) ;

        $male = new Gender('Male') ;
        $manager->persist($male) ;

        $manager->flush() ;

        $this->addReference('gender-female' , $female) ;
        $this->addReference('gender-male' , $male) ;
    }

    public function getOrder()
    {
        return 1 ;
    }

}
