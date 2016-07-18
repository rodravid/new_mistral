<?php

namespace Vinci\App\Integration\ERP\Customer;

use Exception;
use Illuminate\Events\Dispatcher;
use Log;
use Vinci\App\Integration\Exceptions\IntegrationException;
use Vinci\Domain\Customer\CustomerInterface;
use Vinci\Domain\ERP\Customer\Commands\CustomerCreateCommand;
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

            $command = new CustomerCreateCommand($customer);

            $this->customerService->create($command);

        } catch (Exception $e) {
            throw new IntegrationException($e->getMessage());
        }
    }

}