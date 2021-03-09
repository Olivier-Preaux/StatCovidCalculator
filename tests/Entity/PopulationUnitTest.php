<?php

namespace App\Tests\Entity;

use App\Entity\Population;
use Doctrine\Common\Cache\VoidCache;
use PHPUnit\Framework\TestCase;

class PopulationUnitTest extends TestCase
{   
    public function testIsTrue(): void
    {
        $population = new Population() ;

        $population   
                ->setFirstName('firstname')
                ->setLastName('lastname')
                ->setIsVaccinatedFirstDose('yes')
                ->setIsVaccinatedSecondDose('yes')
                ->setObservations('abcdef');
               
        $this->assertTrue($population->getFirstName()==='firstname');
        $this->assertTrue($population->getLastName()==='lastname');
        $this->assertTrue($population->getIsVaccinatedFirstDose()=== true ) ;
        $this->assertTrue($population->getIsVaccinatedSecondDose()=== true );
        
        $this->assertTrue($population ->getObservations()==='abcdef');
    }



    public function testIsFalse(): void
    {
        $population = new Population() ;

        $population ->setFirstName('true')
                    ->setLastName('true')
                    ->setIsVaccinatedFirstDose('yes')
                    ->setIsVaccinatedSecondDose('yes')
                    ->setObservations('abcdef');

                    $this->assertFalse($population->getFirstName()==='false');
                    $this->assertFalse($population->getLastName()==='false');
                    $this->assertFalse($population->getIsVaccinatedFirstDose()=== false ) ;
                    $this->assertFalse($population->getIsVaccinatedSecondDose()=== false );
                    $this->assertFalse($population ->getObservations()==='fedcba');
    }



    public function testIsEmpty() : Void
    {
        $population = new Population() ;

        $this->assertEmpty($population->getFirstName());
        $this->assertEmpty($population->getLastName());
        $this->assertEmpty($population->getIsVaccinatedFirstDose());
        $this->assertEmpty($population->getIsVaccinatedSecondDose());
        $this->assertEmpty($population->getObservations());
    }
 }