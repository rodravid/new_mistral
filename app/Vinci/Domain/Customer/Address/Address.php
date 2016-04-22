<?php

namespace Vinci\Domain\Customer\Address;

use Doctrine\ORM\Mapping as ORM;
use Robbo\Presenter\PresentableInterface;
use Robbo\Presenter\Robbo;
use Vinci\Domain\Address\Address as BaseAddress;
use Vinci\Domain\Customer\Customer;

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

    protected $presenter;

    /**
     * @ORM\Column(name="main_address", type="boolean", options={"default" = 0})
     */
    protected $mainAddress = false;

    public function getCustomer()
    {
        return $this->customer;
    }

    public function setCustomer(Customer $customer)
    {
        $this->customer = $customer;
        return $this;
    }

    public function getMainAddress()
    {
        return $this->mainAddress;
    }

    public function setMainAddress($mainAddress)
    {
        $this->mainAddress = $mainAddress;
        return $this;
    }

    public function getPresenter()
    {
        if (is_null($this->presenter)) {
            $this->presenter = new AddressPresenter($this);
        }

        return $this->presenter;
    }

    public function isMainAddress()
    {
        return !! $this->mainAddress;
    }
}