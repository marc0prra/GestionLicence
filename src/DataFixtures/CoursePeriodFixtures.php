<?php

namespace App\DataFixtures;

use App\Entity\CoursePeriod;
use App\Entity\SchoolYear;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CoursePeriodFixtures extends Fixture implements DependentFixtureInterface
{
    public static function data(): array
    {
        return [
            [
                'startDate' => '2024-09-02',
                'endDate' => '2025-01-24',
                'schoolYear' => SchoolYearFixtures::SCHOOL_YEAR_2024,
            ],
            [
                'startDate' => '2025-02-03',
                'endDate' => '2025-07-06',
                'schoolYear' => SchoolYearFixtures::SCHOOL_YEAR_2025,
            ],
            [
                'startDate' => '2026-02-02',
                'endDate' => '2026-07-05',
                'schoolYear' => SchoolYearFixtures::SCHOOL_YEAR_2026,
            ],
        ];
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < count(self::data()); ++$i) {
            $period = new CoursePeriod();
            $period->setStartDate(new \DateTime(self::data()[$i]['startDate']));
            $period->setEndDate(new \DateTime(self::data()[$i]['endDate']));

            $period->setSchoolYear($this->getReference(self::data()[$i]['schoolYear'], SchoolYear::class));

            $this->addReference('coursePeriod-'.($i + 1), $period);

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
