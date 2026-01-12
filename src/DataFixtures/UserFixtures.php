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
        // Création de l'utilisateur de la maquette
        $user = new User();
        $user->setEmail('j.martins@mentalworks.fr');
        $user->setRoles(['ROLE_USER']);
        
        // Le mot de passe est haché
        $password = $this->hasher->hashPassword($user, 'password123');
        $user->setPassword($password);

        $manager->persist($user);
        $manager->flush();
    }
}