<?php

namespace Vanessa\MemberBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Site security admin login 
 * 
 * @author Mfana Ronald Conco <ronald.conco@mobigospel.co.za>
 * @package VanessaCoreBundle
 * @subpackage Test
 * @version 0.0.1
 */
class SecurityAdminControllerTest extends WebTestCase
{

    /**
     * Test loing page  access "/login.html"
     */
    public function testLogin()
    {
        $client = static::createClient();
        $client->followRedirects(true);


        $crawler = $client->request('GET', '/login.html');

        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        //check if words are available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Welcome, please login")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Please Login")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Forgot password ?")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Having login trouble?")')->count());
    }

    /**
     * Test unsuccessful login "/login.html"
     */
    public function testLoginFailed()
    {
        $client = static::createClient();
        $client->followRedirects(true);


        $crawler = $client->request('GET', '/login.html');

        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        // select the login form
        $form = $crawler->selectButton('submit')->form();

        // submit the form with valid credentials
        $crawler = $client->submit(
            $form, array(
            '_username' => 'ronald.conco@sulehosting.co.za',
            '_password' => '654321',
            )
        );

        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isSuccessful());

        //check if words are not available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Welcome, please login")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Please Login")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Forgot password ?")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Having login trouble?")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Your username and password are invalid, please try again or contact support.")')->count());
    }

    /**
     * Test successful login "/login.html"
     */
    public function testLoginSuccess()
    {
        $client = static::createClient();
        $client->followRedirects(true);


        $crawler = $client->request('GET', '/login.html');

        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        // select the login form
        $form = $crawler->selectButton('submit')->form();

        // submit the form with valid credentials
        $crawler = $client->submit(
            $form, array(
            '_username' => 'ronald.conco@mobigospel.co.za',
            '_password' => '654321',
            )
        );

        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isSuccessful());

        //check if words are not available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Manage members")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Welcome Mfana Conco")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Manage members")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());
    }

    /**
     * Test link to forgot password "/login.html"
     */
    public function testLoginForgotPassword()
    {
        $client = static::createClient();
        $client->followRedirects(true);


        $crawler = $client->request('GET', '/login.html');

        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        
        //check if words are available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Welcome, please login")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Please Login")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Forgot password ?")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Having login trouble?")')->count());        

        $link =  $crawler->selectLink('Forgot password ?')->first()->link();
        $crawler = $client->click($link);

        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());        
        
        //check if words are not available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Reset password")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Reset password")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Reset trouble?")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Login")')->count());
    }

}
