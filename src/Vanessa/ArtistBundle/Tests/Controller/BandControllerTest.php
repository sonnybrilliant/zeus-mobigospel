<?php

namespace Vanessa\ArtistBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Site band test 
 * 
 * @author Mfana Ronald Conco <ronald.conco@mobigospel.co.za>
 * @package VanessaArtistBundle
 * @subpackage Test
 * @version 0.0.1
 */
class BandControllerTest extends WebTestCase
{

    /**
     * Test artist list "/artist/list.html"
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

        $crawler = $client->request('GET', '/artist/list.html');

        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        //check if words are not available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Manage artists")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Manage artists")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("List")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());
    }

    /**
     * Test artist new "/artist/new.html"
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

        $crawler = $client->request('GET', '/artist/new.html');

        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        //check if words are not available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Create new artist")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Create new artist")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Create")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("All form fields are required")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Hint")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());
    }

    /**
     * Test artist create "/artist/create.html"
     */
    public function testCreate()
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

        $crawler = $client->request('GET', '/artist/create.html');

        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        //check if words are not available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Create new artist")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Create new artist")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Create")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("All form fields are required")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Hint")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());
    }

    /**
     * Test create test artist "/artist/create.html"
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

        $crawler = $client->request('GET', '/artist/create.html');

        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        //check if words are not available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Create new artist")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Create new artist")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Create")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("All form fields are required")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Hint")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());

        // select the create content owner form
        $form = $crawler->selectButton('submit')->form();

        $photo = new UploadedFile(
                __DIR__ . '/../../../../../web/Test/sample2.jpg',
                'sample2.jpg',
                'image/jpeg',
                148081
        );

        // submit the form with valid credentials
        $stageName = 'Tumi and the volumes ' . time();

        $crawler = $client->submit(
            $form, array(
            'ArtistCreate[agency]' => 2,
            'ArtistCreate[isGroup]' => 1,
            'ArtistCreate[stageName]' => $stageName,
            'ArtistCreate[genres]' => array(rand(1, 5), rand(6, 12)),
            'ArtistCreate[picture]' => $photo,
            'ArtistCreate[shortBiography]' => 'short biography of band',
            )
        );


        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isSuccessful());

        //check if words are available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Manage artists")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Manage artists")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("List")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Successful!")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Artist was sucessfully created.")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());
    }

    /**
     * Test create edit artist "/artist/edit.html"
     */
    public function testCreateEdit()
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

        $crawler = $client->request('GET', '/artist/create.html');

        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        //check if words are not available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Create new artist")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Create new artist")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Create")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("All form fields are required")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Hint")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());

        // select the create content owner form
        $form = $crawler->selectButton('submit')->form();

        $photo = new UploadedFile(
                __DIR__ . '/../../../../../web/Test/sample2.jpg',
                'sample2.jpg',
                'image/jpeg',
                148081
        );

        // submit the form with valid credentials
        $time = time();
        $stageName = 'Dave mathews ' . $time;

        $crawler = $client->submit(
            $form, array(
            'ArtistCreate[agency]' => 2,
            'ArtistCreate[isGroup]' => 1,
            'ArtistCreate[stageName]' => $stageName,
            'ArtistCreate[genres]' => array(rand(1, 5), rand(6, 12)),
            'ArtistCreate[picture]' => $photo,
            'ArtistCreate[shortBiography]' => 'short biography of band',
            )
        );


        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isSuccessful());

        //check if words are available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Manage artists")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Manage artists")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("List")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Successful!")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Artist was sucessfully created.")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());


        $crawler = $client->request('GET', '/artist/edit/dave-mathews-' . $time . '.html');

        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        //check if words are available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Edit -")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Edit -")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Edit")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Artist details")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Account status")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());

        // select the create content owner form
        $form = $crawler->selectButton('submit')->form();

        $photo = new UploadedFile(
                __DIR__ . '/../../../../../web/Test/sample2.jpg',
                'sample2.jpg',
                'image/jpeg',
                148081
        );


        $crawler = $client->submit(
            $form, array(
            'ArtistCreate[isGroup]' => 1,
            'ArtistCreate[stageName]' => $stageName,
            'ArtistCreate[genres]' => array(rand(1, 5), rand(6, 12)),
            'ArtistCreate[picture]' => $photo,
            'ArtistCreate[shortBiography]' => 'short biography update of band updated',
            )
        );

        //check if words are available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Manage artists")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Manage artists")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("List")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Successful!")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Artist was sucessfully updated.")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());
    }

    /**
     * Test create edit artist "/artist/profile.html"
     */
    public function testCreateProfile()
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

        $crawler = $client->request('GET', '/artist/create.html');

        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        //check if words are not available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Create new artist")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Create new artist")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Create")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("All form fields are required")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Hint")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());

        // select the create content owner form
        $form = $crawler->selectButton('submit')->form();

        $photo = new UploadedFile(
                __DIR__ . '/../../../../../web/Test/sample2.jpg',
                'sample2.jpg',
                'image/jpeg',
                148081
        );

        // submit the form with valid credentials
        $time = time();
        $stageName = 'U2 ' . $time;

        $crawler = $client->submit(
            $form, array(
            'ArtistCreate[agency]' => 2,
            'ArtistCreate[isGroup]' => 1,
            'ArtistCreate[stageName]' => $stageName,
            'ArtistCreate[gender]' => 2,
            'ArtistCreate[genres]' => array(rand(1, 5), rand(6, 12)),
            'ArtistCreate[picture]' => $photo,
            'ArtistCreate[shortBiography]' => 'short biography of band',
            )
        );


        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isSuccessful());

        //check if words are available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Manage artists")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Manage artists")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("List")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Successful!")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Artist was sucessfully created.")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());


        $crawler = $client->request('GET', '/artist/profile/u2-' . $time . '.html');

        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        //check if words are available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Profile - ")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Profile - ")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Profile")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Artist details")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Account status")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());
    }

    /**
     * Test create edit artist "/artist/delete.html"
     */
    public function testCreateDelete()
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

        $crawler = $client->request('GET', '/artist/create.html');

        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        //check if words are not available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Create new artist")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Create new artist")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Create")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("All form fields are required")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Hint")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());

        // select the create content owner form
        $form = $crawler->selectButton('submit')->form();

        $photo = new UploadedFile(
                __DIR__ . '/../../../../../web/Test/sample2.jpg',
                'sample2.jpg',
                'image/jpeg',
                148081
        );

        // submit the form with valid credentials
        $time = time();
        $stageName = 'Queen ' . $time;

        $crawler = $client->submit(
            $form, array(
            'ArtistCreate[agency]' => 2,
            'ArtistCreate[isGroup]' => 1,
            'ArtistCreate[stageName]' => $stageName,
            'ArtistCreate[genres]' => array(rand(1, 5), rand(6, 12)),
            'ArtistCreate[picture]' => $photo,
            'ArtistCreate[shortBiography]' => 'short biography of band',
            )
        );


        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isSuccessful());

        //check if words are available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Manage artists")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Manage artists")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("List")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Successful!")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Artist was sucessfully created.")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());


        $crawler = $client->request('GET', '/artist/delete/queen-' . $time . '.html');

        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        //check if words are available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Manage artists")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Manage artists")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("List")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Successful!")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Artist was sucessfully deleted.")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());
    }
    
    /**
     * Test create edit artist "/artist/account/status/show.html"
     */
    public function testCreateAccountStatusShow()
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

        $crawler = $client->request('GET', '/artist/create.html');

        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        //check if words are not available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Create new artist")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Create new artist")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Create")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("All form fields are required")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Hint")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());

        // select the create content owner form
        $form = $crawler->selectButton('submit')->form();

        $photo = new UploadedFile(
                __DIR__ . '/../../../../../web/Test/sample2.jpg',
                'sample2.jpg',
                'image/jpeg',
                148081
        );

        // submit the form with valid credentials
        $time = time();
        $stageName = 'Red hot chilli pappers ' . $time;

        $crawler = $client->submit(
            $form, array(
            'ArtistCreate[agency]' => 2,
            'ArtistCreate[isGroup]' => 1,
            'ArtistCreate[stageName]' => $stageName,
            'ArtistCreate[genres]' => array(rand(1, 5), rand(6, 12)),
            'ArtistCreate[picture]' => $photo,
            'ArtistCreate[shortBiography]' => 'short biography of artist',
            )
        );


        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isSuccessful());

        //check if words are available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Manage artists")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Manage artists")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("List")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Successful!")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Artist was sucessfully created.")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());


        $crawler = $client->request('GET', '/artist/account/status/show/red-hot-chilli-pappers-' . $time . '.html');

        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        //check if words are available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Profile - ")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Profile - ")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Account status")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Active")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Locked")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Deleted")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Hint")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());
    }
    
    /**
     * Test create edit artist "/artist/account/status/edit.html"
     */
    public function testCreateAccountStatusEditLock()
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

        $crawler = $client->request('GET', '/artist/create.html');

        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        //check if words are not available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Create new artist")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Create new artist")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Create")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("All form fields are required")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Hint")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());

        // select the create content owner form
        $form = $crawler->selectButton('submit')->form();

        $photo = new UploadedFile(
                __DIR__ . '/../../../../../web/Test/sample2.jpg',
                'sample2.jpg',
                'image/jpeg',
                148081
        );

        // submit the form with valid credentials
        $time = time();
        $stageName = 'athlete ' . $time;

        $crawler = $client->submit(
            $form, array(
            'ArtistCreate[agency]' => 2,
            'ArtistCreate[isGroup]' => 1,
            'ArtistCreate[stageName]' => $stageName,
            'ArtistCreate[genres]' => array(rand(1, 5), rand(6, 12)),
            'ArtistCreate[picture]' => $photo,
            'ArtistCreate[shortBiography]' => 'short biography of artist',
            )
        );


        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isSuccessful());

        //check if words are available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Manage artists")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Manage artists")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("List")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Successful!")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Artist was sucessfully created.")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());


        $crawler = $client->request('GET', '/artist/account/status/edit/athlete-' . $time . '.html');

        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        //check if words are available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Edit - ")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Edit -")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains(" Edit")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Hint")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());
        
        // select the create content owner form
        $form = $crawler->selectButton('submit')->form();

        // submit the form with valid credentials
        $time = time();
        $stageName = 'smash williams ' . $time;

        $crawler = $client->submit(
            $form, array(
            'AccountStatusUpdate[accountStatus]' => 'lock',
            )
        );        
        
        //check if words are available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Manage artists")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Manage artists")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("List")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Successful!")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("You have successfully locked artist account.")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());        
        
    }
    
    
    /**
     * Test create edit artist "/artist/account/status/edit.html"
     */
    public function testCreateAccountStatusEditActivate()
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

        $crawler = $client->request('GET', '/artist/create.html');

        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        //check if words are not available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Create new artist")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Create new artist")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Create")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("All form fields are required")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Hint")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());

        // select the create content owner form
        $form = $crawler->selectButton('submit')->form();

        $photo = new UploadedFile(
                __DIR__ . '/../../../../../web/Test/sample2.jpg',
                'sample2.jpg',
                'image/jpeg',
                148081
        );

        // submit the form with valid credentials
        $time = time();
        $stageName = 'Az ' . $time;

        $crawler = $client->submit(
            $form, array(
            'ArtistCreate[agency]' => 2,
            'ArtistCreate[isGroup]' => 1,
            'ArtistCreate[stageName]' => $stageName,
            'ArtistCreate[genres]' => array(rand(1, 5), rand(6, 12)),
            'ArtistCreate[picture]' => $photo,
            'ArtistCreate[shortBiography]' => 'short biography of artist',
            )
        );


        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isSuccessful());

        //check if words are available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Manage artists")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Manage artists")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("List")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Successful!")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Artist was sucessfully created.")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());


        $crawler = $client->request('GET', '/artist/account/status/edit/az-' . $time . '.html');

        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        //check if words are available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Edit - ")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Edit -")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains(" Edit")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Hint")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());
        
        // select the create content owner form
        $form = $crawler->selectButton('submit')->form();

        // submit the form with valid credentials
        $time = time();

        $crawler = $client->submit(
            $form, array(
            'AccountStatusUpdate[accountStatus]' => 'activate',
            )
        );        
        
        //check if words are available on the page
        $this->assertEquals(1, $crawler->filter('title:contains("Manage artists")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Manage artists")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("List")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Successful!")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("You have successfully activated artist account.")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Logout")')->count());        
        
    }    
    
    
    /**
     * Test create download list artist "/artist/download/excel/list.html"
     */
    public function testCreateDownloadExcel()
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

        $crawler = $client->request('GET', '/artist/download/excel/list.html');

        // response should be success
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        
    }    

}
