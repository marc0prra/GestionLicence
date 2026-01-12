<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        
        $user->setEmail('j.martins@mentalworks.fr');

        $user->setRole('ROLE_USER'); 
        
        $user->setFirstName('J.');
        $user->setLastName('Martins');

        $password = $this->hasher->hashPassword($user, 'password123');
        $user->setPassword($password);

        $manager->persist($user);
        $manager->flush();
    }
}