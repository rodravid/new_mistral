<?php

namespace Vinci\Domain\ERP\Address;

use Vinci\Domain\Address\Address as LocalAddress;
use Vinci\Domain\ERP\Transformer\BaseTransformer;

class AddressTransformer extends BaseTransformer
{

    public function transform(LocalAddress $address)
    {
        return [
            'id' => $address->getId(),
            'code' => $address->getCode(),
            'type' => $this->normalizeString($address->getType()->getTitle()),
            'integration_status' => $address->getErpIntegrationStatus(),
            'public_place' => $this->normalizeString($address->getPublicPlace()->getTitle()),
            'address' => $this->normalizeString($address->getAddress()),
            'number' => $this->normalizeString($address->getNumber()),
            'country' => $this->normalizeString($address->getCountry()->getName()),
            'country_code' => $address->getCountry()->getId(),
            'state' => $this->normalizeString($address->getState()->getName()),
            'state_code' => $address->getState()->getId(),
            'city' => $this->normalizeString($address->getCity()->getName()),
            'city_code' => $address->getCity()->getId(),
            'district' => $this->normalizeString($address->getDistrict()),
            'postal_code' => $address->getPostalCode(),
            'complement' => $this->normalizeString($address->getComplement())
        ];
    }

}