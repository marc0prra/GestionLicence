<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\CoursePeriod;
use App\Entity\SchoolYear;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;


class CoursePeriodFixtures extends Fixture implements DependentFixtureInterface
{
    public static function data(): array
    {
        return [
            [
                'start_date' => '2024-09-02',
                'end_date' => '2025-01-24',
                'school_year' => SchoolYearFixtures::SCHOOL_YEAR_2024,
            ],
            [
                'start_date' => '2025-02-03',
                'end_date' => '2025-07-06',
                'school_year' => SchoolYearFixtures::SCHOOL_YEAR_2025,
            ],
            [
                'start_date' => '2026-02-02',
                'end_date' => '2026-07-05',
                'school_year' => SchoolYearFixtures::SCHOOL_YEAR_2026,
            ],
        ];
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < count(self::data()); $i++) {
            $period = new CoursePeriod();
            $period->setStartDate(new \DateTime(self::data()[$i]['start_date']));
            $period->setEndDate(new \DateTime(self::data()[$i]['end_date']));

            $period->setSchoolYearId($this->getReference(self::data()[$i]['school_year'], SchoolYear::class));

            $this->addReference('coursePeriod-' . ($i + 1), $period);

            $manager->persist($period);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            SchoolYearFixtures::class,
        ];
    }
}


