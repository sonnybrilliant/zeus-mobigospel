<?php

namespace Vanessa\MemberBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Site security rest password
 * 
 * @author Mfana Ronald Conco <ronald.conco@mobigospel.co.za>
 * @package VanessaCoreBundle
 * @subpackage Test
 * @version 0.0.1
 */
class ResetControllerTest extends WebTestCase
{

    /**
     * Test reset page  access "/password/reset.html"
     */
    public function testReset()
    {
        $client = static::createClient();
        $client->followRedirects(true);


        $crawler = $client->request('GET', '/password/reset.html');

        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isSuccessful());

        //check if words are not available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Reset password")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Reset password")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Reset trouble?")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Login")')->count());
    }

    /**
     * test reset password invalid email /password/reset.html"
     */
    public function testInvalidEmail()
    {
        $client = static::createClient();
        $client->followRedirects(true);


        $crawler = $client->request('GET', '/password/reset.html');

        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isSuccessful());

        //check if words are not available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Reset password")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Reset password")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Reset trouble?")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Login")')->count());

        // select the login form
        $form = $crawler->selectButton('submit')->form();

        // submit the form with valid credentials
        $crawler = $client->submit(
            $form, array(
            'ResetPassword[email]' => 'ronald.conco@example.co.za',
            'recaptcha_response_field' => '1234'
            )
        );


        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isSuccessful());

        $this->assertEquals(1, $crawler->filter('title:contains("Reset password")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Reset password")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Reset trouble?")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Login")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("We couldn\'t find an account associated with ronald.conco@example.co.za.")')->count());
    }
    
    /**
     * test reset password valid /password/reset.html"
     */
    public function testResetValid()
    {
        $client = static::createClient();
        $client->followRedirects(true);


        $crawler = $client->request('GET', '/password/reset.html');

        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isSuccessful());

        //check if words are not available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Reset password")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Reset password")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Reset trouble?")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Login")')->count());

        // select the login form
        $form = $crawler->selectButton('submit')->form();

        // submit the form with valid credentials
        $crawler = $client->submit(
            $form, array(
            'ResetPassword[email]' => 'ronald.conco@mobigospel.co.za',
            'recaptcha_response_field' => '1234'
            )
        );


        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isSuccessful());

        $this->assertEquals(1, $crawler->filter('title:contains("Please check your email")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Please check your email")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("We\'ve sent you an email that will allow you to reset your password quickly and easily. Please check your email now.")')->count());

    }    


    /**
     * Test reset page  access invalid token "/reset/token/59swd2rrz8so4o0sgookgwcgcooggc4kk0k8wc0wgs48wwc0c1.html"
     */
    public function testResetTokenInvalid()
    {
        $client = static::createClient();
        $client->followRedirects(true);


        $crawler = $client->request('GET', '/reset/token/59swd2rrz8so4o0sgookgwcgcooggc4kk0k8wc0wgs48wwc0c1.html');

        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isSuccessful());

        //check if words are not available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Please check your email")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Invalid link, Please follow the instructions sent you via email.")')->count());
    }
    
    /**
     * Test reset page  valid token "/reset/token/59swd2rrz8so4o0sgookgwcgcooggc4kk0k8wc0wgs48wwc0c.html"
     */
    public function testResetTokenValid()
    {
        $client = static::createClient();
        $client->followRedirects(true);


        $crawler = $client->request('GET', '/reset/token/59swd2rrz8so4o0sgookgwcgcooggc4kk0k8wc0wgs48wwc0c.html');

        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isSuccessful());

        //check if words are not available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Create a new password")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Create a new password")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Password Hints?")')->count());
    } 
    
    /**
     * Test reset page  password change successful "/reset/token/59swd2rrz8so4o0sgookgwcgcooggc4kk0k8wc0wgs48wwc0c.html"
     */
    public function testResetTokenPasswordChanged()
    {
        $client = static::createClient();
        $client->followRedirects(true);


        $crawler = $client->request('GET', '/reset/token/59swd2rrz8so4o0sgookgwcgcooggc4kk0k8wc0wgs48wwc0c.html');

        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isSuccessful());

                // select the login form
        $form = $crawler->selectButton('submit')->form();

        // submit the form with valid credentials
        $crawler = $client->submit(
            $form, array(
            'ResetPassword[password][first]' => '654321',
            'ResetPassword[password][second]' => '654321'
            )
        );
        
                // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isSuccessful());

        //check if words are available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Welcome, please login")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Please Login")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Forgot password ?")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Having login trouble?")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Password change was successfully.")')->count());
        
    }     
    
}
