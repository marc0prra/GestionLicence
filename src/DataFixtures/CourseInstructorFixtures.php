<?php

namespace App\DataFixtures;

use App\Entity\CourseInstructor;
use App\Entity\Instructor;
use App\Entity\Course;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CourseInstructorFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager): void
    {
        $instructor = $this->getReference(InstructorFixtures::INSTRUCTOR_REFERENCE, Instructor::class);

        $manager->persist($courseInstructor);
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            InstructorFixtures::class,
            CourseFixtures::class,
        ];
    }
}
