<?php

namespace App\DataFixtures;

use App\Entity\Unaivibility;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Instructor;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class UnaivibilityFixtures extends Fixture implements DependentFixtureInterface
{
    public static function data(): array 
    {
       return [
            [
                'startDate' => '2026-06-20 09:00:00',
                'endDate'   => '2026-06-20 16:00:00',
                'reason'    => 'Stage ski intermédiaire',
                'instructor'=> 'instructor-1'
            ],
            [
                'startDate' => '2026-06-22 10:00:00',
                'endDate'   => '2026-06-22 15:00:00',
                'reason'    => 'Coaching individuel',
                'instructor'=> 'instructor-2'
            ],
            [
                'startDate' => '2026-06-25 08:00:00',
                'endDate'   => '2026-06-25 12:00:00',
                'reason'    => 'Préparation physique',
                'instructor'=> 'instructor-3'
            ],
            [
                'startDate' => '2026-06-28 13:30:00',
                'endDate'   => '2026-06-28 17:30:00',
                'reason'    => 'Sortie hors-piste encadrée',
                'instructor'=> 'instructor-4'
            ],
            [
                'startDate' => '2026-07-01 09:00:00',
                'endDate'   => '2026-07-01 14:00:00',
                'reason'    => 'Initiation snowboard',
                'instructor'=> 'instructor-5'
            ],
            [
                'startDate' => '2026-07-03 11:00:00',
                'endDate'   => '2026-07-03 18:00:00',
                'reason'    => 'Encadrement groupe débutant',
                'instructor'=> 'instructor-6'
            ],
            [
                'startDate' => '2026-07-06 08:30:00',
                'endDate'   => '2026-07-06 13:30:00',
                'reason'    => 'Atelier technique carving',
                'instructor'=> 'instructor-7'
            ],
            [
                'startDate' => '2026-07-09 14:00:00',
                'endDate'   => '2026-07-09 19:00:00',
                'reason'    => 'Session freestyle',
                'instructor'=> 'instructor-8'
            ],
            [
                'startDate' => '2026-07-12 09:30:00',
                'endDate'   => '2026-07-12 16:30:00',
                'reason'    => 'Sortie ski de randonnée',
                'instructor'=> 'instructor-9'
            ],
            [
                'startDate' => '2026-07-15 10:00:00',
                'endDate'   => '2026-07-15 17:00:00',
                'reason'    => 'Stage intensif avancé',
                'instructor'=> 'instructor-10'
            ],
        ];
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < count(self::data()); $i++) {
            $unaivibility = new Unaivibility();
            $unaivibility->setStartDate(new \DateTime(self::data()[$i]['startDate']));
            $unaivibility->setEndDate( new \DateTime(self::data()[$i]['endDate']));
            $unaivibility->setReason(self::data()[$i]['reason']);

            $unaivibility->setInstructor($this->getReference(self::data()[$i]['instructor'], Instructor::class));

            $manager->persist($unaivibility);
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
