<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Batiments;
use App\Entity\Users;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $bat1 = new Batiments();
        $bat1->setAdresse('789 Oak St');
        $bat1->setAgence('Agence A');
        $manager->persist($bat1);

        $hanan = new Users();
        $hanan->setName('ashrafi');
        $hanan->setPrenom('hanan');
        $hanan->setEmail('hanan@example.com');
        $hanan->setAdresse('123 Main St');
        $hanan->setPersonnes($bat1);
        $manager->persist($hanan);

        $john = new Users();
        $john->setName('doe');
        $john->setPrenom('john');
        $john->setEmail('john@example.com');
        $john->setAdresse('456 Elm St');
        $john->setPersonnes($bat1);
        $manager->persist($john);

        $manager->flush();
    }
}
