<?php

namespace App\DataFixtures;

use App\Entity\Indisponible;
use App\Entity\Instructor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class IndisponibleFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $data = [
            [
                'startDate' => new \DateTime('2026-01-06'),
                'endDate' => new \DateTime('2026-01-10'),
                'motif' => 'Congés',
                'instructor' => InstructorFixtures::INSTRUCTOR_1,
            ],
            [
                'startDate' => new \DateTime('2026-02-10'),
                'endDate' => new \DateTime('2026-02-12'),
                'motif' => 'Déplacement professionnel',
                'instructor' => InstructorFixtures::INSTRUCTOR_2,
            ],
            [
                'startDate' => new \DateTime('2026-03-15'),
                'endDate' => new \DateTime('2026-03-16'),
                'motif' => null,
                'instructor' => InstructorFixtures::INSTRUCTOR_1,
            ],
        ];

        foreach ($data as $item) {
            $abs = new Indisponible();
            $abs->setStartDate($item['startDate']);
            $abs->setEndDate($item['endDate']);
            $abs->setMotif($item['motif']);
            $abs->setInstructor($this->getReference($item['instructor'], Instructor::class));

            $manager->persist($abs);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            InstructorFixtures::class,
        ];
    }
}
