<?php

namespace Vinci\Domain\Address;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Vinci\Domain\Address\City\City;

abstract class AbstractAddressFactory
{

    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    protected abstract function
    getNewAddressInstance($id = null);

    public function makeFromArray(array $addressData)
    {
        $address = $this->getNewAddressInstance($addressData['id']);

        $address->setType($this->getAddressType($addressData['type']))
                ->setPublicPlace($this->getPublicPlace($addressData['public_place']))
                ->setCity($this->getCity($addressData['city']))
                ->setNickname(array_get($addressData, 'nickname'))
                ->setPostalCode(array_get($addressData, 'postal_code'))
                ->setAddress(array_get($addressData, 'address'))
                ->setNumber(array_get($addressData, 'number'))
                ->setComplement(array_get($addressData, 'complement'))
                ->setDistrict(array_get($addressData, 'district'))
                ->setLandmark(array_get($addressData, 'landmark'))
                ->setReceiver(array_get($addressData, 'receiver'));

        return $address;
    }

    public function makeCollectionFromArray(array $addresses)
    {
        $addressesCollection = new ArrayCollection;

        foreach ($addresses as $address) {
            $addressesCollection->add($this->makeFromArray($address));
        }

        return $addressesCollection;
    }

    protected function getPublicPlace($id)
    {
        return $this->entityManager->getReference(PublicPlace::class, $id);
    }

    protected function getAddressType($id)
    {
        return new AddressType($id);
    }

    private function getCity($id)
    {
        return $this->entityManager->getReference(City::class, $id);
    }

}