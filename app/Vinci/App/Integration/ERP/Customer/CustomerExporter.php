<?php

namespace Vinci\App\Integration\ERP\Customer;

use Exception;
use Illuminate\Bus\Dispatcher as CommandDispatcher;
use Illuminate\Contracts\Config\Repository;
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

    private $config;

    public function __construct(
        CustomerService $customerService,
        CustomerRepository $customerRepository,
        CommandDispatcher $commandDispatcher,
        Repository $config
    ) {
        $this->customerService = $customerService;
        $this->customerRepository = $customerRepository;
        $this->commandDispatcher = $commandDispatcher;
        $this->config = $config;
    }

    public function export(CustomerInterface $localCustomer, $user = 'Sistema')
    {
        try {

            $command = new SaveCustomerCommand($localCustomer, $user);

            $this->customerService->save($command);

        } catch (Exception $e) {
            throw new IntegrationException($e->getMessage());
            
        } finally {
            app('em')->clear();
        }
    }

    public function exportQueued(CustomerInterface $customer)
    {
        $customer->changeErpIntegrationStatus(IntegrationStatus::PENDING);

        $this->customerRepository->save($customer);

        $this->commandDispatcher->dispatch(
            (new ExportCustomerToErp($customer->getId()))
                ->onQueue($this->config->get('queue.customers-integration'))
        );
    }

}