<?php

namespace App\Tests\Controller;

use App\Entity\Population;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class PopulationControllerTest extends WebTestCase
{
    public function testIndexPopulation()
    {
        $client = static::createClient();

        // $client->getContainer();
        // $client->getKernel();

        $client->request('GET', '/population');
        $this->assertEquals(301, $client->getResponse()->getStatusCode());
        $crawler = $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        
    }

    public function testShowPopulation()
    {
        $client = static::createClient();

        /** @var UrlGeneratorInterface $urlGenerator */
        $urlGenerator = $client->getContainer()->get("router");

        /** @var EntityManagerInterface $entityManager */
        $entityManager = $client->getContainer()->get("doctrine.orm.entity_manager");

        /** @var Population $population */
        $population = $entityManager->getRepository(Population::class)->findOneBy([]);

        $client->request('GET', $urlGenerator->generate("population_show", ["id" => $population->getId() ]));

        $this->assertEquals(200, $client->getResponse()->getStatusCode());        
    }

    public function testEditPopulation()
    {
        $client = static::createClient();

        $client->request('GET', '/population/1/edit');

        $this->assertEquals(302, $client->getResponse()->getStatusCode()); 
        $crawler = $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());   
    }

    public function testDeletePopulation()
    {
        $client = static::createClient();

        $client->request('DELETE', '/population/1');

        $this->assertEquals(302, $client->getResponse()->getStatusCode()); 
        $crawler = $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());  
    }


}