<?php

namespace App\DataFixtures;

use App\Entity\Instructor;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class InstructorFixtures extends Fixture implements DependentFixtureInterface
{
    public const INSTRUCTOR_REFERENCE = 'instructor_';

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 5; $i++) {
            $instructor = new Instructor();

            $userReference = $this->getReference(UserFixtures::USER_REFERENCE . $i, User::class);
            $instructor->setUser($userReference);

            $manager->persist($instructor);

            $this->addReference(self::INSTRUCTOR_REFERENCE . $i, $instructor);
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