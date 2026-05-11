<?php

namespace App\DataFixtures;

use App\Entity\TeachingBlock;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TeachingBlockFixtures extends Fixture
{
    // Constantes pour les blocs d'enseignement (utilisées comme références dans les fixtures)
    public const TEACHING_BLOCK_B1 = 'teaching-block-1';
    public const TEACHING_BLOCK_B2 = 'teaching-block-2';
    public const TEACHING_BLOCK_B3 = 'teaching-block-3';
    public const TEACHING_BLOCK_B4 = 'teaching-block-4';

    public static function data(): array
    {
        return [
            [
                'code' => 'B1',
                'name' => 'Piloter',
                'description' => 'Piloter un projet informatique',
                'hoursCount' => 86,
                'reference' => self::TEACHING_BLOCK_B1,
            ],
            [
                'code' => 'B2',
                'name' => 'Coordonner',
                'description' => 'Coordonner une equipe projet',
                'hoursCount' => 105,
                'reference' => self::TEACHING_BLOCK_B2,
            ],
            [
                'code' => 'B3',
                'name' => 'Superviser',
                'description' => 'Superviser la mise en oeuvre d\'un projet informatique',
                'hoursCount' => 14,
                'reference' => self::TEACHING_BLOCK_B3,
            ],
            [
                'code' => 'B4',
                'name' => 'Coordonner',
                'description' => 'Coordonner le cycle de vide des applications',
                'hoursCount' => 297.5,
                'reference' => self::TEACHING_BLOCK_B4,
            ],
        ];
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < count($this->data()); ++$i) {
            $teachingBlock = new TeachingBlock();
            $teachingBlock->setCode(self::data()[$i]['code']);
            $teachingBlock->setName(self::data()[$i]['name']);
            $teachingBlock->setDescription(self::data()[$i]['description']);
            $teachingBlock->setHoursCount(self::data()[$i]['hoursCount']);

            $this->addReference(self::data()[$i]['reference'], $teachingBlock);

            $manager->persist($teachingBlock);
        }

        $manager->flush();
    }
}
