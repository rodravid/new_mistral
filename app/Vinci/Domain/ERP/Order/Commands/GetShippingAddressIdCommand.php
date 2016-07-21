<?php

namespace Vinci\Domain\ERP\Order\Commands;

use Vinci\Domain\ERP\BaseErpCommand;
use Vinci\Domain\Order\Address\Address;

class GetShippingAddressIdCommand extends BaseErpCommand
{

    private $address;

    public function __construct(Address $address, $userActor = null, $silent = false)
    {
        parent::__construct($userActor, $silent);
        
        $this->address = $address;
    }

    public function getAddress()
    {
        return $this->address;
    }

}