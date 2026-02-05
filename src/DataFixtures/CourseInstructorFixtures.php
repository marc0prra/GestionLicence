<?php

namespace App\DataFixtures;

use App\Entity\CourseInstructor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\Course;
use App\Entity\Instructor;

class CourseInstructorFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager): void
    {
        // Tableau qui assigne un enseignant à un cours
        $assignments = [
            'course-1' => 'instructor-1',
            'course-2' => 'instructor-2',
            'course-3' => 'instructor-3',
            'course-4' => 'instructor-4',
            'course-5' => 'instructor-5',
            'course-6' => 'instructor-6',
            'course-7' => 'instructor-7',
            'course-8' => 'instructor-8',
            'course-9' => 'instructor-9',
            'course-10' => 'instructor-10',
        ];

        // On parcourt les assignements pour récupérer les cours et les enseignants
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
            CourseFixtures::class,
            InstructorFixtures::class,
        ];
    }
}
