<?php

namespace App\DataFixtures;

use App\Entity\InstructorModule;
use App\Entity\Instructor;
use App\Entity\Module; 
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class InstructorModuleFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        
        for ($i = 0; $i < 5; $i++) {
            $instructorModule = new InstructorModule();

            $instructorRef = $this->getReference('instructor-' . ($i+1), Instructor::class);
            $instructorModule->setInstructor($instructorRef);

            $moduleRef = $this->getReference('module-' . rand(1, 4), Module::class);
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