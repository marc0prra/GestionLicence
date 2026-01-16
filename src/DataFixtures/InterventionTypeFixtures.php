<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\InterventionType;

class InterventionTypeFixtures extends Fixture
{
    public static function data(): array
    {
        return [
            [
                'name' => 'Intervention',
                'description' => 'Intervention',
                'color' => 'Intervention'
            ],
            [
                'name' => 'Intervention',
                'description' => 'Intervention',
                'color' => 'Intervention'
            ],
            [
                'name' => 'Intervention',
                'description' => 'Intervention',
                'color' => 'Intervention'
            ],
            [
                'name' => 'Intervention',
                'description' => 'Intervention',
                'color' => 'Intervention'
            ],
            [
                'name' => 'Intervention',
                'description' => 'Intervention',
                'color' => 'Intervention'
            ],
        ];
    }

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        for ($i = 0; $i < count(self::data()); $i++) {
            $interventionType = new InterventionType();
            $interventionType->setName(self::data()[$i]['name']);
            $interventionType->setDescription(self::data()[$i]['description']);
            $interventionType->setColor(self::data()[$i]['color']);

            $this->addReference('interventionType' . $i, $interventionType);
            $manager->persist($interventionType);
        }
        $manager->flush();
    }
}
