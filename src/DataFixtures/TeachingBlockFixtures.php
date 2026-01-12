<?php

namespace App\DataFixtures;

use App\Entity\TeachingBlock;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TeachingBlockFixtures extends Fixture
{
    public function data() {
        return [
            [
                'code' => 'B1',
                'name' => 'Piloter',
                'description' => 'Piloter un projet informatique',
                'hours_count' => 87.5
            ],
            [
                'code' => 'B2',
                'name' => 'Coordonner',
                'description' => 'Coordonner une equipe projet',
                'hours_count' => 105

            ],
            [
                'code' => 'B3',
                'name' => 'Superviser',
                'description' => 'Superviser la mise en oeuvre d\'un projet informatique',
                'hours_count' => 14
            ],
            [
                'code' => 'B4',
                'name' => 'Coordonner',
                'description' => 'Coordonner le cycle de vide des applications',
                'hours_count' => 297.5
            ],
        ];
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < count($this->data()); $i++) {
            $teachingBlock = new TeachingBlock();
            $teachingBlock->setCode($this->data()[$i]['code']);
            $teachingBlock->setName($this->data()[$i]['name']);
            $teachingBlock->setDescription($this->data()[$i]['description']);
            $teachingBlock->setHoursCount($this->data()[$i]['hours_count']);
            $manager->persist($teachingBlock);
        }

        $manager->flush();
    }
}    


