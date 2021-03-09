<?php

namespace App\Tests\CssSelector;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\HttpClient\HttpClient;
Use Symfony\Entity\User;

class LinkTest extends WebTestCase
{   
    public function testLinkHome() 
    {
        

        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $link = $crawler->selectLink('- Vaccination')->link();
        $crawler = $client->click($link);

        $info = $crawler->filter('h1')->text();
        $info = $string = trim(preg_replace('/\s\s+/', ' ', $info)); // On retire les retours à la ligne pour faciliter la vérification

        $this->assertSame("Patients", $info);
    }

    public function testLinkPopulationIndex() 
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/population/');

        $link = $crawler->selectLink('show')->link();
        $crawler = $client->click($link);

        $info = $crawler->filter('h1')->text();
        $info = $string = trim(preg_replace('/\s\s+/', ' ', $info)); // On retire les retours à la ligne pour faciliter la vérification

        $this->assertSame("Population", $info);
    }

    

}