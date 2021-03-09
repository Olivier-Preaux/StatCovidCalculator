<?php

namespace App\Tests\CssSelector;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DepartmentSelectorTest extends WebTestCase
{
    // public function testDepartmentSelector()
    // {
    //     $client = static::createClient();

    //     $crawler=$client->request('GET', '/department');

    //     $this->assertGreaterThan(0, $crawler->filter('h1')->count());
    // }

    public function testDepartmentShowSelector()
    {
        $client = static::createClient();

        $crawler=$client->request('GET', '/department/Aube');

        $this->assertGreaterThan(0, $crawler->filter('h1')->count());
    }
}