<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class DepartmentControllerTest extends WebTestCase
{
    public function testIndexDepartment()
    {
        $client = static::createClient();

        $client->request('GET', '/department');

        $this->assertEquals(301, $client->getResponse()->getStatusCode());
        $crawler = $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        
    }

    public function testShowDepartment()
    {
        $client = static::createClient();

        $client->request('GET', '/department/Aube');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());        
    }
}