<?php

namespace App\DataFixtures;

use App\Entity\Module;
use App\Entity\Semester;
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
                'hoursCount' => 63,
                'capstoneProject' => true,
                'teachingBlock' => TeachingBlockFixtures::TEACHING_BLOCK_B1,
                'reference' => self::MODULE_AGILE,
                'semester' => SemesterFixtures::SEMESTER_1,
            ],
            [
                'name' => 'Cadre légal - Droit numérique',
                'code' => 'LEGAL',
                'description' => '',
                'hoursCount' => 21,
                'capstoneProject' => false,
                'teachingBlock' => TeachingBlockFixtures::TEACHING_BLOCK_B1,
                'reference' => self::MODULE_LEGAL,
                'semester' => SemesterFixtures::SEMESTER_1,
                'children' => [
                    [
                        'name' => 'RGPD',
                        'code' => 'LEGAL_RGPD',
                        'description' => 'Règlementation données',
                        'hoursCount' => 7,
                        'capstoneProject' => false,
                        'reference' => self::MODULE_RGP,
                        'semester' => SemesterFixtures::SEMESTER_1,
                    ],
                    [
                        'name' => 'Propriété intellectuelle',
                        'code' => 'LEGAL_IP',
                        'description' => 'Droits d\'auteur',
                        'hoursCount' => 7,
                        'capstoneProject' => false,
                        'reference' => self::MODULE_IP,
                        'semester' => SemesterFixtures::SEMESTER_1,
                    ],
                    [
                        'name' => 'RSE',
                        'code' => 'LEGAL_RSE',
                        'description' => 'Respect des enjeux environnementaux',
                        'hoursCount' => 7,
                        'capstoneProject' => false,
                        'reference' => self::MODULE_RSE,
                        'semester' => SemesterFixtures::SEMESTER_1,
                    ],
                    [
                        'name' => 'Accessibilité',
                        'code' => 'LEGAL_ACCESSIBILITE',
                        'description' => 'Accessibilité numérique',
                        'hoursCount' => 7,
                        'capstoneProject' => false,
                        'reference' => self::MODULE_ACCESSIBILITE,
                        'semester' => SemesterFixtures::SEMESTER_1,
                    ],
                ],
            ],

            [
                'name' => 'Eco-conception',
                'code' => 'LEGAL_ECO',
                'description' => 'Conception durable',
                'hoursCount' => 3.5,
                'capstoneProject' => true,
                'teachingBlock' => TeachingBlockFixtures::TEACHING_BLOCK_B1,
                'reference' => self::MODULE_ECO,
                'semester' => SemesterFixtures::SEMESTER_1,
            ],

            // BLOC D'ENSEIGNEMENT B2
            [
                'name' => 'Anglais - Préparation au TOEIC',
                'code' => 'ANGLAIS',
                'description' => 'Préparation au TOEIC',
                'hoursCount' => 17.5,
                'capstoneProject' => false,
                'teachingBlock' => TeachingBlockFixtures::TEACHING_BLOCK_B2,
                'reference' => self::MODULE_ANGLAIS,
                'semester' => SemesterFixtures::SEMESTER_2,
            ],

            [
                'name' => 'Communication - Soft Skills',
                'code' => 'COMM',
                'description' => 'Compétences relationnelles',
                'hoursCount' => 28,
                'capstoneProject' => false,
                'teachingBlock' => TeachingBlockFixtures::TEACHING_BLOCK_B2,
                'reference' => self::MODULE_COMMUNICATION,
                'semester' => SemesterFixtures::SEMESTER_2,
            ],

            [
                'name' => 'DevOps et Cybersécurité',
                'code' => 'DEVOPS',
                'description' => '',
                'hoursCount' => 56,
                'capstoneProject' => false,
                'teachingBlock' => TeachingBlockFixtures::TEACHING_BLOCK_B2,
                'reference' => self::MODULE_DEVOPS,
                'semester' => SemesterFixtures::SEMESTER_2,
                'children' => [
                    [
                        'name' => 'Environnement de travail',
                        'code' => 'DEVOPS_ENV_TRAVAIL',
                        'description' => 'Configuration environnement dev',
                        'hoursCount' => 7,
                        'capstoneProject' => false,
                        'reference' => self::MODULE_ENV_TRAVAIL,
                        'semester' => SemesterFixtures::SEMESTER_2,
                    ],
                    [
                        'name' => 'Environnement de production',
                        'code' => 'DEVOPS_ENV_PROD',
                        'description' => 'Configuration environnement prod',
                        'hoursCount' => 7,
                        'capstoneProject' => false,
                        'reference' => self::MODULE_ENV_PROD,
                        'semester' => SemesterFixtures::SEMESTER_2,
                    ],
                    [
                        'name' => 'Docker',
                        'code' => 'DEVOPS_DOCKER',
                        'description' => 'Conteneurisation',
                        'hoursCount' => 14,
                        'capstoneProject' => false,
                        'reference' => self::MODULE_DOCKER,
                        'semester' => SemesterFixtures::SEMESTER_2,
                    ],
                    [
                        'name' => 'Git',
                        'code' => 'DEVOPS_GIT',
                        'description' => 'Gestion de versions',
                        'hoursCount' => 7,
                        'capstoneProject' => true,
                        'reference' => self::MODULE_GIT,
                        'semester' => SemesterFixtures::SEMESTER_2,
                    ],
                    [
                        'name' => 'Devops/Cyber',
                        'code' => 'DEVOPS_CYBER',
                        'description' => 'DevOps et Cybersécurité',
                        'hoursCount' => 21,
                        'capstoneProject' => false,
                        'reference' => self::MODULE_DEVOPS_CYBER,
                        'semester' => SemesterFixtures::SEMESTER_2,
                    ],
                ],
            ],

            [
                'name' => 'Retour d\'expérience (REX)',
                'code' => 'REX',
                'description' => '',
                'hoursCount' => 3.5,
                'capstoneProject' => false,
                'teachingBlock' => TeachingBlockFixtures::TEACHING_BLOCK_B2,
                'reference' => self::MODULE_REX,
                'semester' => SemesterFixtures::SEMESTER_2,
                'children' => [
                    [
                        'name' => 'Conférence',
                        'code' => 'REX_CONF',
                        'description' => 'Conférence professionnelle',
                        'hoursCount' => 3.5,
                        'capstoneProject' => false,
                        'reference' => self::MODULE_CONFERENCE,
                        'semester' => SemesterFixtures::SEMESTER_2,
                    ],
                ],
            ],

            // BLOC D'ENSEIGNEMENT B3
            [
                'name' => 'Rédaction de comptes rendus d\'activités)',
                'code' => 'RCRA',
                'description' => '',
                'hoursCount' => 3.5,
                'capstoneProject' => false,
                'teachingBlock' => TeachingBlockFixtures::TEACHING_BLOCK_B3,
                'reference' => self::MODULE_RCRA,
                'semester' => SemesterFixtures::SEMESTER_3,
                'children' => [
                    [
                        'name' => 'Conférence',
                        'code' => 'REX_CONF',
                        'description' => 'Conférence professionnelle',
                        'hoursCount' => 3.5,
                        'capstoneProject' => true,
                        'reference' => self::MODULE_CONFERENCE_RCRA,
                        'semester' => SemesterFixtures::SEMESTER_3,
                    ],
                ],
            ],

            // BLOC D'ENSEIGNEMENT B4
            [
                'name' => 'Ergonomie et maquettage des applications',
                'code' => 'ERGO',
                'description' => '',
                'hoursCount' => 59,
                'capstoneProject' => false,
                'teachingBlock' => TeachingBlockFixtures::TEACHING_BLOCK_B4,
                'reference' => self::MODULE_ERGO,
                'semester' => SemesterFixtures::SEMESTER_1,
                'children' => [
                    [
                        'name' => 'User Expérience / User Interface',
                        'code' => 'ERGO_UX_UI',
                        'description' => 'User Expérience / User Interface',
                        'hoursCount' => 21,
                        'capstoneProject' => false,
                        'reference' => self::MODULE_UX_UI,
                        'semester' => SemesterFixtures::SEMESTER_1,
                        'children2' => [
                            [
                                'name' => 'Les fondamentaux de l\'UX',
                                'code' => 'ERGO_UX_FOND',
                                'description' => 'Fondamentaux User Experience',
                                'hoursCount' => 21,
                                'capstoneProject' => false,
                                'reference' => self::MODULE_UX_FONDAMENTAUX,
                                'semester' => SemesterFixtures::SEMESTER_1,
                            ],
                            [
                                'name' => 'L\'UI et l\'UX en mode projet',
                                'code' => 'ERGO_UI_UX',
                                'description' => 'UI/UX en mode projet',
                                'hoursCount' => 28,
                                'capstoneProject' => true,
                                'reference' => self::MODULE_UI_UX_PROJET,
                                'semester' => SemesterFixtures::SEMESTER_2,
                            ],
                        ],
                    ],
                ],
            ],

            [
                'name' => 'Architecture des données',
                'code' => 'ARCHI_DATA',
                'description' => '',
                'hoursCount' => 10.5,
                'capstoneProject' => false,
                'teachingBlock' => TeachingBlockFixtures::TEACHING_BLOCK_B4,
                'reference' => self::MODULE_ARCHI_DATA,
                'semester' => SemesterFixtures::SEMESTER_2,
                'children' => [
                    [
                        'name' => 'Structurer et mettre en place une architecture de base de données',
                        'code' => 'ARCHI_STRUCT',
                        'description' => 'Architecture BDD',
                        'hoursCount' => 7,
                        'capstoneProject' => true,
                        'reference' => self::MODULE_ARCHI_BDD,
                        'semester' => SemesterFixtures::SEMESTER_2,
                    ],
                    [
                        'name' => 'Monitorer une base de données + performance',
                        'code' => 'ARCHI_MONITOR',
                        'description' => 'Monitoring et performance BDD',
                        'hoursCount' => 3.5,
                        'capstoneProject' => true,
                        'reference' => self::MODULE_MONITORING_BDD,
                        'semester' => SemesterFixtures::SEMESTER_3,
                        'children2' => [
                            [
                                'name' => 'L\'UI et l\'UX en mode projet',
                                'code' => 'ERGO_UI_UX',
                                'description' => 'UI/UX en mode projet',
                                'hoursCount' => 28,
                                'capstoneProject' => true,
                                'reference' => self::MODULE_UI_UX_PROJET_2,
                                'semester' => SemesterFixtures::SEMESTER_3,
                            ],
                        ],
                    ],
                ],
            ],

            [
                'name' => 'Développement front',
                'code' => 'FRONT',
                'description' => '',
                'hoursCount' => 126,
                'capstoneProject' => false,
                'teachingBlock' => TeachingBlockFixtures::TEACHING_BLOCK_B4,
                'reference' => self::MODULE_FRONT,
                'semester' => SemesterFixtures::SEMESTER_2,
                'children' => [
                    [
                        'name' => 'Tailwind CSS',
                        'code' => 'FRONT_TAILWIND',
                        'description' => 'Framework CSS',
                        'hoursCount' => 14,
                        'capstoneProject' => false,
                        'reference' => self::MODULE_TAILWIND,
                        'semester' => SemesterFixtures::SEMESTER_2,
                    ],
                    [
                        'name' => 'Javascript',
                        'code' => 'FRONT_JS',
                        'description' => 'Langage Javascript',
                        'hoursCount' => 35,
                        'capstoneProject' => false,
                        'reference' => self::MODULE_JAVASCRIPT,
                        'semester' => SemesterFixtures::SEMESTER_2,
                    ],
                    [
                        'name' => 'React',
                        'code' => 'FRONT_REACT',
                        'description' => 'Librairie React',
                        'hoursCount' => 49,
                        'capstoneProject' => true,
                        'reference' => self::MODULE_REACT,
                        'semester' => SemesterFixtures::SEMESTER_3,
                    ],
                    [
                        'name' => 'NextJS',
                        'code' => 'FRONT_NEXT',
                        'description' => 'Framework React',
                        'hoursCount' => 28,
                        'capstoneProject' => false,
                        'reference' => self::MODULE_NEXT,
                        'semester' => SemesterFixtures::SEMESTER_3,
                    ],
                ],
            ],

            [
                'name' => 'Développement back',
                'code' => 'BACK',
                'description' => '',
                'hoursCount' => 112,
                'capstoneProject' => false,
                'teachingBlock' => TeachingBlockFixtures::TEACHING_BLOCK_B4,
                'reference' => self::MODULE_BACK,
                'semester' => SemesterFixtures::SEMESTER_2,
                'children' => [
                    [
                        'name' => 'Mise à niveau de PHP',
                        'code' => 'BACK_PHP_NIV',
                        'description' => 'Fondamentaux PHP',
                        'hoursCount' => 21,
                        'capstoneProject' => false,
                        'reference' => self::MODULE_PHP_NIVEAU,
                        'semester' => SemesterFixtures::SEMESTER_2,
                    ],
                    [
                        'name' => 'PHP Objet',
                        'code' => 'BACK_PHP_OBJ',
                        'description' => 'Programmation orientée objet PHP',
                        'hoursCount' => 28,
                        'capstoneProject' => false,
                        'reference' => self::MODULE_PHP_OBJET,
                        'semester' => SemesterFixtures::SEMESTER_2,
                    ],
                    [
                        'name' => 'Symfony',
                        'code' => 'BACK_SYMFONY',
                        'description' => 'Framework Symfony',
                        'hoursCount' => 63,
                        'capstoneProject' => true,
                        'reference' => self::MODULE_SYMFONY,
                        'semester' => SemesterFixtures::SEMESTER_3,
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
            $module->setHoursCount(self::data()[$i]['hoursCount']);
            $module->setCapstoneProject(self::data()[$i]['capstoneProject']);

            $module->setTeachingBlock($this->getReference(self::data()[$i]['teachingBlock'], TeachingBlock::class));
            $module->setSemester($this->getReference(self::data()[$i]['semester'], Semester::class));

            $this->addReference(self::data()[$i]['reference'], $module);

            // Modules secondaires
            if (isset(self::data()[$i]['children'])) {
                for ($j = 0; $j < count(self::data()[$i]['children']); ++$j) {
                    $subModule = new Module();
                    $subModule->setCode(self::data()[$i]['children'][$j]['code']);
                    $subModule->setName(self::data()[$i]['children'][$j]['name']);
                    $subModule->setDescription(self::data()[$i]['children'][$j]['description']);
                    $subModule->setHoursCount(self::data()[$i]['children'][$j]['hoursCount']);
                    $subModule->setCapstoneProject(self::data()[$i]['children'][$j]['capstoneProject']);
                    $subModule->setTeachingBlock($module->getTeachingBlock());
                    $subModule->setParent($module);
                    $subModule->setSemester($this->getReference(self::data()[$i]['children'][$j]['semester'], Semester::class));

                    $this->addReference(self::data()[$i]['children'][$j]['reference'], $subModule);

                    $manager->persist($subModule);

                    // Modules tiers
                    if (isset(self::data()[$i]['children'][$j]['children2'])) {
                        for ($k = 0; $k < count(self::data()[$i]['children'][$j]['children2']); ++$k) {
                            $subSubModule = new Module();
                            $subSubModule->setCode(self::data()[$i]['children'][$j]['children2'][$k]['code']);
                            $subSubModule->setName(self::data()[$i]['children'][$j]['children2'][$k]['name']);
                            $subSubModule->setDescription(self::data()[$i]['children'][$j]['children2'][$k]['description']);
                            $subSubModule->setHoursCount(self::data()[$i]['children'][$j]['children2'][$k]['hoursCount']);
                            $subSubModule->setCapstoneProject(self::data()[$i]['children'][$j]['children2'][$k]['capstoneProject']);
                            $subSubModule->setTeachingBlock($subModule->getTeachingBlock());
                            $subSubModule->setParent($subModule);
                            $subSubModule->setSemester($this->getReference(self::data()[$i]['children'][$j]['children2'][$k]['semester'], Semester::class));

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
            SemesterFixtures::class,
        ];
    }
}
