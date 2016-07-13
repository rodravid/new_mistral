<?php

namespace Vinci\App\Integration\ERP\Customer;

use Exception;
use Log;
use Vinci\Domain\Customer\CustomerInterface;
use Vinci\Domain\ERP\Customer\CustomerService;
use Vinci\Domain\ERP\Customer\CustomerTranslator;

class CustomerExporter
{

    private $customerService;

    private $customerTranslator;

    public function __construct(CustomerService $customerService, CustomerTranslator $customerTranslator)
    {
        $this->customerService = $customerService;
        $this->customerTranslator = $customerTranslator;
    }

    public function export(CustomerInterface $localCustomer)
    {
        try {

            $customer = $this->customerTranslator->translate($localCustomer);

            $this->customerService->create($customer);

        } catch (Exception $e) {

            $this->log($e, $localCustomer);

            throw $e;
        }
    }

    private function log(Exception $e, CustomerInterface $localCustomer)
    {
        Log::error(sprintf('Error during export customer #%s: %s', $localCustomer->getId(), $e->getMessage()));
    }

}