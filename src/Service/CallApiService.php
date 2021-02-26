<?php

namespace App\Service ;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class CallApiService
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function getApi(string $var): array
    {
        $response = $this->client->request(
            'GET',
            'https://coronavirusapi-france.now.sh/'.$var
        );
       
        $content = $response->toArray();
        // $content = ['id' => 521583, 'name' => 'symfony-docs', ...]

        return $content;
    }

    public function getFranceData() : array
    {
        return $this->getApi('FranceLiveGlobalData');
    }

    public function getAllData() : array
    {
        return $this->getApi('AllLiveData');
    }

    public function getDepartmentData($department) : array
    {
        return $this->getApi('LiveDataByDepartement?Departement='.$department);
    }

    public function getAllDataByDate($date)
    {
        return $this->getApi('allDataByDate?date=' . $date );
    }
}