<?php

namespace Vinci\Domain\ERP\Customer;

use Exception;

class CustomerService
{

    private $customerRepository;

    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function create(Customer $customer)
    {
        try {

            $this->customerRepository->create($customer);

        } catch (Exception $e) {
            throw $e;
        }
    }

}