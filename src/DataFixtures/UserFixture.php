<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixture extends Fixture implements FixtureGroupInterface
{

    public function __construct(
        private UserPasswordHasherInterface $hasher)
    {
    }


    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 1; $i <= 20; $i++) {
            $user = new User();
            $user->setEmail($faker->email);
            $user->setPassword($this->hasher->hashPassword($user, 'user123'));
            $user->setRoles(['ROLE_USER']);
            $user->setNom($faker->lastName);
            $user->setPrenom($faker->firstName);

            $manager->persist($user);

        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['personne'];
    }
}
