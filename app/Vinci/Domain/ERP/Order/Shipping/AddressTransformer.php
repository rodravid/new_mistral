<?php

namespace Vinci\Domain\ERP\Order\Shipping;

use Vinci\Domain\Address\Address;
use Vinci\Domain\ERP\Address\AddressTransformer as BaseAddressTransformer;
use Vinci\Domain\ERP\Customer\Phone\PhoneTransformer;

class AddressTransformer extends BaseAddressTransformer
{

    protected $defaultIncludes = [
        'phone'
    ];

    public function transform(Address $address)
    {
        return array_merge(parent::transform($address), [
            'customer_name' => $address->getOrder()->getCustomer()->getName(),
            'customer_email' => $address->getOrder()->getCustomer()->getEmail(),
            'customer_document' => $address->getOrder()->getCustomer()->getDocument(),
        ]);
    }

    public function includePhone(Address $address)
    {
        return $this->item($address->getOrder()->getCustomer()->getPhone(), new PhoneTransformer);
    }

}