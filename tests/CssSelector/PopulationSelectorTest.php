<?php

namespace App\Tests\CssSelector;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PopulationSelectorTest extends WebTestCase
{
    public function testPopulationSelector()
    {
        $client = static::createClient();

        $crawler=$client->request('GET', '/population/');

        $this->assertGreaterThan(0, $crawler->filter('h1')->count());
    }

    public function testPopulationShowSelector()
    {
        $client = static::createClient();

        $crawler=$client->request('GET', '/population/1');

        $this->assertGreaterThan(0, $crawler->filter('h1')->count());
    }
}