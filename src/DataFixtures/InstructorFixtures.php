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
        for ($i = 0; $i < 5; $i++) {
            $instructor = new Instructor();

            $user = $this->getReference('user-' . ($i+1), User::class); 
            $instructor->setUser($user);

            $manager->persist($instructor);

            $this->addReference('instructor-' . ($i+1), $instructor);
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