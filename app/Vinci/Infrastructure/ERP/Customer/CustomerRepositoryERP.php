<?php

namespace Vinci\Infrastructure\ERP\Customer;

use Illuminate\Contracts\Config\Repository;
use Vinci\Domain\ERP\Customer\CustomerRepository;
use Vinci\Infrastructure\ERP\BaseERPRepository;

class CustomerRepositoryERP extends BaseERPRepository implements CustomerRepository
{
    public function __construct(Repository $config)
    {
        parent::__construct($config);
    }

    public function create(Customer $customer)
    {



    }
}