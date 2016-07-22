<?php

namespace Vinci\Infrastructure\ERP\Order\Responses;

use Vinci\Infrastructure\ERP\Response;

class GetShippingAddressResponse extends Response
{

    private $addressId;

    public function __construct($raw, $addressId = null)
    {
        parent::__construct($raw);
        
        $this->addressId = $addressId;
    }

    public function getAddressId()
    {
        return $this->addressId;
    }

    public function wasSuccessfullyCreated()
    {
        return strpos($this->addressId, 'sucesso') !== false;
    }

}