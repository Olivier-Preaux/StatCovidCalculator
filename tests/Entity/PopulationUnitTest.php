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

}

//     public function testIsFalse(): void
//     {
//         $user = new Population() ;

//         $user   ->setEmail('true@test.com')
//                 ->setFirstName('firstname')
//                 ->setLastName('lastname')
//                 ->setAddress('address')
//                 ->setCity('city')
//                 ->setPassword('password')
//                 ->setRoles(['ROLE_USER']);

//         $this->assertFalse($user->getEmail()==='false@test.com');
//         $this->assertFalse($user->getFirstName()==='false');
//         $this->assertFalse($user->getLastName()==='false');
//         $this->assertFalse($user->getAddress()==='false');
//         $this->assertFalse($user->getCity()==='false');
//         $this->assertFalse($user->getPassword()==='false');
//         $this->assertFalse($user->getRoles()===['false']);
//     }

//     public function testIsEmpty() : Void
//     {
//         $user = new Population() ;

//         $this->assertEmpty($user->getEmail());
//         $this->assertEmpty($user->getFirstName());
//         $this->assertEmpty($user->getLastName());
//         $this->assertEmpty($user->getAddress());
//         $this->assertEmpty($user->getCity());
//         $this->assertEmpty($user->getPassword());
//     }
// }