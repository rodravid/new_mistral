<?php

namespace Vinci\App\Integration\ERP\Customer;

use Exception;
use Illuminate\Bus\Dispatcher as CommandDispatcher;
use Vinci\App\Integration\ERP\Customer\Jobs\ExportCustomerToErp;
use Vinci\App\Integration\Exceptions\IntegrationException;
use Vinci\Domain\Common\IntegrationStatus;
use Vinci\Domain\Customer\CustomerInterface;
use Vinci\Domain\Customer\CustomerRepository;
use Vinci\Domain\ERP\Customer\Commands\SaveCustomerCommand;
use Vinci\Domain\ERP\Customer\CustomerService;

class CustomerExporter
{

    private $customerService;

    private $customerRepository;

    private $commandDispatcher;

    public function __construct(
        CustomerService $customerService,
        CustomerRepository $customerRepository,
        CommandDispatcher $commandDispatcher
    ) {
        $this->customerService = $customerService;
        $this->customerRepository = $customerRepository;
        $this->commandDispatcher = $commandDispatcher;
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

    public function exportQueued(CustomerInterface $customer)
    {
        $customer->changeErpIntegrationStatus(IntegrationStatus::PENDING);

        $this->customerRepository->save($customer);

        $this->commandDispatcher->dispatch(
            (new ExportCustomerToErp($customer->getId()))
                ->onQueue('vinci-integration-customers')
        );
    }

}