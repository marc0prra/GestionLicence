<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    // Constantes pour les instructeurs (utilisées comme références dans les fixtures)
    public const USER_INSTRUCTOR_1 = 'user-instructor-1';
    public const USER_INSTRUCTOR_2 = 'user-instructor-2';
    public const USER_INSTRUCTOR_3 = 'user-instructor-3';
    public const USER_INSTRUCTOR_4 = 'user-instructor-4';
    public const USER_INSTRUCTOR_5 = 'user-instructor-5';
    public const USER_INSTRUCTOR_6 = 'user-instructor-6';
    public const USER_INSTRUCTOR_7 = 'user-instructor-7';
    public const USER_INSTRUCTOR_8 = 'user-instructor-8';
    public const USER_INSTRUCTOR_9 = 'user-instructor-9';
    public const USER_INSTRUCTOR_10 = 'user-instructor-10';
    public const USER_INSTRUCTOR_11 = 'user-instructor-11';
    public const USER_INSTRUCTOR_12 = 'user-instructor-12';
    public const USER_INSTRUCTOR_13 = 'user-instructor-13';
    public const USER_INSTRUCTOR_14 = 'user-instructor-14';
    public const USER_INSTRUCTOR_15 = 'user-instructor-15';
    public const USER_INSTRUCTOR_16 = 'user-instructor-16';

    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public static function data(): array
    {
        // Tableau qui contient tous les enseignants et l'administrateur
        return [
            [
                'email' => 'stellaribas@gmail.com',
                'role' => 'ROLE_ADMIN',
                'firstName' => 'Stella',
                'lastName' => 'Ribas',
                'password' => 'test',
            ],

            [
                'email' => 'j.martins@mentalworks.fr',
                'role' => 'ROLE_USER',
                'firstName' => 'Jeff-Jacquelot',
                'lastName' => 'Martins',
                'password' => 'test1',
                'reference_instructor' => self::USER_INSTRUCTOR_1,
            ],

            [
                'email' => 'n.pineau@gmail.com',
                'role' => 'ROLE_USER',
                'firstName' => 'Nicolas',
                'lastName' => 'Pineau',
                'password' => 'test2',
                'reference_instructor' => self::USER_INSTRUCTOR_2,
            ],

            [
                'email' => 'h.knorr@gmail.com',
                'role' => 'ROLE_USER',
                'firstName' => 'Hugo',
                'lastName' => 'Knorr',
                'password' => 'test3',
                'reference_instructor' => self::USER_INSTRUCTOR_3,
            ],

            [
                'email' => 'v.hougron@gmail.com',
                'role' => 'ROLE_USER',
                'firstName' => 'Virginie',
                'lastName' => 'Hougron',
                'password' => 'test4',
                'reference_instructor' => self::USER_INSTRUCTOR_4,
            ],

            [
                'email' => 's.aracil@gmail.com',
                'role' => 'ROLE_USER',
                'firstName' => 'Sonia',
                'lastName' => 'Aracil',
                'password' => 'test5',
                'reference_instructor' => self::USER_INSTRUCTOR_5,
            ],

            [
                'email' => 'c.espargeliere@mozartsduweb.com',
                'role' => 'ROLE_USER',
                'firstName' => 'Christopher',
                'lastName' => 'Espargeliere',
                'password' => 'test6',
                'reference_instructor' => self::USER_INSTRUCTOR_6,
            ],

            [
                'email' => 'd.aste@gmail.com',
                'role' => 'ROLE_USER',
                'firstName' => 'Dominique',
                'lastName' => 'Aste',
                'password' => 'test7',
                'reference_instructor' => self::USER_INSTRUCTOR_7,
            ],

            [
                'email' => 'c.haller@ec2e.fr',
                'role' => 'ROLE_USER',
                'firstName' => 'Charles',
                'lastName' => 'Haller',
                'password' => 'test8',
                'reference_instructor' => self::USER_INSTRUCTOR_8,
            ],

            [
                'email' => 'o.salesse@mentalworks.fr',
                'role' => 'ROLE_USER',
                'firstName' => 'Olivier',
                'lastName' => 'Salesse',
                'password' => 'test9',
                'reference_instructor' => self::USER_INSTRUCTOR_9,
            ],

            [
                'email' => 'm.idasiak@gmail.com',
                'role' => 'ROLE_USER',
                'firstName' => 'Mikaël',
                'lastName' => 'Idasiak',
                'password' => 'test10',
                'reference_instructor' => self::USER_INSTRUCTOR_10,
            ],

            [
                'email' => 'n.castro@nodevo.com',
                'role' => 'ROLE_USER',
                'firstName' => 'Nicolas',
                'lastName' => 'Castro',
                'password' => 'test11',
                'reference_instructor' => self::USER_INSTRUCTOR_11,
            ],

            [
                'email' => 'g.daniel@gmail.com',
                'role' => 'ROLE_USER',
                'firstName' => 'Gaël',
                'lastName' => 'Daniel',
                'password' => 'test12',
                'reference_instructor' => self::USER_INSTRUCTOR_12,
            ],

            [
                'email' => 'n.driancourt@gmail.com',
                'role' => 'ROLE_USER',
                'firstName' => 'Nicolas',
                'lastName' => 'Driancourt',
                'password' => 'test13',
                'reference_instructor' => self::USER_INSTRUCTOR_13,
            ],

            [
                'email' => 'm.delsaux@gmail.com',
                'role' => 'ROLE_USER',
                'firstName' => 'Maxime',
                'lastName' => 'Delsaux',
                'password' => 'test14',
                'reference_instructor' => self::USER_INSTRUCTOR_14,
            ],

            [
                'email' => 'b.esquenet@gmail.com',
                'role' => 'ROLE_USER',
                'firstName' => 'Brigitte',
                'lastName' => 'Esquenet',
                'password' => 'test15',
                'reference_instructor' => self::USER_INSTRUCTOR_15,
            ],

            [
                'email' => 'c.pereira@nanotera.com',
                'role' => 'ROLE_USER',
                'firstName' => 'Cyril',
                'lastName' => 'Pereira',
                'password' => 'test16',
                'reference_instructor' => self::USER_INSTRUCTOR_16,
            ],
        ];
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < count(self::data()); ++$i) {
            $user = new User();
            $user->setEmail(self::data()[$i]['email']);
            $user->setRole(self::data()[$i]['role']);
            $user->setFirstName(self::data()[$i]['firstName']);
            $user->setLastName(self::data()[$i]['lastName']);
            $user->setPassword($this->hasher->hashPassword($user, self::data()[$i]['password']));

            $manager->persist($user);

            if (isset(self::data()[$i]['reference_instructor'])) {
                $this->addReference(self::data()[$i]['reference_instructor'], $user);
            }
        }

        $manager->flush();
    }
}
