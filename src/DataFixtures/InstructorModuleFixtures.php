<?php

namespace App\DataFixtures;

use App\Entity\Instructor;
use App\Entity\InstructorModule;
use App\Entity\Module; // Assure-toi du bon namespace
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class InstructorModuleFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // Définir quel enseignant va sur quel module/sous-module
        $assignments = [
            'instructor-1' => [
                ModuleFixtures::MODULE_DEVOPS_CYBER,
                ModuleFixtures::MODULE_ENV_TRAVAIL,
                ModuleFixtures::MODULE_ENV_PROD,
                ModuleFixtures::MODULE_DOCKER,
                ModuleFixtures::MODULE_GIT,
                ModuleFixtures::MODULE_MONITORING_BDD,
                ModuleFixtures::MODULE_UI_UX_PROJET_2,
                ModuleFixtures::MODULE_FRONT,
            ],

            'instructor-2' => [
                ModuleFixtures::MODULE_JAVASCRIPT,
            ],

            'instructor-3' => [
                ModuleFixtures::MODULE_BACK,
                ModuleFixtures::MODULE_SYMFONY,
                ModuleFixtures::MODULE_FRONT,
                ModuleFixtures::MODULE_REACT,
            ],

            'instructor-4' => [
                ModuleFixtures::MODULE_RCRA,
                ModuleFixtures::MODULE_CONFERENCE_RCRA,
                ModuleFixtures::MODULE_COMMUNICATION,
            ],

            'instructor-5' => [
                ModuleFixtures::MODULE_ERGO,
                ModuleFixtures::MODULE_UX_UI,
                ModuleFixtures::MODULE_UX_FONDAMENTAUX,
            ],

            'instructor-6' => [
                ModuleFixtures::MODULE_FRONT,
                ModuleFixtures::MODULE_TAILWIND,
            ],

            'instructor-7' => [
                ModuleFixtures::MODULE_AGILE,
            ],

            'instructor-8' => [
                ModuleFixtures::MODULE_BACK,
                ModuleFixtures::MODULE_PHP_NIVEAU,
                ModuleFixtures::MODULE_PHP_OBJET,
            ],

            'instructor-9' => [
                ModuleFixtures::MODULE_ERGO,
                ModuleFixtures::MODULE_UI_UX_PROJET,
            ],

            'instructor-10' => [
                ModuleFixtures::MODULE_ARCHI_DATA,
                ModuleFixtures::MODULE_ARCHI_BDD,
            ],

            'instructor-11' => [
                ModuleFixtures::MODULE_FRONT,
                ModuleFixtures::MODULE_NEXT,
            ],

            'instructor-12' => [
                ModuleFixtures::MODULE_LEGAL,
                ModuleFixtures::MODULE_RGP,
                ModuleFixtures::MODULE_IP,
                ModuleFixtures::MODULE_RSE,
            ],

            'instructor-14' => [
                ModuleFixtures::MODULE_DEVOPS,
                ModuleFixtures::MODULE_DEVOPS_CYBER,
            ],

            'instructor-15' => [
                ModuleFixtures::MODULE_ANGLAIS,
            ],

            'instructor-16' => [
                ModuleFixtures::MODULE_REX,
                ModuleFixtures::MODULE_CONFERENCE,
            ],
        ];

        // On parcourt les assignements pour récupérer les enseignants
        foreach ($assignments as $instructorRef => $modulesRef) {
            $instructor = $this->getReference($instructorRef, Instructor::class);

            // On parcourt les modules pour récupérer les modules
            foreach ($modulesRef as $moduleRef) {
                $module = $this->getReference($moduleRef, Module::class);

                $instructorModule = new InstructorModule();
                $instructorModule->setInstructor($instructor);
                $instructorModule->setModule($module);

                $manager->persist($instructorModule);
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            InstructorFixtures::class,
            ModuleFixtures::class,
        ];
    }
}
