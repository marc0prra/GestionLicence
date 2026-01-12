<?php

namespace App\DataFixtures;

use App\Entity\CourseInstructor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CourseInstructorFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        $courseInstructor = new CourseInstructor();
        $courseInstructor->$this->getReference(CourseFixtures);

        $manager->flush();
    }
}
