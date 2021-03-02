<?php

namespace App\Tests\Entity ;

use App\Entity\User;
use Doctrine\Common\Cache\VoidCache;
use PHPUnit\Framework\TestCase;

class UserUnitTest extends TestCase
{
    public function testIsTrue(): void
    {
        $user = new User() ;

        $user   ->setEmail('true@test.com') 
                ->setPassword('password')
                ->setRoles(['ROLE_USER']);

        $this->assertTrue($user->getEmail()==='true@test.com');
        $this->assertTrue($user->getPassword()==='password');
        $this->assertTrue($user->getRoles()===['ROLE_USER']);
    }

    public function testIsFalse(): void
    {
        $user = new User() ;

        $user   ->setEmail('true@test.com')
                ->setPassword('password')
                ->setRoles(['ROLE_USER']);

        $this->assertFalse($user->getEmail()==='false@test.com');
        $this->assertFalse($user->getPassword()==='false');
        $this->assertFalse($user->getRoles()===['false']);
    }

    public function testIsEmpty() : Void
    {
        $user = new User() ;

        $this->assertEmpty($user->getEmail());
        $this->assertEmpty($user->getPassword());
    }
}