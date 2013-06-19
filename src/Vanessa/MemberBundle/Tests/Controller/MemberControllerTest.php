<?php

namespace Vanessa\MemberBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Site member bundle test 
 * 
 * @author Mfana Ronald Conco <ronald.conco@mobigospel.co.za>
 * @package VanessaCoreBundle
 * @subpackage Test
 * @version 0.0.1
 */
class MemberControllerTest extends WebTestCase
{

    /**
     * Test member list "/member/list.html"
     */
    public function testList()
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

        // select the login form
        $form = $crawler->selectButton('submit')->form();

        // submit the form with valid credentials
        $crawler = $client->submit(
            $form, array(
            '_username' => 'ronald.conco@mobigospel.co.za',
            '_password' => '654321',
            )
        );

        $crawler = $client->request('GET', '/member/list.html');

        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        //check if words are not available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Manage members")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Manage members")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("List")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());
    }

    /**
     * Test member create "/member/new.html"
     */
    public function testCreateTest()
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

        $crawler = $client->request('GET', '/member/new.html');

        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        //check if words are not available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Create a member")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Create a member")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("All form fields are required")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());

        // select the login form
        $form = $crawler->selectButton('submit')->form();

        // submit the form with valid credentials
        $time = time();

        $crawler = $client->submit(
            $form, array(
            'Member[agency]' => '1',
            'Member[title]' => '1',
            'Member[gender]' => '1',
            'Member[firstName]' => 'Test',
            'Member[lastName]' => 'User',
            'Member[mobileNumber]' => '27713264125',
            'Member[group]' => '3',
            'Member[email][first]' => "$time@sulehosting.co.za",
            'Member[email][second]' => "$time@sulehosting.co.za",
            )
        );


        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isSuccessful());

        //check if words are not available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Manage members")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Manage members")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("List")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());
    }

    /**
     * Test member create "/member/new.html"
     */
    public function testCreateDeleteUser()
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

        $crawler = $client->request('GET', '/member/new.html');

        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        //check if words are not available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Create a member")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Create a member")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("All form fields are required")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());

        // select the login form
        $form = $crawler->selectButton('submit')->form();

        // submit the form with valid credentials
        $time = time();

        $crawler = $client->submit(
            $form, array(
            'Member[agency]' => '1',
            'Member[title]' => '1',
            'Member[gender]' => '1',
            'Member[firstName]' => 'Test',
            'Member[lastName]' => 'Delete',
            'Member[mobileNumber]' => '27713264125',
            'Member[group]' => '2',
            'Member[email][first]' => "$time@sulehosting.co.za",
            'Member[email][second]' => "$time@sulehosting.co.za",
            )
        );


        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isSuccessful());

        //check if words are not available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Manage members")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Manage members")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("List")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());
    }

    /**
     * Test member create "/member/new.html"
     */
    public function testCreateLockedUser()
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

        $crawler = $client->request('GET', '/member/new.html');

        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        //check if words are not available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Create a member")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Create a member")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("All form fields are required")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());

        // select the login form
        $form = $crawler->selectButton('submit')->form();

        // submit the form with valid credentials
        $time = time();

        $crawler = $client->submit(
            $form, array(
            'Member[agency]' => '1',
            'Member[title]' => '1',
            'Member[gender]' => '1',
            'Member[firstName]' => 'Test',
            'Member[lastName]' => 'Locked',
            'Member[mobileNumber]' => '27713264125',
            'Member[group]' => '3',
            'Member[email][first]' => "$time@sulehosting.co.za",
            'Member[email][second]' => "$time@sulehosting.co.za",
            )
        );


        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isSuccessful());

        //check if words are not available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Manage members")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Manage members")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("List")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());
    }

    /**
     * Test member edit "/member/edit.html"
     */
    public function testEdit()
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

        $crawler = $client->request('GET', '/member/edit/test-user.html');

        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        //check if words are not available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Edit - Test User")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Edit - Test User")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());

        // select the register account form
        $form = $crawler->selectButton('submit')->form();

        // submit the form with valid credentials
        $crawler = $client->submit(
            $form, array(
            'Member[agency]' => '1',
            'Member[title]' => '2',
            'Member[gender]' => '2',
            'Member[firstName]' => 'Test',
            'Member[lastName]' => 'User',
            'Member[mobileNumber]' => '27713264125',
            'Member[group]' => '1',
            )
        );


        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isSuccessful());

        //check if words are not available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Manage members")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Manage members")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("List")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());
    }

    /**
     * Test member profile "/member/edit.html"
     */
    public function testProfile()
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

        $crawler = $client->request('GET', '/member/profile/test-user.html');

        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        //check if words are not available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Profile")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Profile")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Member details")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());
    }

    /**
     * Test member account status show "/member/edit.html"
     */
    public function testAccountStatusShow()
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

        $crawler = $client->request('GET', '/member/account/status/show/test-user.html');

        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        //check if words are not available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Profile - Test User")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Profile - Test User")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Account status")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());
    }

    /**
     * Test member account status edit "/member/edit.html"
     */
    public function testAccountStatusEdit()
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

        $crawler = $client->request('GET', '/member/account/status/edit/test-locked.html');

        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        //check if words are not available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Edit - Test Locked")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Edit - Test Locked")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());

        // select the account status form
        $form = $crawler->selectButton('submit')->form();

        // submit the form with valid credentials
        $crawler = $client->submit(
            $form, array(
            'MemberAccountStatusUpdate[accountStatus]' => 'lock',
            )
        );


        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isSuccessful());

        //check if words are not available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Manage members")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Manage members")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("List")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());
    }

    /**
     * Test member delete "/member/delete.html"
     */
    public function testDelete()
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

        $crawler = $client->request('GET', '/member/delete/test-delete.html');

        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isSuccessful());

        //check if words are not available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Manage members")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Manage members")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("List")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());
    }

    /**
     * 
     * Test excel document download "/member/download/excel/list.html"
     */
    public function testDownloadExcel()
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

        $crawler = $client->request('GET', '/member/download/excel/list.html');

        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isSuccessful());
    }

}
