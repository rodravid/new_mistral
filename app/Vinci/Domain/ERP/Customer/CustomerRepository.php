<?php

namespace Vinci\Domain\ERP\Customer;

interface CustomerRepository
{
    public function create(Customer $customer);
}