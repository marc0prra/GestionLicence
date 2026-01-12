<?php

namespace App\DataFixtures;

use App\Entity\CourseInstructor;
use App\Entity\Instructor;
use App\Entity\Course;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CourseInstructorFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $instructor = $this->getReference('instructor-' . $i+1, Instructor::class);
        $course = $this->getReference('course-' . $i+1, Course::class);

        $courseInstructor = new CourseInstructor();
        $courseInstructor->setInstructor($instructor);
        $courseInstructor->setCourse($course);

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
