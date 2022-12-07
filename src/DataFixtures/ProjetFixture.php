<?php

namespace App\DataFixtures;

use App\Entity\Projets;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ProjetFixture extends Fixture
{

    public function load(ObjectManager $manager): void
    {

        $faker = Factory::create('fr_FR');

        for ($i = 1; $i <= 20; $i++) {

            $projet = new Projets();
//            $projet->setIdUser();
            $projet->setNomProjet($faker->word);
            $projet->setMontantProjet($faker->numberBetween(200, 1000));
            $projet->setTempsProjet($faker->numberBetween(6, 10));

            $manager->persist($projet);
        }

        $manager->flush();
    }
}
