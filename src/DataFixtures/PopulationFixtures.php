<?php

namespace App\DataFixtures;

use App\Entity\Population;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\DataFixtures\UserFixtures;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;


class PopulationFixtures extends Fixture implements DependentFixtureInterface
{
    

    public function getDependencies()  
    {
        return [UserFixtures::class];  
    }

    const POPULATIONS = [
        '01' => [
            'firstName'                 => 'Jean',
            'lastName'                  => 'Martin',
            'isVaccinatedFirstDose'     => '0',
            'isVaccinatedSecondDose'    => '1', 
            'doctor'                    => '2'
        ],
        '02' => [
            'firstName'                 => 'Pierre',
            'lastName'                  => 'Dupont',
            'isVaccinatedFirstDose'     => '0',
            'isVaccinatedSecondDose'    => '0', 
            'doctor'                    => '2'
        ],
        '03' => [
            'firstName'                 => 'Jacques',
            'lastName'                  => 'Dubois',
            'isVaccinatedFirstDose'     => '1',
            'isVaccinatedSecondDose'    => '1',   
            'doctor'                    => '2'
        ],
        '04' => [
            'firstName'                 => 'Paul',
            'lastName'                  => 'Simon',
            'isVaccinatedFirstDose'     => '0',
            'isVaccinatedSecondDose'    => '1',   
            'doctor'                    => '2'
        ],
        '05' => [
            'firstName'                 => 'Mathieu',
            'lastName'                  => 'Delor',
            'isVaccinatedFirstDose'     => '1',
            'isVaccinatedSecondDose'    => '1',  
            'doctor'                    => '2'
        ],
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::POPULATIONS as $number => [ 
            'firstName' => $firstName, 
            'lastName' => $lastName , 
            'isVaccinatedFirstDose' => $firstDose ,
            'isVaccinatedSecondDose' => $secondDose,
            'doctor' => $doctor
            ])
    {

        $population= new Population();
        $population->setFirstName($firstName);
        $population->setLastName($lastName);
        $population->setIsVaccinatedFirstDose($firstDose);
        $population->setIsVaccinatedSecondDose($secondDose);
        $population->setDoctor($this->getReference(UserFixtures::USER_REFERENCE));

        $manager->persist($population);

        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
        
    }
    }
}
