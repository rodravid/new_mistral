<?php

namespace Vinci\App\Integration\ERP\Customer;

use Exception;
use Vinci\Domain\Customer\CustomerInterface;
use Vinci\Domain\ERP\Customer\CustomerRepository;

class CustomerExporter
{
    private $repository;

    public function __construct(CustomerRepository $repository)
    {
        $this->repository = $repository;
    }

    public function export(CustomerInterface $customer)
    {


        $this->repository->create;

    }

}