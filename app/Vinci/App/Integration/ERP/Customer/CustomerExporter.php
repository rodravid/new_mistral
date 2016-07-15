<?php

namespace Vinci\App\Integration\ERP\Customer;

use Exception;
use Illuminate\Events\Dispatcher;
use Log;
use Vinci\Domain\Customer\CustomerInterface;
use Vinci\Domain\ERP\Customer\CustomerService;
use Vinci\Domain\ERP\Customer\CustomerTranslator;

class CustomerExporter
{

    private $customerService;

    private $customerTranslator;

    private $eventDispatcher;

    public function __construct(
        CustomerService $customerService,
        CustomerTranslator $customerTranslator,
        Dispatcher $eventDispatcher
    ) {
        $this->customerService = $customerService;
        $this->customerTranslator = $customerTranslator;
        $this->eventDispatcher = $eventDispatcher;
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