<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Course;
use App\Entity\Module;
use App\Entity\InterventionType;
use App\Entity\CoursePeriod;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CourseFixtures extends Fixture implements DependentFixtureInterface
{
    // On prend la référence des cours
    public const COURSE_1 = 'course-1';
    public const COURSE_2 = 'course-2';
    public const COURSE_3 = 'course-3';
    public const COURSE_4 = 'course-4';
    public const COURSE_5 = 'course-5';

    public static function data(): array
    {
        return [
            [
                'date_début' => '2026-01-01 08:40:00',
                'date_fin' => '2026-01-01 17:25:00',
                'remotely' => true,
                'title' => 'php objet',
                'interventionType' => InterventionTypeFixtures::INTERVENTION_COURS,
                'module' => ModuleFixtures::MODULE_REACT, 
                'course' => self::COURSE_1
            ],
            [
                'date_début' => '2026-01-02 08:40:00',
                'date_fin' => '2026-01-02 17:25:00',
                'remotely' => false,
                'title' => 'autonomie',
                'interventionType' => InterventionTypeFixtures::INTERVENTION_AUTONOMIE,
                'module' => ModuleFixtures::MODULE_GIT, 
                'course' => self::COURSE_2
            ],
            [
                'date_début' => '2026-01-03 08:40:00',
                'date_fin' => '2026-01-03 17:25:00',
                'remotely' => true,
                'title' => 'conference',
                'interventionType' => InterventionTypeFixtures::INTERVENTION_CONFERENCE,
                'module' => ModuleFixtures::MODULE_DOCKER, 
                'course' => self::COURSE_3
            ],
            [
                'date_début' => '2026-01-04 08:40:00',
                'date_fin' => '2026-01-04 17:25:00',
                'remotely' => false,
                'title' => 'evaluation',
                'interventionType' => InterventionTypeFixtures::INTERVENTION_EVALUATION,
                'module' => ModuleFixtures::MODULE_ARCHI_BDD, 
                'course' => self::COURSE_4
            ],
            [
                'date_début' => '2026-01-05 08:40:00',
                'date_fin' => '2026-01-05 17:25:00',
                'remotely' => true,
                'title' => 'soutenance',
                'interventionType' => InterventionTypeFixtures::INTERVENTION_SOUTENANCE,
                'module' => ModuleFixtures::MODULE_NEXT, 
                'course' => self::COURSE_5
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

            $course->setInterventionTypeId($this->getReference(self::data()[$i]['interventionType'], InterventionType::class));
            $course->setModuleId($this->getReference(self::data()[$i]['module'], Module::class));
            $course->setCoursePeriodId($this->getReference('coursePeriod-' . rand(1, 3), CoursePeriod::class));

            $this->addReference(self::data()[$i]['course'], $course);

            $manager->persist($course);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            InterventionTypeFixtures::class,
            ModuleFixtures::class,
            CoursePeriodFixtures::class,
        ];
    }
}
