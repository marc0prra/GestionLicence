<?php

namespace App\DataFixtures;

use App\Entity\Semester;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SemesterFixtures extends Fixture
{
    // Constantes pour les années d'écoles (utilisées comme références dans les fixtures)
    public const SEMESTER_1 = 'semester_1';

    public const SEMESTER_2 = 'semester_2';

    public const SEMESTER_3 = 'semester_3';

    public static function data(): array
    {
        return [
            [
                'libelle' => 'Semestre 1',
                'reference_semester' => self::SEMESTER_1,
            ],
            [
                'libelle' => 'Semestre 2',
                'reference_semester' => self::SEMESTER_2,
            ],
            [
                'libelle' => 'Semestre 3',
                'reference_semester' => self::SEMESTER_3,
            ],
        ];
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < count(self::data()); ++$i) {
            $entity = new Semester();
            $entity->setLibelle(self::data()[$i]['libelle']);

            $manager->persist($entity);

            $this->addReference(self::data()[$i]['reference_semester'], $entity);
        }
        $manager->flush();
    }
}
