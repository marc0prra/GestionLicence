<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\InterventionType;

class InterventionTypeFixtures extends Fixture
{
    // On prend la référence des types d'intervention
    public const INTERVENTION_AUTONOMIE = 'user-autonomie';
    public const INTERVENTION_CONFERENCE = 'user-conference';
    public const INTERVENTION_COURS = 'user-cours';
    public const INTERVENTION_EVALUATION = 'user-evaluation';
    public const INTERVENTION_SOUTENANCE = 'user-soutenance';

    public static function data(): array
    {
        return [
            [
                'name' => 'Autonomie',
                'description' => 'Elèves en autonomie',
                'color' => '#6750A4',
                'reference' => self::INTERVENTION_AUTONOMIE,
            ],
            [
                'name' => 'Conférence',
                'description' => 'Conférence effectuée par un ou plusieurs intervenants',
                'color' => '#458525',
                'reference' => self::INTERVENTION_CONFERENCE,
            ],
            [
                'name' => 'Cours',
                'description' => 'Cours dispensé par un ou plusieurs intervenants',
                'color' => '#415263',
                'reference' => self::INTERVENTION_COURS,
            ],
            [
                'name' => 'Évaluation',
                'description' => 'Evaluation sous forme de POC ou d’écrit',
                'color' => '#120252',
                'reference' => self::INTERVENTION_EVALUATION,
            ],
            [
                'name' => 'Soutenance',
                'description' => 'Soutenance de fin de projet',
                'color' => '#412365',
                'reference' => self::INTERVENTION_SOUTENANCE,
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

            // Ajouter la référence pour que d'autres fixtures puissent y accéder
            $this->addReference(self::data()[$i]['reference'], $interventionType);
            $manager->persist($interventionType);
        }
        $manager->flush();
    }
}
