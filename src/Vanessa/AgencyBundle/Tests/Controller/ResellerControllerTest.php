<?php

namespace Vanessa\AgencyBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Site reseller test 
 * 
 * @author Mfana Ronald Conco <ronald.conco@mobigospel.co.za>
 * @package VanessaAgencyBundle
 * @subpackage Test
 * @version 0.0.1
 */
class ResellerControllerTest extends WebTestCase
{

    /**
     * Test reseller list "/reseller/list.html"
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

        $crawler = $client->request('GET', '/reseller/list.html');

        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        //check if words are not available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Manage resellers")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Manage resellers")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("List")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());
    }

    /**
     * Test reseller new "/reseller/new.html"
     */
    public function testNew()
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

        $crawler = $client->request('GET', '/reseller/new.html');

        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        //check if words are not available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Create a reseller")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Create a reseller")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Create")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("All form fields are required")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Hint")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());
    }

    /**
     * Test reseller create "/reseller/create.html"
     */
    public function testCreateBase()
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

        $crawler = $client->request('GET', '/reseller/create.html');

        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        //check if words are not available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Create a reseller")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Create a reseller")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Create")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("All form fields are required")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Hint")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());

        // select the create content owner form
        $form = $crawler->selectButton('submit')->form();

        // submit the form with valid credentials
        $time = time();

        $crawler = $client->submit(
            $form, array(
            'ResellerCreate[name]' => 'test base records',
            'ResellerCreate[slogan]' => 'This is our slogan',
            'ResellerCreate[description]' => 'This is a description',
            'ResellerCreate[contactPerson]' => 'Contact person',
            'ResellerCreate[contactNumber]' => '+27 (12) 567-4679',
            'ResellerCreate[contactEmail]' => "$time@sulehosting.co.za",
            'ResellerCreate[address1]' => '17 Boardwalk meander , Olympus Drive',
            'ResellerCreate[address2]' => 'Farie Glen',
            'ResellerCreate[suburbCode]' => '0105',
            'ResellerCreate[postalBox]' => 'P.O. Box 25850',
            'ResellerCreate[suburb]' => 'Monument Park',
            'ResellerCreate[postalCode]' => '0105',
            )
        );


        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isSuccessful());

        //check if words are not available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Manage resellers")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Manage resellers")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("List")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Successful!")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Reseller was sucessfully created")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());        
        
    }

    /**
     * Test reseller locked "/reseller/create.html"
     */
    public function testCreateLocked()
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

        $crawler = $client->request('GET', '/reseller/create.html');

        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        //check if words are not available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Create a reseller")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Create a reseller")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Create")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("All form fields are required")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Hint")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());

        // select the create content owner form
        $form = $crawler->selectButton('submit')->form();

        // submit the form with valid credentials
        $time = time();

        $crawler = $client->submit(
            $form, array(
            'ResellerCreate[name]' => 'test locked records',
            'ResellerCreate[slogan]' => 'This is our slogan',
            'ResellerCreate[description]' => 'This is a description',
            'ResellerCreate[contactPerson]' => 'Contact person',
            'ResellerCreate[contactNumber]' => '+27 (12) 567-4679',
            'ResellerCreate[contactEmail]' => "$time@sulehosting.co.za",
            'ResellerCreate[address1]' => '17 Boardwalk meander , Olympus Drive',
            'ResellerCreate[address2]' => 'Farie Glen',
            'ResellerCreate[suburbCode]' => '0105',
            'ResellerCreate[postalBox]' => 'P.O. Box 25850',
            'ResellerCreate[suburb]' => 'Monument Park',
            'ResellerCreate[postalCode]' => '0105',
            )
        );


        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isSuccessful());

        //check if words are not available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Manage resellers")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Manage resellers")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("List")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Successful!")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Reseller was sucessfully created")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count()); 
    }

    /**
     * Test reseller deleted "/reseller/create.html"
     */
    public function testCreateDeleted()
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

        $crawler = $client->request('GET', '/reseller/create.html');

        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        //check if words are not available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Create a reseller")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Create a reseller")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Create")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("All form fields are required")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Hint")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());

        // select the create content owner form
        $form = $crawler->selectButton('submit')->form();

        // submit the form with valid credentials
        $time = time();

        $crawler = $client->submit(
            $form, array(
            'ResellerCreate[name]' => 'test deleted records',
            'ResellerCreate[slogan]' => 'This is our slogan',
            'ResellerCreate[description]' => 'This is a description',
            'ResellerCreate[contactPerson]' => 'Contact person',
            'ResellerCreate[contactNumber]' => '+27 (12) 567-4679',
            'ResellerCreate[contactEmail]' => "$time@sulehosting.co.za",
            'ResellerCreate[address1]' => '17 Boardwalk meander , Olympus Drive',
            'ResellerCreate[address2]' => 'Farie Glen',
            'ResellerCreate[suburbCode]' => '0105',
            'ResellerCreate[postalBox]' => 'P.O. Box 25850',
            'ResellerCreate[suburb]' => 'Monument Park',
            'ResellerCreate[postalCode]' => '0105',
            )
        );


        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isSuccessful());

        //check if words are not available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Manage resellers")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Manage resellers")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("List")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Successful!")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Reseller was sucessfully created")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count()); 
    }

    /**
     * Test reseller update "/reseller/edit/test-base-records.html"
     */
    public function testUpdate()
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

        $crawler = $client->request('GET', '/reseller/edit/test-base-records.html');

        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        //check if words are not available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Edit - test base records")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Edit - test base records")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Edit")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Reseller details")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Account status")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Members")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Hint")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());

        // select the create content owner form
        $form = $crawler->selectButton('submit')->form();

        // submit the form with valid credentials
        $time = time();

        $crawler = $client->submit(
            $form, array(
            'ResellerCreate[name]' => 'test base records',
            'ResellerCreate[slogan]' => 'This is our slogan updated',
            'ResellerCreate[description]' => 'This is a description updated',
            'ResellerCreate[contactPerson]' => 'Contact person',
            'ResellerCreate[contactNumber]' => '+27 (12) 567-4679',
            'ResellerCreate[contactEmail]' => "$time@sulehosting.co.za",
            'ResellerCreate[address1]' => '17 Boardwalk meander , Olympus Drive',
            'ResellerCreate[address2]' => 'Farie Glen',
            'ResellerCreate[suburbCode]' => '0105',
            'ResellerCreate[postalBox]' => 'P.O. Box 25850',
            'ResellerCreate[suburb]' => 'Monument Park',
            'ResellerCreate[postalCode]' => '0105',
            )
        );


        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isSuccessful());

        //check if words are not available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Manage resellers")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Manage resellers")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("List")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Successful!")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Reseller was sucessfully updated")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count()); 
    }

    /**
     * Test reseller delete "/reseller/test-deleted-records.html"
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


    }

    /**
     * Test reseller profile "/reseller/profile/test-base-records.html"
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

        $crawler = $client->request('GET', '/reseller/profile/test-base-records.html');

        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        //check if words are not available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Profile - test base records")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Profile - test base records")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Profile")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Reseller details")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Account status")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Members")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());
    }

    /**
     * Test reseller account status show "/reseller/account/status/show/test-base-records.html"
     */
    public function testAccoutStatusShow()
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

        $crawler = $client->request('GET', '/reseller/account/status/show/test-base-records.html');

        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        //check if words are not available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Profile - test base records")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Profile - test base records")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Account status")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Reseller details")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Account status")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Members")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());
    }

    /**
     * Test reseller account status edit "/reseller/account/status/edit/test-locked-records.html"
     */
    public function testAccoutStatusEdit()
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

        $crawler = $client->request('GET', '/reseller/account/status/edit/test-locked-records.html');

        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        //check if words are not available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Edit - test locked records")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Edit - test locked records")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains(" Edit")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Reseller details")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Account status")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Members")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());

        // select the account status edit form
        $form = $crawler->selectButton('submit')->form();

        // submit the form with valid credentials
        $crawler = $client->submit(
            $form, array(
            'ResellerAccountStatusUpdate[accountStatus]' => 'lock',
            )
        );


        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isSuccessful());

        $this->assertEquals(1, $crawler->filter('title:contains("Manage resellers")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Manage resellers")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("List")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Successful!")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("You have successfully locked reseller account.")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());
    }

    /**
     * Test reseller member list "/reseller/members/test-base-records.html"
     */
    public function testMemberList()
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

        $crawler = $client->request('GET', '/reseller/members/test-base-records.html');

        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        //check if words are not available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Profile - Members - test base records")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Profile test base records")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Members")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Reseller details")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Account status")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Members")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());
    }

}
