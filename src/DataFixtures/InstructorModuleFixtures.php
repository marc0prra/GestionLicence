<?php

namespace App\DataFixtures;

use App\Entity\InstructorModule;
use App\Entity\Instructor;
use App\Entity\Module; // Assure-toi du bon namespace
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class InstructorModuleFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // Permet de définir quel enseignant appartient à un sous-module
        $assignments = [
            'instructor-1' => ModuleFixtures::MODULE_RGP,
            'instructor-2' => ModuleFixtures::MODULE_DOCKER,
            'instructor-3' => ModuleFixtures::MODULE_GIT,
            'instructor-4' => ModuleFixtures::MODULE_REACT,
        ];

        foreach ($assignments as $instructorRef => $subModuleRef) {
            $instructor = $this->getReference($instructorRef, Instructor::class);
            $subModule = $this->getReference($subModuleRef, Module::class);

            $instructorModule = new InstructorModule();

            $instructorRef = $this->getReference(InstructorFixtures::INSTRUCTOR_REFERENCE . $i, Instructor::class);
            $instructorModule->setInstructor($instructorRef);

            $moduleRef = $this->getReference(ModuleFixtures::MODULE_REFERENCE . $i, Module::class);
            $instructorModule->setModule($moduleRef);

            $manager->persist($instructorModule);
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