<?php

namespace App\Tests\CssSelector;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeSelectorTest extends WebTestCase
{
    public function testHomeSelector()
    {
        $client = static::createClient();

        $crawler=$client->request('GET', '/');

        $this->assertGreaterThan(0, $crawler->filter('h1')->count());
    }
}