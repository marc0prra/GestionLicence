<?php

namespace App\DataFixtures;

use App\Entity\Module;
use App\Entity\TeachingBlock;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ModuleFixtures extends Fixture implements DependentFixtureInterface
{
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
                        'capstone_project' => false
                    ],
                    [
                        'name' => 'Propriété intellectuelle',
                        'code' => 'LEGAL_IP',
                        'description' => 'Droits d\'auteur',
                        'hours_count' => 7,
                        'capstone_project' => false
                    ],
                    [
                        'name' => 'Accessibilité',
                        'code' => 'LEGAL_A11Y',
                        'description' => 'Normes RGAA',
                        'hours_count' => 7,
                        'capstone_project' => false
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
                        'capstone_project' => false
                    ],
                    [
                        'name' => 'Git',
                        'code' => 'DEVOPS_GIT',
                        'description' => 'Gestion de versions',
                        'hours_count' => 7,
                        'capstone_project' => false
                    ],
                    [
                        'name' => 'CI/CD',
                        'code' => 'DEVOPS_CICD',
                        'description' => 'Intégration continue',
                        'hours_count' => 21,
                        'capstone_project' => true
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
                        'capstone_project' => false
                    ],
                    [
                        'name' => 'Monitoring BDD',
                        'code' => 'DATA_SQL',
                        'description' => 'Optimisation SQL',
                        'hours_count' => 3,
                        'capstone_project' => false
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
                    ],
                    [
                        'code' => 'REACT',
                        'name' => 'React JS',
                        'description' => 'Librairie JS',
                        'hours_count' => 49,
                        'capstone_project' => true,
                    ],
                    [
                        'code' => 'NEXT',
                        'name' => 'NextJS',
                        'description' => 'Framework React',
                        'hours_count' => 28,
                        'capstone_project' => true,
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
            
            $this->addReference('module-'. ($i+1), $module);       
            
            if (isset(self::data()[$i]['children'])) {
                foreach (self::data()[$i]['children'] as $j => $child) {
                    $subModule = new Module();
                    $subModule->setCode($child['code']);
                    $subModule->setName($child['name']);
                    $subModule->setDescription($child['description']);
                    $subModule->setHoursCount($child['hours_count']);
                    $subModule->setCapstoneProject($child['capstone_project']);
                    $subModule->setTeachingBlock($module->getTeachingBlock());
                    $subModule->setParent($module);

                    $this->addReference('subModule-'.($i+1).'-'.($j+1), $subModule);

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

