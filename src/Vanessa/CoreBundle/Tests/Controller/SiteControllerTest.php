<?php

namespace Vanessa\CoreBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Site test 
 * 
 * @author Mfana Ronald Conco <ronald.conco@mobigospel.co.za>
 * @package VanessaCoreBundle
 * @subpackage Test
 * @version 0.0.1
 */
class SiteControllerTest extends WebTestCase
{
    /**
     * Test index page "/"
     */
    public function testIndex()
    {
        $client = static::createClient();
        $client->followRedirects(true);


        $crawler = $client->request('GET', '/');

        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        //check if words are available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Welcome")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Top downloads")')->count());
    }
    
    /**
     * Test about us page "/aboutUs"
     */
    public function testAboutUs()
    {
        $client = static::createClient();
        $client->followRedirects(true);


        $crawler = $client->request('GET', '/aboutUs.html');

        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        //check if words are available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("About Us")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("About Us")')->count());
    }
    
    /**
     * Test contact us page "/contactUs"
     */
    public function testContactUs()
    {
        $client = static::createClient();
        $client->followRedirects(true);


        $crawler = $client->request('GET', '/contactUs.html');

        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        //check if words are available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Contact Us")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Contact Us")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Email")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Tel")')->count());
    }

}
