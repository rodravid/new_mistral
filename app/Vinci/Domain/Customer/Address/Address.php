<?php

namespace Vinci\Domain\Customer\Address;

use Doctrine\ORM\Mapping as ORM;
use Robbo\Presenter\PresentableInterface;
use Robbo\Presenter\Robbo;
use Vinci\Domain\Address\Address as BaseAddress;

/**
 * @ORM\Entity
 * @ORM\Table(name="customers_addresses")
 */
class Address extends BaseAddress implements PresentableInterface
{

    /**
     * @ORM\ManyToOne(targetEntity="Vinci\Domain\Customer\Customer", inversedBy="addresses")
     */
    protected $customer;

    public function getPresenter()
    {
        return new AddressPresenter($this);
    }
}