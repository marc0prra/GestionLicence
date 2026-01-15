<?php

namespace App\DataFixtures;

use App\Entity\Module;
use App\Entity\TeachingBlock;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

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
                'name' => 'Cadre légal - Droit numérique',
                'code' => 'LEGAL',
                'description' => null,
                'hours_count' => 21,
                'capstone_project' => false,
                'teaching_block' => TeachingBlockFixtures::TEACHING_BLOCK_B1,
                'children' => [
                    [
                        'name' => 'RGPD',
                        'code' => 'LEGAL_RGPD',
                        'description' => 'Règlementation données',
                        'hours_count' => 7,
                        'capstone_project' => false,
                        'reference_module' => self::MODULE_RGP,
                    ],
                    [
                        'name' => 'Propriété intellectuelle',
                        'code' => 'LEGAL_IP',
                        'description' => 'Droits d\'auteur',
                        'hours_count' => 7,
                        'capstone_project' => false,
                        'reference_module' => self::MODULE_IP,
                    ],
                    [
                        'name' => 'Accessibilité',
                        'code' => 'LEGAL_ACCS',
                        'description' => 'Normes RGAA',
                        'hours_count' => 7,
                        'capstone_project' => false,
                        'reference_module' => self::MODULE_A11Y,
                    ],
                ]
            ],
            [
                'name' => 'Devops et Cybersécurité',
                'code' => 'DEVOPS',
                'description' => null,
                'hours_count' => 56,
                'capstone_project' => false,
                'teaching_block' => TeachingBlockFixtures::TEACHING_BLOCK_B2,
                'children' => [
                    [
                        'name' => 'Docker',
                        'code' => 'DEVOPS_DOCKER',
                        'description' => 'Conteneurisation',
                        'hours_count' => 14,
                        'capstone_project' => false,
                        'reference_module' => self::MODULE_DOCKER,
                    ],
                    [
                        'name' => 'Git',
                        'code' => 'DEVOPS_GIT',
                        'description' => 'Gestion de versions',
                        'hours_count' => 7,
                        'capstone_project' => false,
                        'reference_module' => self::MODULE_GIT,
                    ],
                    [
                        'name' => 'CI/CD',
                        'code' => 'DEVOPS_CICD',
                        'description' => 'Intégration continue',
                        'hours_count' => 21,
                        'capstone_project' => true,
                        'reference_module' => self::MODULE_CICD,
                    ]
                ]
            ],
            [
                'name' => 'Architecture des données',
                'code' => 'DATA',
                'description' => null,
                'hours_count' => 10,
                'capstone_project' => false,
                'teaching_block' => TeachingBlockFixtures::TEACHING_BLOCK_B3,
                'children' => [
                    [
                        'name' => 'Conception BDD',
                        'code' => 'DATA_MCD',
                        'description' => 'MCD et MLD',
                        'hours_count' => 7,
                        'capstone_project' => false,
                        'reference_module' => self::MODULE_MCD,
                    ],
                    [
                        'name' => 'Monitoring BDD',
                        'code' => 'DATA_SQL',
                        'description' => 'Optimisation SQL',
                        'hours_count' => 3,
                        'capstone_project' => false,
                        'reference_module' => self::MODULE_SQL,
                    ]
                ]
            ],
            [
                'code' => 'DEV_FRONT',
                'name' => 'Développement Front',
                'description' => null,
                'hours_count' => 126,
                'capstone_project' => false,
                'teaching_block' => TeachingBlockFixtures::TEACHING_BLOCK_B4,
                'children' => [
                    [
                        'code' => 'TAILWIND',
                        'name' => 'Tailwind CSS',
                        'description' => 'Framework CSS',
                        'hours_count' => 14,
                        'capstone_project' => false,
                        'reference_module' => self::MODULE_TAILWIND,
                    ],
                    [
                        'code' => 'REACT',
                        'name' => 'React JS',
                        'description' => 'Librairie JS',
                        'hours_count' => 49,
                        'capstone_project' => true,
                        'reference_module' => self::MODULE_REACT,
                    ],
                    [
                        'code' => 'NEXT',
                        'name' => 'NextJS',
                        'description' => 'Framework React',
                        'hours_count' => 28,
                        'capstone_project' => true,
                        'reference_module' => self::MODULE_NEXT,
                    ],
                ],
            ],
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

    public function getDependencies(): array
    {
        return [
            TeachingBlockFixtures::class,
        ];
    }
}

