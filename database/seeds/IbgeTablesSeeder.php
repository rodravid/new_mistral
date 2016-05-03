<?php

use Doctrine\ORM\EntityManager;
use Illuminate\Database\Seeder;
use Vinci\Domain\Address\City\City;
use Vinci\Domain\Address\Country\Country;
use Vinci\Domain\Address\PublicPlace;
use Vinci\Domain\Address\State\State;

class IbgeTablesSeeder extends Seeder
{

    private $em;

    public function __construct(
        EntityManager $em
    )
    {
        $this->em = $em;
    }

    public function run()
    {

        $publicPlace = new PublicPlace;

        $publicPlace->setTitle('Rua');

        $country = new Country;
        $country->setId(1)
            ->setName('Brasil')
            ->setInitials('BR');

        $state1 = new State;
        $state1->setId(35)
            ->setName('São Paulo')
            ->setUf('SP');

        $state2 = new State;
        $state2->setId(33)
            ->setName('Rio de Janeiro')
            ->setUf('RJ');

        $city1 = new City;
        $city1->setId(3507605)
            ->setName('Bragança Paulista');

        $city2 = new City;
        $city2->setId(3301702)
            ->setName('Duque de caxias');

        $state1->addCity($city1);
        $state2->addCity($city2);

        $country->addState($state1);
        $country->addState($state2);

        $this->em->persist($publicPlace);
        $this->em->persist($country);
        $this->em->persist($state1);
        $this->em->persist($state2);
        $this->em->persist($city1);
        $this->em->persist($city2);

        $this->em->flush();
        $this->em->clear();

    }
}