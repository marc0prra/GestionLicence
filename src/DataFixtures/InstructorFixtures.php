<?php

namespace App\DataFixtures;

use App\Entity\Instructor;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class InstructorFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i < count(UserFixtures::data()); $i++) {
            $instructor = new Instructor();

            // Lier l'enseignant à son utilisateur
            $user = $this->getReference('user-instructor-' . $i, User::class); 
            $instructor->setUser($user);

            $manager->persist($instructor);

            // Ajouter la référence pour que d'autres fixtures puissent y accéder
            $this->addReference('instructor-' . $i, $instructor);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}