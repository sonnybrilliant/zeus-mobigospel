<?php

namespace Vanessa\CoreBundle\DataFixtures\ORM ;

use Vanessa\CoreBundle\Entity\Genre;
use Doctrine\Common\Persistence\ObjectManager ;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface ;
use Doctrine\Common\DataFixtures\AbstractFixture ;

/**
 * Load default system genres
 *
 * @author Mfana Ronald Conco <ronald.conco@mobigospel.co.za>
 * @version 1.0
 * @package VanessaCoreBundle
 * @subpackage DataFixtures
 * @version 0.0.1
 */
class LoadGenre extends AbstractFixture implements OrderedFixtureInterface
{

    public function load( ObjectManager $manager )
    {
        $genre_Acoustic = new Genre('acoustic') ;
        $manager->persist($genre_Acoustic) ;
        
        $genre_Afro_Pop = new Genre('afro-pop') ;
        $manager->persist($genre_Afro_Pop) ;
        
        $genre_African = new Genre('african') ;
        $manager->persist($genre_African) ;
        
        $genre_Alternative = new Genre('alternative') ;
        $manager->persist($genre_Alternative) ;

        $genre_Anime = new Genre('anime') ;
        $manager->persist($genre_Anime) ;

        $genre_Blues = new Genre('blues') ;
        $manager->persist($genre_Blues) ;

        $genre_Children = new Genre("children's-music") ;
        $manager->persist($genre_Children) ;

        $genre_Christian = new Genre('christian') ;
        $manager->persist($genre_Christian) ;        
        
        $genre_Classical = new Genre('classical') ;
        $manager->persist($genre_Classical) ;
        
        $genre_Classic_Rock = new Genre('classic-rock') ;
        $manager->persist($genre_Classic_Rock) ;

        $genre_Comedy = new Genre('comedy') ;
        $manager->persist($genre_Comedy) ;

        $genre_Country = new Genre('country') ;
        $manager->persist($genre_Country) ;

        $genre_Dance = new Genre('dance') ;
        $manager->persist($genre_Dance) ;

        $genre_Easy_Listening = new Genre('easy-listening') ;
        $manager->persist($genre_Easy_Listening) ;

        $genre_Electronic = new Genre('electronic') ;
        $manager->persist($genre_Electronic) ;

        $genre_Enka = new Genre('enka') ;
        $manager->persist($genre_Enka) ;

        $genre_Female_Vocalists = new Genre('female-vocalists') ;
        $manager->persist($genre_Female_Vocalists) ; 
        
        $genre_Folk = new Genre('folk') ;
        $manager->persist($genre_Folk) ; 
        
        $genre_Funk = new Genre('funk') ;
        $manager->persist($genre_Funk) ;       
        
        $genre_Hip_Hop = new Genre('hip-hop') ;
        $manager->persist($genre_Hip_Hop) ;
        
        $genre_Indie = new Genre('indie') ;
        $manager->persist($genre_Indie) ;
        
        $genre_Indie_Pop = new Genre('indie-pop') ;
        $manager->persist($genre_Indie_Pop) ;

        $genre_Gospel = new Genre('gospel') ;
        $manager->persist($genre_Gospel) ;

        $genre_House = new Genre('house') ;
        $manager->persist($genre_House) ;

        $genre_Instrumental = new Genre('instrumental') ;
        $manager->persist($genre_Instrumental) ;

        $genre_Jazz = new Genre('jazz') ;
        $manager->persist($genre_Jazz) ;
        
        $genre_Jazz_Vocal = new Genre('jazz-vocal') ;
        $manager->persist($genre_Jazz_Vocal) ;

        $genre_Kwaito = new Genre('kwaito') ;
        $manager->persist($genre_Kwaito) ;

        $genre_Latino = new Genre('latino') ;
        $manager->persist($genre_Latino) ;

        $genre_New_Age = new Genre('new age') ;
        $manager->persist($genre_New_Age) ;

        $genre_Opera = new Genre('opera') ;
        $manager->persist($genre_Opera) ;

        $genre_Pop = new Genre('pop') ;
        $manager->persist($genre_Pop) ;

        $genre_RNB = new Genre('rnb') ;
        $manager->persist($genre_RNB) ;

        $genre_Rap = new Genre('rap') ;
        $manager->persist($genre_Rap) ;        
        
        $genre_Soul = new Genre('soul') ;
        $manager->persist($genre_Soul) ;

        $genre_Reggae = new Genre('reggae') ;
        $manager->persist($genre_Reggae) ;

        $genre_Rock = new Genre('rock') ;
        $manager->persist($genre_Rock) ;

        $genre_Singer_Songwriter = new Genre('singer-songwriter') ;
        $manager->persist($genre_Singer_Songwriter) ;

        $genre_Soundtrack = new Genre('soundtrack') ;
        $manager->persist($genre_Soundtrack) ;

        $genre_Traditional = new Genre('traditional') ;
        $manager->persist($genre_Traditional) ;        
        
        $genre_Vocal = new Genre('vocal') ;
        $manager->persist($genre_Vocal) ;  
        $manager->flush() ;
              
    }

    public function getOrder()
    {
        return 1 ;
    }

}
