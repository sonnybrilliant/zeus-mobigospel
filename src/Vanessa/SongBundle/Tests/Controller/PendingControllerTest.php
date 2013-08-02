<?php

namespace Vanessa\SongBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Site song test 
 * 
 * @author Mfana Ronald Conco <ronald.conco@mobigospel.co.za>
 * @package VanessaSongBundle
 * @subpackage Test
 * @version 0.0.1
 */
class PendingControllerTest extends WebTestCase
{

    /**
     * Test pending list "/songs/pending/list.html"
     */
    public function testList()
    {
        $client = static::createClient();
        $client->followRedirects(true);

        $crawler = $client->request('GET', '/login.html');


        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isSuccessful());

        //check if words are available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Welcome, please login")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Please Login")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Forgot password ?")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Having login trouble?")')->count());

        // select the login form
        $form = $crawler->selectButton('submit')->form();

        // submit the form with valid credentials
        $crawler = $client->submit(
            $form, array(
            '_username' => 'ronald.conco@mobigospel.co.za',
            '_password' => '654321',
            )
        );

        $crawler = $client->request('GET', '/songs/pending/list.html');

        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        //check if words are not available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Manage songs")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Manage songs")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("List")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());
    }

    /**
     * Test pending adding "/songs/add.html"
     */
    public function testAdd()
    {
        $client = static::createClient();
        $client->followRedirects(true);

        $crawler = $client->request('GET', '/login.html');


        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isSuccessful());

        //check if words are available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Welcome, please login")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Please Login")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Forgot password ?")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Having login trouble?")')->count());

        // select the login form
        $form = $crawler->selectButton('submit')->form();

        // submit the form with valid credentials
        $crawler = $client->submit(
            $form, array(
            '_username' => 'ronald.conco@mobigospel.co.za',
            '_password' => '654321',
            )
        );

        $crawler = $client->request('GET', '/songs/add.html');

        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        //check if words are not available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Add a song")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Add a song")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("All song fields are required.")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());
    }

    /**
     * Test pending adding "/songs/add.html"
     */
    public function testAddSong()
    {
        $client = static::createClient();
        $client->followRedirects(true);

        $crawler = $client->request('GET', '/login.html');


        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isSuccessful());

        //check if words are available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Welcome, please login")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Please Login")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Forgot password ?")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Having login trouble?")')->count());

        // select the login form
        $form = $crawler->selectButton('submit')->form();

        // submit the form with valid credentials
        $crawler = $client->submit(
            $form, array(
            '_username' => 'ronald.conco@mobigospel.co.za',
            '_password' => '654321',
            )
        );

        $crawler = $client->request('GET', '/songs/add.html');

        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isSuccessful());

        //check if words are not available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Add a song")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Add a song")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("All song fields are required.")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());


        // select the create content owner form
        $form = $crawler->selectButton('submit')->form();

        $audio = new UploadedFile(
                __DIR__ . '/../../../../../web/Test/sample.mp3',
                'sample.mp3',
                'audio/mpeg',
                5224963
        );

        // submit the form with valid credentials
        $songName = 'My Tribute-Redeemer ' . time();
        $featureArtist = 'Paul ' . time();

        $crawler = $client->submit(
            $form, array(
            'SongTemp[artist]' => 2,
            'SongTemp[title]' => $songName,
            'SongTemp[featuredArtist]' => $featureArtist,
            'SongTemp[genres]' => array(rand(1, 5), rand(6, 12)),
            'SongTemp[song]' => $audio,
            )
        );


        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isSuccessful());

        //check if words are not available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Manage songs")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Song was sucessfully added")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("List")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());
    }

    /**
     * Test pending edit "/songs/edit/songname.html"
     */
    public function testEdit()
    {
        $client = static::createClient();
        $client->followRedirects(true);

        $crawler = $client->request('GET', '/login.html');


        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isSuccessful());

        //check if words are available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Welcome, please login")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Please Login")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Forgot password ?")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Having login trouble?")')->count());

        // select the login form
        $form = $crawler->selectButton('submit')->form();

        // submit the form with valid credentials
        $crawler = $client->submit(
            $form, array(
            '_username' => 'ronald.conco@mobigospel.co.za',
            '_password' => '654321',
            )
        );

        $crawler = $client->request('GET', '/songs/add.html');

        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isSuccessful());

        //check if words are not available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Add a song")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Add a song")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("All song fields are required.")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());


        // select the create content owner form
        $form = $crawler->selectButton('submit')->form();

        $audio = new UploadedFile(
                __DIR__ . '/../../../../../web/Test/sample.mp3',
                'sample.mp3',
                'audio/mpeg',
                5224963
        );

        // submit the form with valid credentials
        $time = time();
        $songName = 'Redeemer ' . $time;
        $featureArtist = 'Sonny ' . $time;

        $crawler = $client->submit(
            $form, array(
            'SongTemp[artist]' => 2,
            'SongTemp[title]' => $songName,
            'SongTemp[featuredArtist]' => $featureArtist,
            'SongTemp[genres]' => array(rand(1, 5), rand(6, 12)),
            'SongTemp[song]' => $audio,
            )
        );


        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isSuccessful());

        //check if words are not available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Manage songs")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Song was sucessfully added")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("List")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());



        $crawler = $client->request('GET', "/songs/pending/edit/redeemer-$time.html");

        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isSuccessful());

        //check if words are not available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Edit")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Edit")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Audio file must be mp3.")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());

        // select the create content owner form
        $form = $crawler->selectButton('submit')->form();

        $audio = new UploadedFile(
                __DIR__ . '/../../../../../web/Test/sample.mp3',
                'sample.mp3',
                'audio/mpeg',
                5224963
        );

        $crawler = $client->submit(
            $form, array(
            'SongTemp[artist]' => 2,
            'SongTemp[title]' => $songName,
            'SongTemp[featuredArtist]' => 'Updated artist',
            'SongTemp[genres]' => array(rand(1, 5), rand(6, 12)),
            )
        );

        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isSuccessful());

        //check if words are not available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Manage songs")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Song was sucessfully updated")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("List")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());
    }
    
    /**
     * Test pending reject "/songs/pending/reject/redeemer-1375261364.html"
     */
    public function testReject()
    {
        $client = static::createClient();
        $client->followRedirects(true);

        $crawler = $client->request('GET', '/login.html');


        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isSuccessful());

        //check if words are available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Welcome, please login")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Please Login")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Forgot password ?")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Having login trouble?")')->count());

        // select the login form
        $form = $crawler->selectButton('submit')->form();

        // submit the form with valid credentials
        $crawler = $client->submit(
            $form, array(
            '_username' => 'ronald.conco@mobigospel.co.za',
            '_password' => '654321',
            )
        );

        $crawler = $client->request('GET', '/songs/add.html');

        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isSuccessful());

        //check if words are not available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Add a song")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Add a song")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("All song fields are required.")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());


        // select the create content owner form
        $form = $crawler->selectButton('submit')->form();

        $audio = new UploadedFile(
                __DIR__ . '/../../../../../web/Test/sample.mp3',
                'sample.mp3',
                'audio/mpeg',
                5224963
        );

        // submit the form with valid credentials
        $time = time();
        $songName = 'Redeemer ' . $time;
        $featureArtist = 'Sonny ' . $time;

        $crawler = $client->submit(
            $form, array(
            'SongTemp[artist]' => 2,
            'SongTemp[title]' => $songName,
            'SongTemp[featuredArtist]' => $featureArtist,
            'SongTemp[genres]' => array(rand(1, 5), rand(6, 12)),
            'SongTemp[song]' => $audio,
            )
        );


        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isSuccessful());

        //check if words are not available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Manage songs")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Song was sucessfully added")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("List")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());



        $crawler = $client->request('GET', "/songs/pending/reject/redeemer-$time.html");

        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isSuccessful());

        //check if words are not available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Reject")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Reject")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("You are about to reject the song ")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());

        // select the create content owner form
        $form = $crawler->selectButton('submit')->form();


        $crawler = $client->submit(
            $form, array(
            'SongRejectType[message]' => 'This is rejected',

            )
        );

        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isSuccessful());

        //check if words are not available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Manage songs")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Song was sucessfully rejected")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("List")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());
    } 
    
    /**
     * Test pending approved "/songs/pending/approve/stay-with-you.html"
     */
    public function testApproved()
    {
        $client = static::createClient();
        $client->followRedirects(true);

        $crawler = $client->request('GET', '/login.html');


        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isSuccessful());

        //check if words are available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Welcome, please login")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Please Login")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Forgot password ?")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Having login trouble?")')->count());

        // select the login form
        $form = $crawler->selectButton('submit')->form();

        // submit the form with valid credentials
        $crawler = $client->submit(
            $form, array(
            '_username' => 'ronald.conco@mobigospel.co.za',
            '_password' => '654321',
            )
        );

        $crawler = $client->request('GET', '/songs/add.html');

        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        //check if words are not available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Add a song")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Add a song")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("All song fields are required.")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());


        // select the create content owner form
        $form = $crawler->selectButton('submit')->form();

        $audio = new UploadedFile(
                __DIR__ . '/../../../../../web/Test/sample.mp3',
                'sample.mp3',
                'audio/mpeg',
                5224963
        );

        // submit the form with valid credentials
        $time = time();
        $songName = 'Redeemer ' . $time;
        $featureArtist = 'Sonny ' . $time;

        $crawler = $client->submit(
            $form, array(
            'SongTemp[artist]' => 2,
            'SongTemp[title]' => $songName,
            'SongTemp[featuredArtist]' => $featureArtist,
            'SongTemp[genres]' => array(rand(1, 5), rand(6, 12)),
            'SongTemp[song]' => $audio,
            )
        );


        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isSuccessful());

        //check if words are not available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Manage songs")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Song was sucessfully added")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("List")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());



        $crawler = $client->request('GET', "/songs/pending/approve/redeemer-$time.html");

        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isSuccessful());

        //check if words are not available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Manage songs")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Song was sucessfully approved")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("List")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());
       
    }     
    
    /**
     * Test create download list pending songs "/songs/pending/download/excel/list.html"
     */
    public function testCreateDownloadExcel()
    {
        $client = static::createClient();
        $client->followRedirects(true);

        $crawler = $client->request('GET', '/login.html');


        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isSuccessful());

        //check if words are available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Welcome, please login")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Please Login")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Forgot password ?")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Having login trouble?")')->count());

        // select the login form
        $form = $crawler->selectButton('submit')->form();

        // submit the form with valid credentials
        $crawler = $client->submit(
            $form, array(
            '_username' => 'ronald.conco@mobigospel.co.za',
            '_password' => '654321',
            )
        );

        $crawler = $client->request('GET', '/songs/pending/download/excel/list.html');

        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isSuccessful());
        
    }    
    

}
