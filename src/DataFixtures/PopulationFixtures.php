<?php

namespace App\DataFixtures;

use App\Entity\Population;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PopulationFixtures extends Fixture
{
    const POPULATIONS = [
        '01' => [
            'firstName'                 => 'Jean',
            'lastName'                  => 'Martin',
            'isVaccinatedFirstDose'     => '0',
            'isVaccinatedSecondDose'    => '1',   
        ],
        '02' => [
            'firstName'                 => 'Pierre',
            'lastName'                  => 'Dupont',
            'isVaccinatedFirstDose'     => '0',
            'isVaccinatedSecondDose'    => '0',   
        ],
        '03' => [
            'firstName'                 => 'Jacques',
            'lastName'                  => 'Dubois',
            'isVaccinatedFirstDose'     => '1',
            'isVaccinatedSecondDose'    => '1',   
        ],
        '04' => [
            'firstName'                 => 'Paul',
            'lastName'                  => 'Simon',
            'isVaccinatedFirstDose'     => '0',
            'isVaccinatedSecondDose'    => '1',   
        ],
        '05' => [
            'firstName'                 => 'Mathieu',
            'lastName'                  => 'Delor',
            'isVaccinatedFirstDose'     => '1',
            'isVaccinatedSecondDose'    => '1',   
        ],
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::POPULATIONS as $number => [ 
            'firstName' => $firstName, 
            'lastName' => $lastName , 
            'isVaccinatedFirstDose' => $firstDose ,
            'isVaccinatedSecondDose' => $secondDose,
            ])
    {

        $population= new Population();
        $population->setFirstName($firstName);
        $population->setLastName($lastName);
        $population->setIsVaccinatedFirstDose($firstDose);
        $population->setIsVaccinatedSecondDose($secondDose);

        $manager->persist($population);

        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
    }
}
