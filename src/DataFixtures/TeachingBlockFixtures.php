<?php

namespace App\DataFixtures;

use App\Entity\TeachingBlock;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TeachingBlockFixtures extends Fixture
{
    // On prend la référence des blocs d'enseignement 
    public const TEACHING_BLOCK_B1 = 'teaching-block-1';
    public const TEACHING_BLOCK_B2 = 'teaching-block-2';
    public const TEACHING_BLOCK_B3 = 'teaching-block-3';
    public const TEACHING_BLOCK_B4 = 'teaching-block-4';
    
    public static function data() :array 
    {
        return [
            [
                'code' => 'B1',
                'reference' => self::TEACHING_BLOCK_B1,
                'name' => 'Piloter',
                'description' => 'Piloter un projet informatique',
                'hours_count' => 87.5
            ],
            [
                'code' => 'B2',
                'reference' => self::TEACHING_BLOCK_B2,
                'name' => 'Coordonner',
                'description' => 'Coordonner une equipe projet',
                'hours_count' => 105

            ],
            [
                'code' => 'B3',
                'reference' => self::TEACHING_BLOCK_B3,
                'name' => 'Superviser',
                'description' => 'Superviser la mise en oeuvre d\'un projet informatique',
                'hours_count' => 14
            ],
            [
                'code' => 'B4',
                'reference' => self::TEACHING_BLOCK_B4,
                'name' => 'Coordonner',
                'description' => 'Coordonner le cycle de vide des applications',
                'hours_count' => 297.5
            ],
        ];
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < count(self::data()); $i++) {
            $teachingBlock = new TeachingBlock();
            $teachingBlock->setCode(self::data()[$i]['code']);
            $teachingBlock->setName(self::data()[$i]['name']);
            $teachingBlock->setDescription(self::data()[$i]['description']);
            $teachingBlock->setHoursCount(self::data()[$i]['hours_count']);

            // Ajouter la référence pour que d'autres fixtures puissent y accéder
            $this->addReference(self::data()[$i]['reference'], $teachingBlock);

            $manager->persist($teachingBlock);
        }

        $manager->flush();
    }
}    


