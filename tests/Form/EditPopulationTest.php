<?php

namespace App\Tests\Form;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Repository\UserRepository;
use Symfony\Component\BrowserKit\Cookie as BrowserKitCookie;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class EditPopulationTest extends WebTestCase
{
    public function testEditPopulationWithAdmin()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);     
        $testUser = $userRepository->findOneByEmail('admin@gmail.com');
        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/population/1/edit');
        $form= $crawler->selectButton('Update')->form();
            
        $form['population[firstName]'] = 'testedit1' ;
        $form['population[lastName]'] = 'testedit1' ;
        


        $crawler = $client->submit($form);
        // $this->assertResponseRedirects('/population');
        $client->followRedirect();
        // $this->assertSelectorExists('.alert.alert-success');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testEditPopulationWithNotAuthenticatedUser()
    {
        $client = static::createClient();
        // $userRepository = static::$container->get(UserRepository::class);     
        // $testUser = $userRepository->findOneByEmail('admin@gmail.com');
        // $client->loginUser($testUser);

        $crawler = $client->request('GET', '/population/1/edit');
        // $form= $crawler->selectButton('Update')->form();
            
        // $form['population[firstName]'] = 'testedit2' ;
        // $form['population[lastName]'] = 'testedit2' ;
        


        // $crawler = $client->submit($form);
        // $this->assertResponseRedirects('/population');
        // $client->followRedirect();
        
        // $info = $crawler->filter('h1')->text();
        // $info = $string = trim(preg_replace('/\s\s+/', ' ', $info)); 
        // $this->assertSelectorExists('.alert.alert-success');
        // $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        // $this->assertSame("Please sign in", $info);
        $this->assertSame(302, $client->getResponse()->getStatusCode());
        $crawler = $client->followRedirect();
        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertTrue($crawler->filter('html:contains("Please sign in")')->count() > 0);
        
        
    }

    public function testAccessDeniedException()
{
    $client = static::createClient(array('debug' => false));

    $session = $client->getContainer()->get('session');
    $firewall = 'main';

    $token = new UsernamePasswordToken('user', null, $firewall, array('ROLE_USER'));

    $session->set("_security_$firewall", serialize($token));
    $session->save();

    $cookie = new BrowserKitCookie($session->getName(), $session->getId());
    $client->getCookieJar()->set($cookie);

    $client->request('GET', '/population/1/edit');

    $this->assertEquals(403, $client->getResponse()->getStatusCode());
    $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    
}


    public function testEditPopulationByNotAuthorWithAuthenticatedUser()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);     
        $testUser = $userRepository->findOneByEmail('bernard@gmail.com');
        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/population/1/edit');
        // $form= $crawler->selectButton('Update')->form();
            
        // $form['population[firstName]'] = 'testedit2' ;
        // $form['population[lastName]'] = 'testedit2' ;
        


        // $crawler = $client->submit($form);
        // $this->assertResponseRedirects('/population');
        // $client->followRedirect();
        
        // $info = $crawler->filter('h1')->text();
        // $info = $string = trim(preg_replace('/\s\s+/', ' ', $info)); 
        // $this->assertSelectorExists('.alert.alert-success');
        // $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        // $this->assertSame("Please sign in", $info);
        $this->assertSame(403, $client->getResponse()->getStatusCode());    
        
        
    }

    public function testEditPopulationByAuthorWithAuthenticatedUser()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);     
        $testUser = $userRepository->findOneByEmail('jules@gmail.com');
        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/population/1/edit');
        $this->assertSame(200, $client->getResponse()->getStatusCode());  
        $this->assertGreaterThan(0, $crawler->filter('h1')->count());
        $form= $crawler->selectButton('Update')->form();
            
        $form['population[firstName]'] = 'testedit3' ;
        $form['population[lastName]'] = 'testedit3' ;
        


        $crawler = $client->submit($form);
        // $this->assertResponseRedirects('/population');
        $crawler = $client->followRedirect();
        
        // $info = $crawler->filter('h1')->text();
        // $info = $string = trim(preg_replace('/\s\s+/', ' ', $info)); 
        // $this->assertSelectorExists('.alert.alert-success');
        // $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        // $this->assertSame("Please sign in", $info);
        $this->assertSame(200, $client->getResponse()->getStatusCode());   
        $this->assertGreaterThan(0, $crawler->filter('h1')->count());

        $this->assertSelectorExists('.alert.alert-success');
        
    }
}