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
                'name' => 'Semestre 1',
                'code' => 'S1',
                'start_date' => '2024-09-02',
                'end_date' => '2025-01-24',
                'school_year' => 'school_year_2024',
            ],
            [
                'name' => 'Semestre 2',
                'code' => 'S2',
                'start_date' => '2025-02-03',
                'end_date' => '2025-07-06',
                'school_year' => 'school_year_2024',
            ],
        ];
    }

    public function load(ObjectManager $manager): void
    {
        foreach (self::data() as $periodData) {
            $period = new CoursePeriod();
            $period->setName($periodData['name']);
            $period->setCode($periodData['code']);
            $period->setStartDate(new \DateTime($periodData['start_date']));
            $period->setEndDate(new \DateTime($periodData['end_date']));
            $schoolYear = $this->getReference($periodData['school_year']);
            $period->setSchoolYear($schoolYear);
            $manager->persist($period);
        }

        $manager->flush();
    }
}
