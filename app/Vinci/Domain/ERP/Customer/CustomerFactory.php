<?php

namespace Vinci\Domain\ERP\Customer;

class CustomerFactory
{

    public function getNewInstance()
    {
        return new Customer;
    }

}