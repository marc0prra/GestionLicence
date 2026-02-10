<?php

namespace App\DataFixtures;

use App\Entity\Course;
use App\Entity\CoursePeriod;
use App\Entity\InterventionType;
use App\Entity\Module;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CourseFixtures extends Fixture implements DependentFixtureInterface
{
    // On prend la référence des cours
    public const COURSE_1 = 'course-1';
    public const COURSE_2 = 'course-2';
    public const COURSE_3 = 'course-3';
    public const COURSE_4 = 'course-4';
    public const COURSE_5 = 'course-5';
    public const COURSE_6 = 'course-6';
    public const COURSE_7 = 'course-7';
    public const COURSE_8 = 'course-8';
    public const COURSE_9 = 'course-9';
    public const COURSE_10 = 'course-10';

    public static function data(): array
    {
        return [
            // Lundi 24 Novembre
            [
                'date_début' => '2025-11-24 08:30:00',
                'date_fin' => '2025-11-24 12:00:00',
                'remotely' => true, // Icône caméra présente
                'title' => '',
                'interventionType' => InterventionTypeFixtures::INTERVENTION_COURS,
                'module' => ModuleFixtures::MODULE_JAVASCRIPT,
                'course' => self::COURSE_1,
            ],
            [
                'date_début' => '2025-11-24 13:30:00',
                'date_fin' => '2025-11-24 17:00:00',
                'remotely' => false,
                'title' => '',
                'interventionType' => InterventionTypeFixtures::INTERVENTION_COURS,
                'module' => ModuleFixtures::MODULE_REACT,
                'course' => self::COURSE_2,
            ],

            // Mardi 25 Novembre
            [
                'date_début' => '2025-11-25 08:30:00',
                'date_fin' => '2025-11-25 12:00:00',
                'remotely' => false,
                'title' => '',
                'interventionType' => InterventionTypeFixtures::INTERVENTION_AUTONOMIE,
                'module' => ModuleFixtures::MODULE_REACT,
                'course' => self::COURSE_3,
            ],
            [
                'date_début' => '2025-11-25 13:30:00',
                'date_fin' => '2025-11-25 17:00:00',
                'remotely' => false,
                'title' => '',
                'interventionType' => InterventionTypeFixtures::INTERVENTION_SOUTENANCE,
                'module' => ModuleFixtures::MODULE_DEVOPS,
                'course' => self::COURSE_4,
            ],

            // Mercredi 26 Novembre
            [
                'date_début' => '2025-11-26 08:30:00',
                'date_fin' => '2025-11-26 12:00:00',
                'remotely' => true, // Icône caméra présente
                'title' => '',
                'interventionType' => InterventionTypeFixtures::INTERVENTION_COURS,
                'module' => ModuleFixtures::MODULE_JAVASCRIPT,
                'course' => self::COURSE_5,
            ],
            [
                'date_début' => '2025-11-26 13:30:00',
                'date_fin' => '2025-11-26 17:00:00',
                'remotely' => false,
                'title' => '',
                'interventionType' => InterventionTypeFixtures::INTERVENTION_AUTONOMIE,
                'module' => ModuleFixtures::MODULE_JAVASCRIPT,
                'course' => self::COURSE_6,
            ],

            // Jeudi 27 Novembre
            [
                'date_début' => '2025-11-27 08:30:00',
                'date_fin' => '2025-11-27 12:00:00',
                'remotely' => false,
                'title' => '',
                'interventionType' => InterventionTypeFixtures::INTERVENTION_COURS,
                'module' => ModuleFixtures::MODULE_DOCKER,
                'course' => self::COURSE_7,
            ],
            [
                'date_début' => '2025-11-27 13:30:00',
                'date_fin' => '2025-11-27 17:00:00',
                'remotely' => false,
                'title' => '',
                'interventionType' => InterventionTypeFixtures::INTERVENTION_EVALUATION,
                'module' => ModuleFixtures::MODULE_ANGLAIS,
                'course' => self::COURSE_8,
            ],

            // Vendredi 28 Novembre
            [
                'date_début' => '2025-11-28 08:30:00',
                'date_fin' => '2025-11-28 12:00:00',
                'remotely' => false,
                'title' => '',
                'interventionType' => InterventionTypeFixtures::INTERVENTION_CONFERENCE,
                'module' => ModuleFixtures::MODULE_REX,
                'course' => self::COURSE_9,
            ],
            [
                'date_début' => '2025-11-28 13:30:00',
                'date_fin' => '2025-11-28 17:00:00',
                'remotely' => false,
                'title' => '',
                'interventionType' => InterventionTypeFixtures::INTERVENTION_COURS,
                'module' => ModuleFixtures::MODULE_COMMUNICATION,
                'course' => self::COURSE_10,
            ],
        ];
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < count(self::data()); ++$i) {
            $course = new Course();
            $course->setStartDate(new \DateTime(self::data()[$i]['date_début']));
            $course->setEndDate(new \DateTime(self::data()[$i]['date_fin']));
            $course->setRemotely(self::data()[$i]['remotely']);
            $course->setTitle(self::data()[$i]['title']);

            $course->setInterventionTypeId($this->getReference(self::data()[$i]['interventionType'], InterventionType::class));
            $course->setModuleId($this->getReference(self::data()[$i]['module'], Module::class));
            $course->setCoursePeriodId($this->getReference('coursePeriod-'.rand(1, 3), CoursePeriod::class));

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
