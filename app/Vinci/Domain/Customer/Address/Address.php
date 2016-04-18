<?php

namespace Vinci\Domain\Customer\Address;

use Doctrine\ORM\Mapping as ORM;
use Vinci\Domain\Address\Address as BaseAddress;

/**
 * @ORM\Entity
 * @ORM\Table(name="customers_addresses")
 */
class Address extends BaseAddress
{

    /**
     * @ORM\ManyToOne(targetEntity="Vinci\Domain\Customer\Customer", inversedBy="addresses")
     */
    protected $customer;

}