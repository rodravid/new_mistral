<?php

namespace Vinci\Domain\ERP\Customer;

use Vinci\Infrastructure\ERP\Customer\Customer;

interface CustomerRepository
{

    public function create(Customer $customer);

}