<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Country;
use App\Entity\City;


class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
         // France
        $france = new Country;
        $france->setName('France');

        $paris = new City;
        $paris->setName('Paris');
        $paris->setCountry($france);

        $marseille = new City;
        $marseille->setName('Marseille');
        $marseille->setCountry($france);

        $lyon = new City;
        $lyon->setName('Lyon');
        $lyon->setCountry($france);

        $manager->persist($france);
        $manager->persist($paris);
        $manager->persist($marseille);
        $manager->persist($lyon);

        // Canada
        $canada = new Country;
        $canada->setName('Canada');

        $quebec = new City;
        $quebec->setName('Québec');
        $quebec->setCountry($canada);

        $montreal = new City;
        $montreal->setName('Montréal');
        $montreal->setCountry($canada);

        $troisRivieres = new City;
        $troisRivieres->setName('Trois-Rivières');
        $troisRivieres->setCountry($canada);

        $manager->persist($canada);
        $manager->persist($quebec);
        $manager->persist($montreal);
        $manager->persist($troisRivieres);

        // Côte d'ivoire
        $coteDivoire = new Country;
        $coteDivoire->setName("Côte d'ivoire");

        $abidjan = new City;
        $abidjan->setName('Abidjan');
        $abidjan->setCountry($coteDivoire);

        $yamoussoukro = new City;
        $yamoussoukro->setName('Yamoussoukro');
        $yamoussoukro->setCountry($coteDivoire);

        $bouake = new City;
        $bouake->setName('Bouaké');
        $bouake->setCountry($coteDivoire);

        $manager->persist($coteDivoire);
        $manager->persist($abidjan);
        $manager->persist($yamoussoukro);
        $manager->persist($bouake);

        $manager->flush();
    }
    //you perform symfony console doctrine:fixtures:load to add changes in the db 
    //persist() tells doctrine to save this entity but not excute sql statements 
    // flush() execute sql statement 
}
