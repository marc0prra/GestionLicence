<?php

namespace App\DataFixtures;

use App\Entity\SchoolYear;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SchoolYearFixtures extends Fixture
{
    public const SCHOOL_YEAR_2024 = 'school_year_2024';
    public const SCHOOL_YEAR_2025 = 'school_year_2025';
    public const SCHOOL_YEAR_2026 = 'school_year_2026';

    public static function data(): array
    {
        return [
            [
                'name' => '2024',
                'start_date' => '2024-09-01',
                'end_date' => '2025-07-07',
                'reference_school' => self::SCHOOL_YEAR_2024,
            ],
            [
                'name' => '2025',
                'start_date' => '2025-09-01',
                'end_date' => '2026-07-07',
                'reference_school' => self::SCHOOL_YEAR_2025,
            ],
            [
                'name' => '2026',
                'start_date' => '2026-09-01',
                'end_date' => '2027-07-07',
                'reference_school' => self::SCHOOL_YEAR_2026,
            ],
        ];
    }
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < count(self::data()); $i++) {
            $entity = new SchoolYear();
            $entity->setName(self::data()[$i]['name']);
            $entity->setStartDate(new \DateTime(self::data()[$i]['start_date']));
            $entity->setEndDate(new \DateTime(self::data()[$i]['end_date']));

            $manager->persist($entity);

            $this->addReference(self::data()[$i]['reference_school'], $entity);
        }
        $manager->flush();
    }
}