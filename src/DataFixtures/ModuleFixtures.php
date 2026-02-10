<?php

namespace App\DataFixtures;

use App\Entity\Module;
use App\Entity\TeachingBlock;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ModuleFixtures extends Fixture implements DependentFixtureInterface
{
    // Constantes pour les modules (utilisées comme références dans les fixtures)
    public const MODULE_LEGAL = 'module-legal';
    public const MODULE_REX = 'module-rex';
    public const MODULE_RCRA = 'module-rcra';
    public const MODULE_AGILE = 'module-agile';
    public const MODULE_RGP = 'module-rgpd';
    public const MODULE_DEVOPS = 'module-devops';
    public const MODULE_IP = 'module-ip';
    public const MODULE_RSE = 'module-rse';
    public const MODULE_ACCESSIBILITE = 'module-accessibilite';
    public const MODULE_ECO = 'module-eco';
    public const MODULE_ANGLAIS = 'module-anglais';
    public const MODULE_COMMUNICATION = 'module-communication';
    public const MODULE_ENV_TRAVAIL = 'module-env-travail';
    public const MODULE_ENV_PROD = 'module-env-prod';
    public const MODULE_DOCKER = 'module-docker';
    public const MODULE_GIT = 'module-git';
    public const MODULE_DEVOPS_CYBER = 'module-devops-cyber';
    public const MODULE_CONFERENCE = 'module-conference';
    public const MODULE_CONFERENCE_RCRA = 'module-conference-rcra';
    public const MODULE_ARCHI_DATA = 'module-archi-data';
    public const MODULE_FRONT = 'module-front';
    public const MODULE_BACK = 'module-back';
    public const MODULE_MCD = 'module-mcd';
    public const MODULE_SQL = 'module-sql';
    public const MODULE_UX_FONDAMENTAUX = 'module-ux-fondamentaux';
    public const MODULE_UI_UX_PROJET = 'module-ui-ux-projet';
    public const MODULE_UI_UX_PROJET_2 = 'module-ui-ux-projet-2';
    public const MODULE_ARCHI_BDD = 'module-archi-bdd';
    public const MODULE_MONITORING_BDD = 'module-monitoring-bdd';
    public const MODULE_TAILWIND = 'module-tailwind';
    public const MODULE_JAVASCRIPT = 'module-javascript';
    public const MODULE_REACT = 'module-react';
    public const MODULE_NEXT = 'module-next';
    public const MODULE_PHP_NIVEAU = 'module-php-niveau';
    public const MODULE_PHP_OBJET = 'module-php-objet';
    public const MODULE_SYMFONY = 'module-symfony';
    public const MODULE_ERGO = 'module-ergo';
    public const MODULE_UX_UI = 'module-ux-ui';

    public static function data(): array
    {
        // Tableau qui contient tous les modules
        return [
            // BLOC D'ENSEIGNEMENT B1
            [
                'name' => 'Gestion de projet - Méthode Agile',
                'code' => 'AGILE',
                'description' => '',
                'hours_count' => 63,
                'capstone_project' => true,
                'teaching_block' => TeachingBlockFixtures::TEACHING_BLOCK_B1,
                'reference' => self::MODULE_AGILE,
            ],
            [
                'name' => 'Cadre légal - Droit numérique',
                'code' => 'LEGAL',
                'description' => '',
                'hours_count' => 21,
                'capstone_project' => false,
                'teaching_block' => TeachingBlockFixtures::TEACHING_BLOCK_B1,
                'reference' => self::MODULE_LEGAL,
                'children' => [
                    [
                        'name' => 'RGPD',
                        'code' => 'LEGAL_RGPD',
                        'description' => 'Règlementation données',
                        'hours_count' => 7,
                        'capstone_project' => false,
                        'reference' => self::MODULE_RGP,
                    ],
                    [
                        'name' => 'Propriété intellectuelle',
                        'code' => 'LEGAL_IP',
                        'description' => 'Droits d\'auteur',
                        'hours_count' => 7,
                        'capstone_project' => false,
                        'reference' => self::MODULE_IP,
                    ],
                    [
                        'name' => 'RSE',
                        'code' => 'LEGAL_RSE',
                        'description' => 'Respect des enjeux environnementaux',
                        'hours_count' => 7,
                        'capstone_project' => false,
                        'reference' => self::MODULE_RSE,
                    ],
                    [
                        'name' => 'Accessibilité',
                        'code' => 'LEGAL_ACCESSIBILITE',
                        'description' => 'Accessibilité numérique',
                        'hours_count' => 7,
                        'capstone_project' => false,
                        'reference' => self::MODULE_ACCESSIBILITE,
                    ],
                ],
            ],

            [
                'name' => 'Eco-conception',
                'code' => 'LEGAL_ECO',
                'description' => 'Conception durable',
                'hours_count' => 3.5,
                'capstone_project' => true,
                'teaching_block' => TeachingBlockFixtures::TEACHING_BLOCK_B1,
                'reference' => self::MODULE_ECO,
            ],

            // BLOC D'ENSEIGNEMENT B2
            [
                'name' => 'Anglais - Préparation au TOEIC',
                'code' => 'ANGLAIS',
                'description' => 'Préparation au TOEIC',
                'hours_count' => 17.5,
                'capstone_project' => false,
                'teaching_block' => TeachingBlockFixtures::TEACHING_BLOCK_B2,
                'reference' => self::MODULE_ANGLAIS,
            ],

            [
                'name' => 'Communication - Soft Skills',
                'code' => 'COMM',
                'description' => 'Compétences relationnelles',
                'hours_count' => 28,
                'capstone_project' => false,
                'teaching_block' => TeachingBlockFixtures::TEACHING_BLOCK_B2,
                'reference' => self::MODULE_COMMUNICATION,
            ],

            [
                'name' => 'DevOps et Cybersécurité',
                'code' => 'DEVOPS',
                'description' => '',
                'hours_count' => 56,
                'capstone_project' => false,
                'teaching_block' => TeachingBlockFixtures::TEACHING_BLOCK_B2,
                'reference' => self::MODULE_DEVOPS,
                'children' => [
                    [
                        'name' => 'Environnement de travail',
                        'code' => 'DEVOPS_ENV_TRAVAIL',
                        'description' => 'Configuration environnement dev',
                        'hours_count' => 7,
                        'capstone_project' => false,
                        'reference' => self::MODULE_ENV_TRAVAIL,
                    ],
                    [
                        'name' => 'Environnement de production',
                        'code' => 'DEVOPS_ENV_PROD',
                        'description' => 'Configuration environnement prod',
                        'hours_count' => 7,
                        'capstone_project' => false,
                        'reference' => self::MODULE_ENV_PROD,
                    ],
                    [
                        'name' => 'Docker',
                        'code' => 'DEVOPS_DOCKER',
                        'description' => 'Conteneurisation',
                        'hours_count' => 14,
                        'capstone_project' => false,
                        'reference' => self::MODULE_DOCKER,
                    ],
                    [
                        'name' => 'Git',
                        'code' => 'DEVOPS_GIT',
                        'description' => 'Gestion de versions',
                        'hours_count' => 7,
                        'capstone_project' => true,
                        'reference' => self::MODULE_GIT,
                    ],
                    [
                        'name' => 'Devops/Cyber',
                        'code' => 'DEVOPS_CYBER',
                        'description' => 'DevOps et Cybersécurité',
                        'hours_count' => 21,
                        'capstone_project' => false,
                        'reference' => self::MODULE_DEVOPS_CYBER,
                    ],
                ],
            ],

            [
                'name' => 'Retour d\'expérience (REX)',
                'code' => 'REX',
                'description' => '',
                'hours_count' => 3.5,
                'capstone_project' => false,
                'teaching_block' => TeachingBlockFixtures::TEACHING_BLOCK_B2,
                'reference' => self::MODULE_REX,
                'children' => [
                    [
                        'name' => 'Conférence',
                        'code' => 'REX_CONF',
                        'description' => 'Conférence professionnelle',
                        'hours_count' => 3.5,
                        'capstone_project' => false,
                        'reference' => self::MODULE_CONFERENCE,
                    ],
                ],
            ],

            // BLOC D'ENSEIGNEMENT B3
            [
                'name' => 'Rédaction de comptes rendus d\'activités)',
                'code' => 'RCRA',
                'description' => '',
                'hours_count' => 3.5,
                'capstone_project' => false,
                'teaching_block' => TeachingBlockFixtures::TEACHING_BLOCK_B3,
                'reference' => self::MODULE_RCRA,
                'children' => [
                    [
                        'name' => 'Conférence',
                        'code' => 'REX_CONF',
                        'description' => 'Conférence professionnelle',
                        'hours_count' => 3.5,
                        'capstone_project' => true,
                        'reference' => self::MODULE_CONFERENCE_RCRA,
                    ],
                ],
            ],

            // BLOC D'ENSEIGNEMENT B4
            [
                'name' => 'Ergonomie et maquettage des applications',
                'code' => 'ERGO',
                'description' => '',
                'hours_count' => 59,
                'capstone_project' => false,
                'teaching_block' => TeachingBlockFixtures::TEACHING_BLOCK_B4,
                'reference' => self::MODULE_ERGO,
                'children' => [
                    [
                        'name' => 'User Expérience / User Interface',
                        'code' => 'ERGO_UX_UI',
                        'description' => 'User Expérience / User Interface',
                        'hours_count' => 21,
                        'capstone_project' => false,
                        'reference' => self::MODULE_UX_UI,
                        'children2' => [
                            [
                                'name' => 'Les fondamentaux de l\'UX',
                                'code' => 'ERGO_UX_FOND',
                                'description' => 'Fondamentaux User Experience',
                                'hours_count' => 21,
                                'capstone_project' => false,
                                'reference' => self::MODULE_UX_FONDAMENTAUX,
                            ],
                            [
                                'name' => 'L\'UI et l\'UX en mode projet',
                                'code' => 'ERGO_UI_UX',
                                'description' => 'UI/UX en mode projet',
                                'hours_count' => 28,
                                'capstone_project' => true,
                                'reference' => self::MODULE_UI_UX_PROJET,
                            ],
                        ],
                    ],
                ],
            ],

            [
                'name' => 'Architecture des données',
                'code' => 'ARCHI_DATA',
                'description' => '',
                'hours_count' => 10.5,
                'capstone_project' => false,
                'teaching_block' => TeachingBlockFixtures::TEACHING_BLOCK_B4,
                'reference' => self::MODULE_ARCHI_DATA,
                'children' => [
                    [
                        'name' => 'Structurer et mettre en place une architecture de base de données',
                        'code' => 'ARCHI_STRUCT',
                        'description' => 'Architecture BDD',
                        'hours_count' => 7,
                        'capstone_project' => true,
                        'reference' => self::MODULE_ARCHI_BDD,
                    ],
                    [
                        'name' => 'Monitorer une base de données + performance',
                        'code' => 'ARCHI_MONITOR',
                        'description' => 'Monitoring et performance BDD',
                        'hours_count' => 3.5,
                        'capstone_project' => true,
                        'reference' => self::MODULE_MONITORING_BDD,
                        'children2' => [
                            [
                                'name' => 'L\'UI et l\'UX en mode projet',
                                'code' => 'ERGO_UI_UX',
                                'description' => 'UI/UX en mode projet',
                                'hours_count' => 28,
                                'capstone_project' => true,
                                'reference' => self::MODULE_UI_UX_PROJET_2,
                            ],
                        ],
                    ],
                ],
            ],

            [
                'name' => 'Développement front',
                'code' => 'FRONT',
                'description' => '',
                'hours_count' => 126,
                'capstone_project' => false,
                'teaching_block' => TeachingBlockFixtures::TEACHING_BLOCK_B4,
                'reference' => self::MODULE_FRONT,
                'children' => [
                    [
                        'name' => 'Tailwind CSS',
                        'code' => 'FRONT_TAILWIND',
                        'description' => 'Framework CSS',
                        'hours_count' => 14,
                        'capstone_project' => false,
                        'reference' => self::MODULE_TAILWIND,
                    ],
                    [
                        'name' => 'Javascript',
                        'code' => 'FRONT_JS',
                        'description' => 'Langage Javascript',
                        'hours_count' => 35,
                        'capstone_project' => false,
                        'reference' => self::MODULE_JAVASCRIPT,
                    ],
                    [
                        'name' => 'React',
                        'code' => 'FRONT_REACT',
                        'description' => 'Librairie React',
                        'hours_count' => 49,
                        'capstone_project' => true,
                        'reference' => self::MODULE_REACT,
                    ],
                    [
                        'name' => 'NextJS',
                        'code' => 'FRONT_NEXT',
                        'description' => 'Framework React',
                        'hours_count' => 28,
                        'capstone_project' => false,
                        'reference' => self::MODULE_NEXT,
                    ],
                ],
            ],

            [
                'name' => 'Développement back',
                'code' => 'BACK',
                'description' => '',
                'hours_count' => 112,
                'capstone_project' => false,
                'teaching_block' => TeachingBlockFixtures::TEACHING_BLOCK_B4,
                'reference' => self::MODULE_BACK,
                'children' => [
                    [
                        'name' => 'Mise à niveau de PHP',
                        'code' => 'BACK_PHP_NIV',
                        'description' => 'Fondamentaux PHP',
                        'hours_count' => 21,
                        'capstone_project' => false,
                        'reference' => self::MODULE_PHP_NIVEAU,
                    ],
                    [
                        'name' => 'PHP Objet',
                        'code' => 'BACK_PHP_OBJ',
                        'description' => 'Programmation orientée objet PHP',
                        'hours_count' => 28,
                        'capstone_project' => false,
                        'reference' => self::MODULE_PHP_OBJET,
                    ],
                    [
                        'name' => 'Symfony',
                        'code' => 'BACK_SYMFONY',
                        'description' => 'Framework Symfony',
                        'hours_count' => 63,
                        'capstone_project' => true,
                        'reference' => self::MODULE_SYMFONY,
                    ],
                ],
            ],
        ];
    }

    public function load(ObjectManager $manager): void
    {
        // Modules principaux
        for ($i = 0; $i < count(self::data()); ++$i) {
            $module = new Module();
            $module->setCode(self::data()[$i]['code']);
            $module->setName(self::data()[$i]['name']);
            $module->setDescription(self::data()[$i]['description']);
            $module->setHoursCount(self::data()[$i]['hours_count']);
            $module->setCapstoneProject(self::data()[$i]['capstone_project']);

            $module->setTeachingBlock($this->getReference(self::data()[$i]['teaching_block'], TeachingBlock::class));

            $this->addReference(self::data()[$i]['reference'], $module);

            // Modules secondaires
            if (isset(self::data()[$i]['children'])) {
                for ($j = 0; $j < count(self::data()[$i]['children']); ++$j) {
                    $subModule = new Module();
                    $subModule->setCode(self::data()[$i]['children'][$j]['code']);
                    $subModule->setName(self::data()[$i]['children'][$j]['name']);
                    $subModule->setDescription(self::data()[$i]['children'][$j]['description']);
                    $subModule->setHoursCount(self::data()[$i]['children'][$j]['hours_count']);
                    $subModule->setCapstoneProject(self::data()[$i]['children'][$j]['capstone_project']);
                    $subModule->setTeachingBlock($module->getTeachingBlock());
                    $subModule->setParent($module);

                    $this->addReference(self::data()[$i]['children'][$j]['reference'], $subModule);

                    $manager->persist($subModule);

                    // Modules tiers
                    if (isset(self::data()[$i]['children'][$j]['children2'])) {
                        for ($k = 0; $k < count(self::data()[$i]['children'][$j]['children2']); ++$k) {
                            $subSubModule = new Module();
                            $subSubModule->setCode(self::data()[$i]['children'][$j]['children2'][$k]['code']);
                            $subSubModule->setName(self::data()[$i]['children'][$j]['children2'][$k]['name']);
                            $subSubModule->setDescription(self::data()[$i]['children'][$j]['children2'][$k]['description']);
                            $subSubModule->setHoursCount(self::data()[$i]['children'][$j]['children2'][$k]['hours_count']);
                            $subSubModule->setCapstoneProject(self::data()[$i]['children'][$j]['children2'][$k]['capstone_project']);
                            $subSubModule->setTeachingBlock($subModule->getTeachingBlock());
                            $subSubModule->setParent($subModule);

                            $this->addReference(self::data()[$i]['children'][$j]['children2'][$k]['reference'], $subSubModule);

                            $manager->persist($subSubModule);
                        }
                    }
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
