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
                'name' => 'Autonomie',
                'description' => 'Elèves en autonomie',
                'color' => '#6750A4'
            ],
            [
                'name' => 'Conférence',
                'description' => 'Conférence effectuée par un ou plusieurs intervenants',
                'color' => '#458525'
            ],
            [
                'name' => 'Cours',
                'description' => 'Cours dispensé par un ou plusieurs intervenants',
                'color' => '#415263'
            ],
            [
                'name' => 'Évaluation',
                'description' => 'Evaluation sous forme de POC ou d’écrit',
                'color' => '#120252'
            ],
            [
                'name' => 'Soutenance',
                'description' => 'Soutenance de fin de projet',
                'color' => '#412365'
            ],
        ];
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < count(self::data()); $i++) {
            $interventionType = new InterventionType();
            $interventionType->setName(self::data()[$i]['name']);
            $interventionType->setDescription(self::data()[$i]['description']);
            $interventionType->setColor(self::data()[$i]['color']);

            $this->addReference('interventionType-' . $i + 1, $interventionType);
            $manager->persist($interventionType);
        }
        $manager->flush();
    }
}
