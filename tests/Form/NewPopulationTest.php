<?php

namespace App\Tests\Form;

use App\Entity\Population;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Repository\UserRepository;
use App\Repository\PopulationRepository;
use Symfony\Component\HttpFoundation\Response;




class NewPopulationTest extends WebTestCase
{
    public function testNewPopulationWithAdmin()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('admin@gmail.com');

        // simulate $testUser being logged in
        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/population/new');
        $form= $crawler->selectButton('save')->form();
            
        $form['population[firstName]'] = 'symfonyfan' ;
        $form['population[lastName]'] = 'symfonyfan2' ;
        


        $crawler = $client->submit($form);
        // $this->assertResponseRedirects('/population');
        $client->followRedirect();
        // $this->assertSelectorExists('.alert.alert-success');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testDeletePopulationWithAdmin()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('admin@gmail.com');
        $client->loginUser($testUser);


        /** @var UrlGeneratorInterface $urlGenerator */
        $urlGenerator = $client->getContainer()->get("router");

        /** @var EntityManagerInterface $entityManager */
        $entityManager = $client->getContainer()->get("doctrine.orm.entity_manager");

        /** @var Population $population */
        $population = $entityManager->getRepository(Population::class)->findOneBy(['lastName'=>'symfonyfan2']);

        $client->request('DELETE', $urlGenerator->generate("population_delete", ["id" => $population->getId() ]));
        $this->assertEquals(302, $client->getResponse()->getStatusCode()); 
        $client->followRedirect() ;    
        $this->assertEquals(200, $client->getResponse()->getStatusCode());        
    }


    public function testNewPopulationWithoutAdmin()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('bernard@gmail.com');

        // simulate $testUser being logged in
        $client->loginUser($testUser);

       $client->request('GET', '/population/new');
       
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    
    

}