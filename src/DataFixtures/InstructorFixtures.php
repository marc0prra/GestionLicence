<?php

namespace App\DataFixtures;

use App\Entity\Instructor;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class InstructorFixtures extends Fixture implements DependentFixtureInterface
{
    public const INSTRUCTOR_1 = 'instructor-1';
    public const INSTRUCTOR_2 = 'instructor-2';

    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 16; ++$i) {
            $instructor = new Instructor();

            $user = $this->getReference('user-instructor-' . $i, User::class);
            $instructor->setUser($user);

            $manager->persist($instructor);

            $referenceName = 'instructor-' . $i;
            $this->addReference($referenceName, $instructor);
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