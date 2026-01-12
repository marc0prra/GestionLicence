<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public const USER_JMARTINS = 'user-jmartins';

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
        $user->setPassword($this->hasher->hashPassword($user, 'password123'));
        
        $manager->persist($user);
        $this->addReference(self::USER_JMARTINS, $user);

        for ($i = 1; $i <= 5; $i++) {
            $instructor = new User();
            $instructor->setEmail("professeur$i@ecole.fr");
            $instructor->setRole('ROLE_INSTRUCTOR'); 
            $instructor->setFirstName('Professeur');
            $instructor->setLastName('Numéro ' . $i);
            $instructor->setPassword($this->hasher->hashPassword($instructor, 'password123'));

            $manager->persist($instructor);
            $this->addReference('user-' . $i, $instructor);
        }

        $manager->flush();
    }
}