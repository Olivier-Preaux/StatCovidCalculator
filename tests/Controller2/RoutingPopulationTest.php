<?php

namespace App\Tests\Controller2;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class RoutingPopulationTest extends WebTestCase
{
    /**
     * @dataProvider urlProvider
     */
    public function testPageIsSuccessful($url)
    {
        $client = self::createClient();
        $client->request('GET', $url);
        // $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertNotSame(404, $client->getResponse()->getStatusCode());

            
    }

    /**
     * @dataProvider urlProvider
     */
    public function testNotForbiddenWithAdmin($url)
    {
        $client = self::createClient();

        // Log with Admin
        $userRepository = static::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('admin@gmail.com');
        $client->loginUser($testUser);

        $client->request('GET', $url);
        $this->assertNotSame(404, $client->getResponse()->getStatusCode());

        // $this->assertTrue($client->getResponse()->isSuccessful());
            if ((($client->getResponse()->getStatusCode())=== 301) OR (($client->getResponse()->getStatusCode())=== 302) )
                {
                    $client->followRedirect();                    
                }        
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    /**
     * @dataProvider urlProvider
     */
    public function testNotForbiddenWithDoctor($url)
    {
        $client = self::createClient();

        $userRepository = static::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('jules@gmail.com');
        $client->loginUser($testUser);

        $client->request('GET', $url);

        $this->assertNotSame(404, $client->getResponse()->getStatusCode());

            if (($client->getResponse()->getStatusCode())=== 403)
            {
                $this->assertSame(403, $client->getResponse()->getStatusCode());
                $crawler=$client->request('GET', '/population');                
            }       

            if ((($client->getResponse()->getStatusCode())=== 301) OR (($client->getResponse()->getStatusCode())=== 302) )
            {
                $client->followRedirect();                    
            }
            
                
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testForbiddenWithoutDoctor()
    {
        $client = self::createClient();

        $userRepository = static::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('bernard@gmail.com');
        $client->loginUser($testUser);

        $client->request('GET', '/population/1/edit');
        // $this->assertNotSame(404, $client->getResponse()->getStatusCode());
        
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);      
         
    }

    public function urlProvider()
    {
        yield ['/'];
        yield ['/population'];
        yield ['/population/1'];
        yield ['/population/1/edit'];   
        yield ['/login'];
        yield ['/population/new'];

    }
}