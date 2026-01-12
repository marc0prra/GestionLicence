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
        // On parcourt tous les cours créés dans CourseFixtures
        for ($i = 0; $i < count(CourseFixtures::data()); $i++) {
            $course = $this->getReference('course-' . ($i + 1), Course::class);
            
            // On récupère un instructeur au hasard (il y en a 5 dans InstructorFixtures)
            $instructor = $this->getReference('instructor-' . rand(1, 5), Instructor::class);

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
