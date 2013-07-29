<?php

namespace Vanessa\SongBundle\Services;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Monolog\Logger;
use Vanessa\CoreBundle\Entity\Song;
use \GetId3\GetId3Core as GetId3;
use \GetId3\Write\Tags;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOException;

/**
 * Tag manager
 *
 * @author Mfana Ronald Conco <ronald.conco@mobigospel.co.za>
 * @version 0.0.1
 * @package VanessaSongBundle
 * @subpackage Services
 */
final class TagManager
{

    /**
     * Service Container
     * @var object
     */
    private $container = null;

    /**
     * Monolog logger
     * @var object
     */
    private $logger = null;

    /**
     * Entity manager
     * @var object
     */
    private $em;

    /**
     * Class construct
     *
     * @param  ContainerInterface $container
     * @param  Logger             $logger
     * @return void
     */
    public function __construct(
    ContainerInterface $container, Logger $logger)
    {
        $this->setContainer($container);
        $this->setLogger($logger);
        $this->setEm($container->get('doctrine')->getManager('default'));

        return;
    }

    public function getContainer()
    {
        return $this->container;
    }

    public function setContainer($container)
    {
        $this->container = $container;
    }

    public function getLogger()
    {
        return $this->logger;
    }

    public function setLogger($logger)
    {
        $this->logger = $logger;
    }

    public function getEm()
    {
        return $this->em;
    }

    public function setEm($em)
    {
        $this->em = $em;
    }
    
    /**
     * Tag preview song
     * 
     * @param VanessaCoreBundle:SongTemp $song
     * @return type
     */
    public function tagPreview($song)
    {
        $mp3File = $this->getContainer()->get('kernel')->getRootDir() . '/../web/uploads/songs/preview/' . $song->getPreviewVersion();
        
        $TextEncoding = 'UTF-8';

        $getId3 = new GetId3();
        $getId3->setEncoding(array('encoding' => $TextEncoding));

        $tagwriter = new Tags();
        $tagwriter->filename = $mp3File;
        $tagwriter->tagformats = array('id3v1', 'id3v2.3');

        // set various options (optional)
        $tagwriter->overwrite_tags = true;
        $tagwriter->tag_encoding = $TextEncoding;
        $tagwriter->remove_other_tags = true;

        // populate data array

        $genres = $song->getGenres();

        $tmp = array();

        foreach ($genres as $genre) {
            $tmp[] = ucfirst($genre->getName());
        }


        $TagData = array(
            'title' => array($song->getTitle()),
            'artist' => array($song->getArtist()->getStageName()),
            'album' => array('Single'),
            //'year' => array('2004'),
            'genre' => $tmp,
            'comment' => array('Tag by Mobigospel.co.za'),
            'track' => array('01'),
            'popularimeter' => array('email' => 'support@mobigospel.co.za', 'rating' => 128, 'data' => 0),
        );
        $tagwriter->tag_data = $TagData;


        // write tags
        $tagwriter->WriteTags();
        return $tagwriter->warnings;
    }
    
    /**
     * Tag full song
     * 
     * @param VanessaCoreBundle:SongTemp $song
     * @return type
     */
    public function tagFull($song)
    {
        $mp3File = $this->getContainer()->get('kernel')->getRootDir() . '/../web/uploads/songs/full/' . $song->getFullVersion();
        
        $TextEncoding = 'UTF-8';

        $getId3 = new GetId3();
        $getId3->setEncoding(array('encoding' => $TextEncoding));

        $tagwriter = new Tags();
        $tagwriter->filename = $mp3File;
        $tagwriter->tagformats = array('id3v1', 'id3v2.3');

        // set various options (optional)
        $tagwriter->overwrite_tags = true;
        $tagwriter->tag_encoding = $TextEncoding;
        $tagwriter->remove_other_tags = true;

        // populate data array

        $genres = $song->getGenres();

        $tmp = array();

        foreach ($genres as $genre) {
            $tmp[] = ucfirst($genre->getName());
        }


        $TagData = array(
            'title' => array($song->getTitle()),
            'artist' => array($song->getArtist()->getStageName()),
            'album' => array('Single'),
            //'year' => array('2004'),
            'genre' => $tmp,
            'comment' => array('Tag by Mobigospel.co.za'),
            'track' => array('01'),
            'popularimeter' => array('email' => 'support@mobigospel.co.za', 'rating' => 128, 'data' => 0),
        );
        $tagwriter->tag_data = $TagData;


        // write tags
        $tagwriter->WriteTags();
        return $tagwriter->warnings;
    }

}
