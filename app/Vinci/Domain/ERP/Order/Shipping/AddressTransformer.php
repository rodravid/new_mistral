<?php

namespace Vinci\Domain\ERP\Order\Shipping;

use Vinci\Domain\Address\Address;
use Vinci\Domain\ERP\Address\AddressTransformer as BaseAddressTransformer;

class AddressTransformer extends BaseAddressTransformer
{

    public function transform(Address $address)
    {
        $data = parent::transform($address);

        dd($data);

    }

}