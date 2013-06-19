<?php

namespace Vanessa\AgencyBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Site content owner test 
 * 
 * @author Mfana Ronald Conco <ronald.conco@mobigospel.co.za>
 * @package VanessaAgencyBundle
 * @subpackage Test
 * @version 0.0.1
 */
class ContentOwnerControllerTest extends WebTestCase
{

    /**
     * Test content owner list "/content/owner/list.html"
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

        $crawler = $client->request('GET', '/content/owner/list.html');

        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        //check if words are not available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Manage content owners")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Manage content owners")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("List")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());
    }

    /**
     * Test content owner new "'/content/owner/new.html"
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

        $crawler = $client->request('GET', '/content/owner/new.html');

        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        //check if words are not available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Create a content owner")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Create a content owner")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Create")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("All form fields are required")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Hint")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());
    }

    /**
     * Test content owner new "'/content/owner/create.html"
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

        $crawler = $client->request('GET', '/content/owner/create.html');

        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        //check if words are not available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Create a content owner")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Create a content owner")')->count());
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
            'ContentOwnerCreate[name]' => 'test base records',
            'ContentOwnerCreate[slogan]' => 'This is our slogan',
            'ContentOwnerCreate[description]' => 'This is a description',
            'ContentOwnerCreate[contactPerson]' => 'Contact person',
            'ContentOwnerCreate[contactNumber]' => '+27 (12) 567-4679',
            'ContentOwnerCreate[contactEmail]' => "$time@sulehosting.co.za",
            'ContentOwnerCreate[address1]' => '17 Boardwalk meander , Olympus Drive',
            'ContentOwnerCreate[address2]' => 'Farie Glen',
            'ContentOwnerCreate[suburbCode]' => '0105',
            'ContentOwnerCreate[postalBox]' => 'P.O. Box 25850',
            'ContentOwnerCreate[suburb]' => 'Monument Park',
            'ContentOwnerCreate[postalCode]' => '0105',
            )
        );


        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isSuccessful());

        //check if words are not available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Manage content owners")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Manage content owners")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("List")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Successful!")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Content owner was sucessfully created")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());
    }

    /**
     * Test content owner new "'/content/owner/create.html"
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

        $crawler = $client->request('GET', '/content/owner/create.html');

        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        //check if words are not available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Create a content owner")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Create a content owner")')->count());
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
            'ContentOwnerCreate[name]' => 'test locked records',
            'ContentOwnerCreate[slogan]' => 'This is our slogan',
            'ContentOwnerCreate[description]' => 'This is a description',
            'ContentOwnerCreate[contactPerson]' => 'Contact person',
            'ContentOwnerCreate[contactNumber]' => '+27 (12) 567-4679',
            'ContentOwnerCreate[contactEmail]' => "$time@sulehosting.co.za",
            'ContentOwnerCreate[address1]' => '17 Boardwalk meander , Olympus Drive',
            'ContentOwnerCreate[address2]' => 'Farie Glen',
            'ContentOwnerCreate[suburbCode]' => '0105',
            'ContentOwnerCreate[postalBox]' => 'P.O. Box 25850',
            'ContentOwnerCreate[suburb]' => 'Monument Park',
            'ContentOwnerCreate[postalCode]' => '0105',
            )
        );


        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isSuccessful());

        //check if words are not available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Manage content owners")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Manage content owners")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("List")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Successful!")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Content owner was sucessfully created")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());
    }

    /**
     * Test content owner new "'/content/owner/create.html"
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

        $crawler = $client->request('GET', '/content/owner/create.html');

        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        //check if words are not available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Create a content owner")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Create a content owner")')->count());
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
            'ContentOwnerCreate[name]' => 'test deleted records',
            'ContentOwnerCreate[slogan]' => 'This is our slogan',
            'ContentOwnerCreate[description]' => 'This is a description',
            'ContentOwnerCreate[contactPerson]' => 'Contact person',
            'ContentOwnerCreate[contactNumber]' => '+27 (12) 567-4679',
            'ContentOwnerCreate[contactEmail]' => "$time@sulehosting.co.za",
            'ContentOwnerCreate[address1]' => '17 Boardwalk meander , Olympus Drive',
            'ContentOwnerCreate[address2]' => 'Farie Glen',
            'ContentOwnerCreate[suburbCode]' => '0105',
            'ContentOwnerCreate[postalBox]' => 'P.O. Box 25850',
            'ContentOwnerCreate[suburb]' => 'Monument Park',
            'ContentOwnerCreate[postalCode]' => '0105',
            )
        );


        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isSuccessful());

        //check if words are not available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Manage content owners")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Manage content owners")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("List")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Successful!")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Content owner was sucessfully created")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());
    }

    /**
     * Test content owner update "content/owner/edit/test-base-records.html"
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

        $crawler = $client->request('GET', '/content/owner/edit/test-base-records.html');

        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        //check if words are not available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Edit - test base records")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Edit - test base records")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Edit")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Content owner details")')->count());
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
            'ContentOwnerCreate[name]' => 'test base records',
            'ContentOwnerCreate[slogan]' => 'This is our slogan updated',
            'ContentOwnerCreate[description]' => 'This is a description updated',
            'ContentOwnerCreate[contactPerson]' => 'Contact person',
            'ContentOwnerCreate[contactNumber]' => '+27 (12) 567-4679',
            'ContentOwnerCreate[contactEmail]' => "$time@sulehosting.co.za",
            'ContentOwnerCreate[address1]' => '17 Boardwalk meander , Olympus Drive',
            'ContentOwnerCreate[address2]' => 'Farie Glen',
            'ContentOwnerCreate[suburbCode]' => '0105',
            'ContentOwnerCreate[postalBox]' => 'P.O. Box 25850',
            'ContentOwnerCreate[suburb]' => 'Monument Park',
            'ContentOwnerCreate[postalCode]' => '0105',
            )
        );


        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isSuccessful());

        //check if words are not available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Manage content owners")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Manage content owners")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("List")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Successful!")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Content owner was sucessfully updated")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());
    }

    /**
     * Test content owner delete "content/owner/delete/test-deleted-records.html"
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

//        $crawler = $client->request('GET', '/content/owner/edit/test-deleted-records.html');
//
//        // response should be success
//        $this->assertEquals(200, $client->getResponse()->getStatusCode());
//        $this->assertTrue($client->getResponse()->isSuccessful());
//
//        //check if words are not available on the page
//        $this->assertEquals(1, $crawler->filter('title:contains("Manage content owners")')->count());
//        $this->assertEquals(1, $crawler->filter('html:contains("Manage content owners")')->count());
//        $this->assertEquals(1, $crawler->filter('html:contains("List")')->count());
//        $this->assertEquals(1, $crawler->filter('html:contains("Successful!")')->count());
//        $this->assertEquals(1, $crawler->filter('html:contains("Content owner was sucessfully deleted")')->count());
//        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());
    }

    /**
     * Test content owner profile "/content/owner/profile/test-base-records.html"
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

        $crawler = $client->request('GET', '/content/owner/profile/test-base-records.html');

        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        //check if words are not available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Profile - test base records")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Profile - test base records")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Profile")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Content owner details")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Account status")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Members")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());
    }

    /**
     * Test content owner account status show "/content/owner/account/status/show/test-base-records.html"
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

        $crawler = $client->request('GET', '/content/owner/account/status/show/test-base-records.html');

        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        //check if words are not available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Profile - test base records")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Profile - test base records")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Account status")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Content owner details")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Account status")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Members")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());
    }

    /**
     * Test content owner account status edit "/content/owner/account/status/edit/test-locked-records.html"
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

        $crawler = $client->request('GET', '/content/owner/account/status/edit/test-locked-records.html');

        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        //check if words are not available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Edit - test locked records")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Edit - test locked records")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains(" Edit")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Content owner details")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Account status")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Members")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());

        // select the account status edit form
        $form = $crawler->selectButton('submit')->form();

        // submit the form with valid credentials
        $crawler = $client->submit(
            $form, array(
            'ContentOwnerAccountStatusUpdate[accountStatus]' => 'lock',
            )
        );


        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isSuccessful());

        $this->assertEquals(1, $crawler->filter('title:contains("Manage content owners")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Manage content owners")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("List")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Successful!")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("You have successfully locked content owner account")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());
    }

    /**
     * Test content owner member list "/content/owner/members/test-base-records.html"
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

        $crawler = $client->request('GET', '/content/owner/members/test-base-records.html');

        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        //check if words are not available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Profile - test base records")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Profile - test base records")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Members")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Content owner details")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Account status")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Members")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());
    }

    /**
     * Test content owner artist list "/content/owner/artists/test-base-records.html"
     */
    public function testArtistList()
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

        $crawler = $client->request('GET', '/content/owner/artists/test-base-records.html');

        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        //check if words are not available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Profile - test base records")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Profile - test base records")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Artists")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Content owner details")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Account status")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Members")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());
    }

}
