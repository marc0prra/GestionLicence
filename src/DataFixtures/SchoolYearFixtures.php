<?php

namespace App\DataFixtures;

use App\Entity\SchoolYear;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SchoolYearFixtures extends Fixture
{
    // Constantes pour les années d'écoles (utilisées comme références dans les fixtures)
    public const SCHOOL_YEAR_2015 = 'school_year_2015';
    public const SCHOOL_YEAR_2016 = 'school_year_2016'; 
    public const SCHOOL_YEAR_2017 = 'school_year_2017';
    public const SCHOOL_YEAR_2018 = 'school_year_2018';
    public const SCHOOL_YEAR_2019 = 'school_year_2019';
    public const SCHOOL_YEAR_2020 = 'school_year_2020';
    public const SCHOOL_YEAR_2021 = 'school_year_2021';
    public const SCHOOL_YEAR_2022 = 'school_year_2022';
    public const SCHOOL_YEAR_2023 = 'school_year_2023';
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
            [
                'name' => '2025',
                'start_date' => '2025-09-01',
                'end_date' => '2026-07-07',
                'reference_school' => self::SCHOOL_YEAR_2025,
            ],
            [
                'name' => '2024',
                'start_date' => '2024-09-01',
                'end_date' => '2025-07-07',
                'reference_school' => self::SCHOOL_YEAR_2024,
            ],
            [
                'name' => '2023',
                'start_date' => '2023-09-01',
                'end_date' => '2024-07-07',
                'reference_school' => self::SCHOOL_YEAR_2023,
            ],
            [
                'name' => '2022',
                'start_date' => '2022-09-01',
                'end_date' => '2023-07-07',
                'reference_school' => self::SCHOOL_YEAR_2022,
            ],
            [
                'name' => '2021',
                'start_date' => '2021-09-01',
                'end_date' => '2022-07-07',
                'reference_school' => self::SCHOOL_YEAR_2021,
            ],
            [
                'name' => '2020',
                'start_date' => '2020-09-01',
                'end_date' => '2021-07-07',
                'reference_school' => self::SCHOOL_YEAR_2020,
            ],
            [
                'name' => '2019',
                'start_date' => '2019-09-01',
                'end_date' => '2020-07-07',
                'reference_school' => self::SCHOOL_YEAR_2019,
            ],
            [
                'name' => '2018',
                'start_date' => '2018-09-01',
                'end_date' => '2019-07-07',
                'reference_school' => self::SCHOOL_YEAR_2018,
            ],
            [
                'name' => '2017',
                'start_date' => '2017-09-01',
                'end_date' => '2018-07-07',
                'reference_school' => self::SCHOOL_YEAR_2017,
            ],
            [
                'name' => '2016',
                'start_date' => '2016-09-01',
                'end_date' => '2017-07-07',
                'reference_school' => self::SCHOOL_YEAR_2016,
            ],
            [
                'name' => '2015',
                'start_date' => '2015-09-01',
                'end_date' => '2016-07-07',
                'reference_school' => self::SCHOOL_YEAR_2015,
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