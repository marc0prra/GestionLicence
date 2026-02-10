<?php

namespace App\DataFixtures;

use App\Entity\Instructor;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class InstructorFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // On parcourt les utilisateurs pour récupérer les enseignants
        for ($i = 1; $i <= 16; ++$i) {
            $instructor = new Instructor();

            $user = $this->getReference('user-instructor-'.$i, User::class);
            $instructor->setUser($user);

            $manager->persist($instructor);

            $this->addReference('instructor-'.$i, $instructor);
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
