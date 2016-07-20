<?php

namespace Vinci\Domain\ERP\Customer;

use Vinci\Domain\ERP\Address\Address;
use Vinci\Domain\ERP\Customer\Phone\Phone;
use Vinci\Domain\ERP\Model;

class Customer extends Model
{

    public function setAddress($address)
    {
        if (is_array($address)) {
            $this->attributes['address'] = new Address($address);
            return $this;
        }

        $this->attributes['address'] = $address;
        return $this;
    }

    public function setPhone($phone)
    {
        if (is_array($phone)) {
            $this->attributes['phone'] = new Phone($phone);
            return $this;
        }

        $this->attributes['phone'] = $phone;
        return $this;
    }

    public function setCellPhone($phone)
    {
        if (is_array($phone)) {
            $this->attributes['cell_phone'] = new Phone($phone);
            return $this;
        }

        $this->attributes['cell_phone'] = $phone;
        return $this;
    }

    public function getLocalCustomerReference()
    {
        return $this->local_customer;
    }

}