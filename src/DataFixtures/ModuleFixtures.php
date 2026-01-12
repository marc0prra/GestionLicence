<?php

namespace App\DataFixtures;

use App\Entity\Module;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ModuleFixtures extends Fixture
{
    public function data() {
        return [
            [
                'code' => 'Tailwind_CSS',
                
                
            ]
        ];
    }

    public function load(ObjectManager $manager): void
    {
        

        $manager->flush();
    }
}
