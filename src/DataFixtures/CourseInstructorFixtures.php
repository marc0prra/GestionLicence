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
        $assignments = [
            'course-1' => 'instructor-1',
            'course-2' => 'instructor-2',
            'course-3' => 'instructor-3',
            'course-4' => 'instructor-4',
        ];

        foreach ($assignments as $courseRef => $instructorRef) {
            $course = $this->getReference($courseRef, Course::class);
            $instructor = $this->getReference($instructorRef, Instructor::class);

            $courseInstructor = new CourseInstructor();
            $courseInstructor->setCourse($course);
            $courseInstructor->setInstructor($instructor);

            $manager->persist($courseInstructor);
        }

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
