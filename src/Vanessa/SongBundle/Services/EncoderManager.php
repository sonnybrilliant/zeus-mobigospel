<?php

namespace Vanessa\SongBundle\Services;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Monolog\Logger;

/**
 * Pending manager
 *
 * @author Mfana Ronald Conco <ronald.conco@mobigospel.co.za>
 * @version 0.0.1
 * @package VanessaSongBundle
 * @subpackage Services
 */
final class EncoderManager
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
     *
     * @var integer
     */
    private $previewSampleRate = 96;

    /**
     *
     * @var integer
     */
    private $fullSampleRate = 128;

    /**
     *
     * @var string
     */
    private $previewStartOffset = '00:00:30';

    /**
     *
     * @var string
     */
    private $previewLength = '00:01:00';
    
    /**
     *
     * @var type string
     */
    private $avconvPath = "/usr/bin/avconv";
    
    /**
     * Class construct
     * 
     * @param ContainerInterface $container
     * @param Logger $logger
     * @return void 
     */
    public function __construct(
    ContainerInterface $container, Logger $logger)
    {
        $this->setContainer($container);
        $this->setLogger($logger);
        $this->setEm($container->get('doctrine')->getManager('default'));
        $this->setAudioSettings();
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
     * Set audio settings
     * 
     * @return void
     */
    public function setAudioSettings()
    {
        $this->previewSampleRate = $this->container->getParameter('song_preview_sample_rate');
        $this->previewStartOffset = $this->container->getParameter('song_preview_start_offset');
        $this->previewLength = $this->container->getParameter('song_preview_length');
        $this->fullSampleRate = $this->container->getParameter('song_full_sample_rate');
        $this->avconvPath = $this->container->getParameter('env_lib_avconv');

        return;
    }

    /**
     * Absolute path to web folder
     * 
     * @return string
     */
    private function getUploadRootDir()
    {
        return __DIR__ . '/../../../../web/';
    }

    /**
     * Song tmp directory
     * 
     * @return string
     */
    private function getSongTmpFolder()
    {
        return $this->getUploadRootDir() . 'uploads/songs/tmp/';
    }

    /**
     * Song preview directory
     * 
     * @return string
     */
    public function getSongPreviewFolder()
    {
        return $this->getUploadRootDir() . 'uploads/songs/preview/';
    }

    /**
     * Song full track directory
     * 
     * @return string
     */
    public function getSongFullTrackFolder()
    {
        return $this->getUploadRootDir() . 'uploads/songs/full/';
    }

    /**
     * Process avconv output
     * @param array $output
     * @return boolean
     * @throws \Exception
     */
    private function processOutput($output)
    {
        $this->logger->info("process avcnov output");

        $str = end($output);

        //sample
        //video:0kB audio:703kB global headers:0kB muxing overhead 0.038315%
        if (strstr($str, "video:")) {
            return true;
        } else {
            throw new \Exception("Failed to convert song due to:".  print_r($output,1));
        }
        return;
    }

    /**
     * Create preview song file
     * 
     * @param VanessaCoreBundle:SongTemp
     * @return void
     */
    public function previewSong($song)
    {
        $this->logger->info("create a preview file fo song temp:" . $song->getSlug());
        
        $uniqueFileName = uniqid($song->getId() . '_') . ".mp3";
        $outputFile = $this->getSongPreviewFolder() . $uniqueFileName;
        $inputFile = $this->getSongTmpFolder() . $song->getId() . ".mp3";

        $format = "%s -i %s  -ss %s -t %s -acodec libmp3lame -ab %dk -ac 2 -ar 44100 %s 2>&1 ";

        $command = sprintf($format,$this->avconvPath, $inputFile, $this->previewStartOffset, $this->previewLength, $this->previewSampleRate, $outputFile
        );
        $output = array();
        exec($command, $output);

        //process out and verify file convesion
        $this->processOutput($output);

        $song->setPreviewVersion($uniqueFileName);
        
        //update preview status on temp song
        $this->getContainer()->get('song.pending.manager')->updateSongPreview($song);        
        return;
    }

    /**
     * Create full song file
     * 
     * @param VanessaCoreBundle:SongTemp
     * @return void
     */
    public function fullTrackSong($song)
    {
        $this->logger->info("create a full track file fo song temp:" .$song->getSlug());
 

        $uniqueFileName = uniqid($song->getId() . '_') . ".mp3";
        $outputFile = $this->getSongFullTrackFolder() . $uniqueFileName;
        $inputFile = $this->getSongTmpFolder() . $song->getId() . ".mp3";

        $format = "%s -i %s  -acodec libmp3lame -ab %dk -ac 2 -ar 44100 %s 2>&1 ";

        $command = sprintf($format, $this->avconvPath , $inputFile, $this->fullSampleRate, $outputFile
        );
        $output = array();
        exec($command, $output);
        

        //process out and verify file convesion
        $this->processOutput($output);

        $song->setFullVersion($uniqueFileName);
        
        //update preview status on temp song
        $this->getContainer()->get('song.pending.manager')->updateSongFull($song);        
        return;
    }

}