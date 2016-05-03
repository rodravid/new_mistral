<?php

namespace Vinci\Domain\Customer\Address;

use Vinci\Domain\Address\AbstractAddressFactory;

class AddressFactory extends AbstractAddressFactory
{
    protected function getNewAddressInstance($id = null)
    {
        if (isset($id) && ! empty($id)) {
            return $this->entityManager->getReference(Address::class, $id);
        }

        return new Address;
    }
}