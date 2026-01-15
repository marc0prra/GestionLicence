<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public const USER_INSTRUCTOR_1 = 'user-instructor-1';
    public const USER_INSTRUCTOR_2 = 'user-instructor-2';
    public const USER_INSTRUCTOR_3 = 'user-instructor-3';
    public const USER_INSTRUCTOR_4 = 'user-instructor-4';

    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public static function data() : array
    {
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
                'firstName' => 'J.',
                'lastName' => 'Martins',
                'password' => 'test1',
                'reference_instructor' => self::USER_INSTRUCTOR_1,
            ],
            [
                'email' => 'n.pineau@gmail.com',
                'role' => 'ROLE_USER',
                'firstName' => 'N.',
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
        ];
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < count(self::data()); $i++) {
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