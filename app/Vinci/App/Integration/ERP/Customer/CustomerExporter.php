<?php

namespace Vinci\App\Integration\ERP\Customer;

use Exception;
use Illuminate\Events\Dispatcher;
use Vinci\App\Integration\Exceptions\IntegrationException;
use Vinci\Domain\Customer\CustomerInterface;
use Vinci\Domain\ERP\Customer\Commands\CustomerCreateCommand;
use Vinci\Domain\ERP\Customer\Commands\SaveCustomerCommand;
use Vinci\Domain\ERP\Customer\CustomerService;

class CustomerExporter
{

    private $customerService;

    private $eventDispatcher;

    public function __construct(
        CustomerService $customerService,
        Dispatcher $eventDispatcher
    ) {
        $this->customerService = $customerService;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function export(CustomerInterface $localCustomer)
    {
        try {

            $command = new SaveCustomerCommand($localCustomer);

            $this->customerService->save($command);

        } catch (Exception $e) {
            throw new IntegrationException($e->getMessage());
        }
    }

}