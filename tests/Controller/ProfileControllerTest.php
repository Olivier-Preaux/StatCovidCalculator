<?php

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use App\Repository\PopulationRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\CssSelector\CssSelector;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\DomCrawler\Field\FormField;
use Symfony\Component\DomCrawler\Form;
use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Response;


class ProfileControllerTest extends WebTestCase
{
    // ...

    public function testVisitingWhileLoggedIn()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('admin@gmail.com');

        // simulate $testUser being logged in
        $client->loginUser($testUser);

        // test e.g. the profile page
        $client->request('GET', '/population/new');
        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Create new Population');
        

    }

    public function CreateNewPopulationWhileLoggedIn()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('admin@gmail.com');

        // simulate $testUser being logged in
        $client->loginUser($testUser);

        // test e.g. the profile page
        $crawler = $client->request('GET', '/population/new');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        // $client->followRedirects();

        $form = $crawler->selectButton('my-super-button')->form();
        
        // $form['firstName']->setValue('Sparow');
        // $form['lastName']->setValue('Jack');
        // $form['isVaccinatedFirstDose']->setValue('true');
        // $form['isVaccinatedSecondDose']->setValue('flase');
        // $form['observations']->setValue('azerty');
        // $client->submit($form);

        // $form['lastName'] = 'Sparow' ;
        // $form['firstName'] = 'Jack' ;

        $client->submit($form, array(
            'lastName'=>'Jack',
            'firstName'=>'Sparow',            
        ));
        $client->submit($form);

    //     $this->assertEquals(200, $client->getResponse()->getStatusCode());
    //     $this->assertRegexp(
    //     '/Veuillez renseigner ce champs./',
    //     $client->getResponse()->getContent()
    // );

        $this->assertContains('Nouveau patient créé',$client->getResponse()->getContent() );
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isRedirect('/population'));
    }

    public function testNewPopulationPageIsRestricted()
    {
        $client = static::createClient();
        $client->request('GET', '/population/new');
       
        $this->assertResponseRedirects('/login');

    }


    public function testVisited()
    {
        $client = static::createClient(); // Create crawler client.
        $client->followRedirects(); // After authenticating will redirect

        $crawler = $client->request('GET', '/'); // Get homepage.
        $link = $crawler->selectLink('- Vaccination')->link();
        $crawler = $client->click($link); // Click link.
        
        $this->assertSelectorTextContains( 'h1' , 'Patients');

        $showlink = $crawler->selectLink('show')->link();
        $crawler = $client->click($showlink); // Click link.
        
        $this->assertSelectorTextContains( 'h1' , 'Population');
    }

        

        

}



