<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\UserRepository;


class SecurityControllerTest extends WebTestCase
{
    public function testLoginSecurity()
    {
        $client = static::createClient();

        $client->request('GET', '/login');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        
    }

    public function testLogoutSecurityWhenNotAuthenticated()
    {
        $client = static::createClient();

        $client->request('GET', '/logout');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        
    }

    

    public function testDisplayLogin()
    {
        $client = static::createClient();
        $client->request('GET', '/login');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorTextContains('h1','Please sign in');
        $this->assertSelectorNotExists('.alert.alert-danger');
    }

    public function testLoginWithBadCredentials()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        $form= $crawler->selectButton('Se connecter')->form([
            'email'=>'bademail@gmail.com',
            'password' => 'fakepassword'
        ]) ;
        $client->submit($form);
        $this->assertResponseRedirects('/login');
        $client->followRedirect();
        $this->assertSelectorExists('.alert.alert-danger');
    }

    public function testLoginSuccessfull()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        $form= $crawler->selectButton('Se connecter')->form([
            'email'=>'admin@gmail.com',
            'password' => 'adminpassword'
        ]) ;
        $client->submit($form);
        $this->assertResponseRedirects('/');
        $client->followRedirect();
        // $this->assertSelectorExists('.alert.alert-success');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testLoginSuccessfullWithTokenCsrf()
    {
        $client = static::createClient();
        $csrfToken = $client->getContainer()->get('security.csrf.token_manager')->getToken('authenticate');
        $client->request('POST', '/login' , [
                '_csrf_token' =>$csrfToken,
                'email'=>'admin@gmail.com',
                'password' => 'adminpassword'
        ]);
        $this->assertResponseRedirects('/');
        $crawler = $client->followRedirect();

        $this->assertSame(200, $client->getResponse()->getStatusCode());   
        $this->assertGreaterThan(0, $crawler->filter('h1')->count());

        // $this->assertSelectorExists('.alert.alert-success');

        // $this->assertSelectorExists('.alert.alert-success');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        }
}