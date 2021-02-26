<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    const USERS = [
        'Admin' => [
            'firstName' =>  'Admin',
            'address'   =>  '5 rue de l\'allée',
            'city'      =>  'Troyes',
            'email'     =>  'admin@gmail.com',
            'role'      =>  'ROLE_ADMIN',
            'password'  =>  'adminpassword'
        ],
        'Dupont' => [
            'firstName' =>  'Bernard',
            'address'   =>  '1 rue du Grand Chemin',
            'city'      =>  'Reims',
            'email'     =>  'bernard@gmail.com',
            'role'      =>  'ROLE_USER',
            'password'  =>  'userpassword'
        ],
        'Martin' => [
            'firstName' =>  'Pierre',
            'address'   =>  '3 rue de la Tour',
            'city'      =>  'Paris',
            'email'     =>  'pierre@gmail.com',
            'role'      =>  'ROLE_USER',
            'password'  =>  'userpassword'
        ],
        'Legrand' => [
            'firstName' =>  'Louis',
            'address'   =>  '10 rue du Parc',
            'city'      =>  'Lyon',
            'email'     =>  'louis@gmail.com',
            'role'      =>  'ROLE_USER',
            'password'  =>  'userpassword'
        ],
        'Lepetit' => [
            'firstName' =>  'Jules',
            'address'   =>  '5 boulevard Danton',
            'city'      =>  'Lille',
            'email'     =>  'jules@gmail.com',
            'role'      =>  'ROLE_USER',
            'password'  =>  'userpassword'
        ],
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::USERS as $userLastName => [ 
                'firstName' => $userFirstName, 
                'address' => $userAdress , 
                'city' => $userCity ,
                'email' => $userEmail,
                'role' =>$userRole  ,
                'password' => $password 
                ])
        {

            $user= new User();
            $user->setEmail($userEmail);
            $user->setRoles([$userRole]);
            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                $password
            ));

            $manager->persist($user);


        // $product = new Product();
        // $manager->persist($product);
        }

        $manager->flush();
    }
}
