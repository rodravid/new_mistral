<?php

namespace Vinci\Domain\ERP\Order\Shipping;

use Spatie\Fractal\Fractal;
use Vinci\Domain\ERP\Address\Address as ErpAddress;
use Vinci\Domain\Order\Address\Address;

class AddressTranslator
{

    protected $fractal;

    public function __construct(Fractal $fractal)
    {
        $this->fractal = $fractal;
    }

    public function translate(Address $localAddress)
    {
        $address = new ErpAddress();

        $attributes = $this->getAttributesFrom($localAddress);

        $address->fill($attributes);

        return $address;
    }

    public function getAttributesFrom(Address $localAddress)
    {
        return $this->fractal
            ->item($localAddress)
            ->transformWith(new AddressTransformer)
            ->toArray();
    }

}