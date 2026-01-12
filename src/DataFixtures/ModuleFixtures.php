<?php

namespace App\DataFixtures;

use App\Entity\Module;
use App\Entity\TeachingBlock;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ModuleFixtures extends Fixture implements DependentFixtureInterface
{
    public static function data() : array
    {
        return [
            [
                'code' => 'Developpment_front',
                'name' => 'Developpment front',
                'description' => null,
                'hours_count' => 126,
                'capstone_project' => false,
            ],
            [
                'code' => 'Tailwind_CSS',
                'name' => 'Tailwind CSS',
                'description' => 'Piloter un projet informatique',
                'hours_count' => 14,
                'capstone_project' => true,
            ]
        ];
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < count(self::data()); $i++) {
            $module = new Module();
            $module->setCode(self::data()[$i]['code']);
            $module->setName(self::data()[$i]['name']);
            $module->setDescription(self::data()[$i]['description']);
            $module->setHoursCount(self::data()[$i]['hours_count']);
            $module->setCapstoneProject(self::data()[$i]['capstone_project']);

            $module->setTeachingBlock($this->getReference('teaching_block-' . rand(1, 4), TeachingBlock::class));
            
            $this->addReference('module-'. ($i+1), $module);            
            
            $manager->persist($module);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            TeachingBlockFixtures::class,
        ];
    }
}

