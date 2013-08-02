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
class ActiveControllerTest extends WebTestCase
{

    /**
     * Test active list "/songs/active/list.html"
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

        $crawler = $client->request('GET', '/songs/active/list.html');

        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isSuccessful());

        //check if words are not available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Manage songs")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Manage songs")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("List")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());
    }


    
    /**
     * Test create download list active songs "/songs/active/download/excel/list.html"
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

        $crawler = $client->request('GET', '/songs/active/download/excel/list.html');

        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isSuccessful());
        
    }    
    

}
