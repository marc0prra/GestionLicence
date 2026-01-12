<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Course;
use App\Entity\Module;
use App\Entity\InterventionType;
use App\Entity\CoursePeriod;

class CourseFixtures extends Fixture
{
    public static function data(): array
    {
        return [
            [
                'date_début' => '2026-01-01 08:40:00',
                'date_fin' => '2026-01-01 17:25:00',
                'remotely' => true,
                'title' => 'php objet'
            ],
            [
                'date_début' => '2026-01-02 08:40:00',
                'date_fin' => '2026-01-02 17:25:00',
                'remotely' => false,
                'title' => ''
            ],
            [
                'date_début' => '2026-01-03 08:40:00',
                'date_fin' => '2026-01-03 17:25:00',
                'remotely' => true,
                'title' => 'intervention'
            ],
            [
                'date_début' => '2026-01-04 08:40:00',
                'date_fin' => '2026-01-04 17:25:00',
                'remotely' => false,
                'title' => 'Course 5'
            ],
            [
                'date_début' => '2026-01-05 08:40:00',
                'date_fin' => '2026-01-05 17:25:00',
                'remotely' => true,
                'title' => 'Course 6'
            ]
        ];
    }


    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < count(self::data()); $i++) {
            $course = new Course();
            $course->setStartDate(new \DateTime(self::data()[$i]['date_début']));
            $course->setEndDate(new \DateTime(self::data()[$i]['date_fin']));
            $course->setRemotely(self::data()[$i]['remotely']);
            $course->setTitle(self::data()[$i]['title']);

            $course->setInterventionTypeId($this->getReference('interventionType-' . rand(1, 5), InterventionType::class));
            $course->setModuleId($this->getReference('module-' . rand(1, 5), Module::class));
            $course->setCoursePeriodId($this->getReference('coursePeriod-' . rand(1, 5), CoursePeriod::class));


            $manager->persist($course);
        }
        $manager->flush();
    }
}
