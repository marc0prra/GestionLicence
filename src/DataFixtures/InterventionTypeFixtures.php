<?php

namespace App\DataFixtures;

use App\Entity\InterventionType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class InterventionTypeFixtures extends Fixture
{
    // Constantes pour les types d'interventions (utilisées comme références dans les fixtures)
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
                'description' => 'Travail en autonomie',
                'color' => '#10b981',
                'reference' => self::INTERVENTION_AUTONOMIE,
            ],
            [
                'name' => 'Conférence',
                'description' => 'Conférence magistrale',
                'color' => '#3b82f6',
                'reference' => self::INTERVENTION_CONFERENCE,
            ],
            [
                'name' => 'Cours',
                'description' => 'Cours théorique',
                'color' => '#f59e0b',
                'reference' => self::INTERVENTION_COURS,
            ],
            [
                'name' => 'Évaluation',
                'description' => 'Contrôle des connaissances',
                'color' => '#ef4444',
                'reference' => self::INTERVENTION_EVALUATION,
            ],
            [
                'name' => 'Soutenance',
                'description' => 'Présentation de projet',
                'color' => '#8b5cf6',
                'reference' => self::INTERVENTION_SOUTENANCE,
            ],
        ];
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < count(self::data()); ++$i) {
            $interventionType = new InterventionType();
            $interventionType->setName(self::data()[$i]['name']);
            $interventionType->setDescription(self::data()[$i]['description']);
            $interventionType->setColor(self::data()[$i]['color']);

            $this->addReference(self::data()[$i]['reference'], $interventionType);
            $manager->persist($interventionType);
        }
        $manager->flush();
    }
}
