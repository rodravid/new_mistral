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

        $state = new State;
        $state->setId(1)
            ->setName('São Paulo')
            ->setUf('SP');

        $city = new City;
        $city->setId(1)
            ->setName('Bragança Paulista');

        $state->addCity($city);
        $country->addState($state);

        $this->em->persist($publicPlace);
        $this->em->persist($country);
        $this->em->persist($state);
        $this->em->persist($city);

        $this->em->flush();
        $this->em->clear();

    }
}