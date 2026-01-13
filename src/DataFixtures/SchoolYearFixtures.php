<?php

namespace App\DataFixtures;

use App\Entity\SchoolYear;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SchoolYearFixtures extends Fixture
{
    public static function data(): array
    {
        return [
            [
                'name' => '2024',
                'startDate' => '2024-09-01',
                'endDate' => '2025-07-07',
            ],
            [
                'name' => '2025',
                'startDate' => '2025-09-01',
                'endDate' => '2026-07-07',
            ],
            [
                'name' => '2026',
                'startDate' => '2026-09-01',
                'endDate' => '2027-07-07',
            ],
        ];
    }
    public function load(ObjectManager $manager): void
    {
        foreach (self::data() as $item) {
            $entity = new SchoolYear();
            $entity->setName($item['name']);
            $entity->setStartDate(new \DateTime($item['startDate']));
            $entity->setEndDate(new \DateTime($item['endDate']));
            $manager->persist($entity);
            $this->addReference('school_year_' . $item['name'], $entity);
        }
        $manager->flush();
    }
}