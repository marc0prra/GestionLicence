<?php

namespace App\DataFixtures;

use App\Entity\Semester;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SemesterFixtures extends Fixture
{
    // Constantes pour les semestres (utilisées comme références dans les fixtures)
    public const SEMESTER_1 = 'semester-1';
    public const SEMESTER_2 = 'semester-2';
    public const SEMESTER_3 = 'semester-3';

    public static function data(): array
    {
        return [
            [
                'label' => 'Semestre 1',
                'reference' => self::SEMESTER_1,
            ],
            [
                'label' => 'Semestre 2',
                'reference' => self::SEMESTER_2,
            ],
            [
                'label' => 'Semestre 3',
                'reference' => self::SEMESTER_3,
            ],
        ];
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < count(self::data()); ++$i) {
            $semester = new Semester();
            $semester->setLabel(self::data()[$i]['label']);

            $this->addReference(self::data()[$i]['reference'], $semester);

            $manager->persist($semester);
        }

        $manager->flush();
    }
}
