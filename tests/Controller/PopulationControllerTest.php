<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class PopulationControllerTest extends WebTestCase
{
    public function testIndexPopulation()
    {
        $client = static::createClient();

        $client->request('GET', '/population/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        
    }
}