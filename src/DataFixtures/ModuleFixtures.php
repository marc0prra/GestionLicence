<?php

namespace App\DataFixtures;

use App\Entity\Module;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ModuleFixtures extends Fixture implements DependentFixtureInterface
{
    public const MODULE_RGP = 'module-rgpd';
    public const MODULE_IP = 'module-ip';
    public const MODULE_A11Y = 'module-accessibility';
    public const MODULE_DOCKER = 'module-docker';
    public const MODULE_GIT = 'module-git';
    public const MODULE_CICD = 'module-cicd';
    public const MODULE_MCD = 'module-mcd';
    public const MODULE_SQL = 'module-sql';
    public const MODULE_TAILWIND = 'module-tailwind';
    public const MODULE_REACT = 'module-react';
    public const MODULE_NEXT = 'module-next';

    public static function data(): array
    {
        return [
            [
                'code' => 'Tailwind_CSS',


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

            $module->setTeachingBlock($this->getReference(self::data()[$i]['teaching_block'], TeachingBlock::class));

            if (isset(self::data()[$i]['children'])) {
                for ($j = 0; $j < count(self::data()[$i]['children']); $j++) {
                    $subModule = new Module();
                    $subModule->setCode(self::data()[$i]['children'][$j]['code']);
                    $subModule->setName(self::data()[$i]['children'][$j]['name']);
                    $subModule->setDescription(self::data()[$i]['children'][$j]['description']);
                    $subModule->setHoursCount(self::data()[$i]['children'][$j]['hours_count']);
                    $subModule->setCapstoneProject(self::data()[$i]['children'][$j]['capstone_project']);
                    $subModule->setTeachingBlock($module->getTeachingBlock());
                    $subModule->setParent($module);

                    $this->addReference(self::data()[$i]['children'][$j]['reference_module'], $subModule);

                    $manager->persist($subModule);
                }
            }

            $manager->persist($module);
        }

        $manager->flush();
    }
}
