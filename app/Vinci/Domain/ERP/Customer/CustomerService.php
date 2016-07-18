<?php

namespace Vinci\Domain\ERP\Customer;

use Exception;
use Vinci\Domain\ERP\BaseErpService;
use Vinci\Domain\ERP\Customer\Commands\CustomerCreateCommand;
use Vinci\Domain\ERP\Customer\Events\CustomerSaveOnErpFailed;
use Vinci\Domain\ERP\Customer\Events\CustomerWasSavedOnErp;
use Vinci\Domain\ERP\Exceptions\ErpException;
use Vinci\Infrastructure\ERP\EnvelopeFactory;
use Illuminate\Contracts\Events\Dispatcher;

class CustomerService extends BaseErpService
{

    private $customerRepository;

    public function __construct(
        EnvelopeFactory $envelopeFactory,
        Dispatcher $dispatcher,
        CustomerRepository $customerRepository
    ) {
        parent::__construct($envelopeFactory, $dispatcher);

        $this->customerRepository = $customerRepository;
    }

    public function create(CustomerCreateCommand $command)
    {
        try {

            $customer = $command->getCustomer();

            $request = $this->envelopeFactory->make($command->getCustomer(), 'create');
            
            $response = $this->customerRepository->create($customer);

            if ($response->wasSuccessfullyCreated()) {

                $this->eventDispatcher->fire(
                    new CustomerWasSavedOnErp($customer, $request, $response, $command->getUserActor())
                );

                return $response;
            }

            throw new ErpException('Error when saving customer on erp.', $response);

        } catch (Exception $e) {

            $response = $e instanceof ErpException ? $e->getResponse()->getRaw() : '';

            $request = isset($request) ? : '';

            $this->eventDispatcher->fire(
                new CustomerSaveOnErpFailed($customer, $request, $response, $command->getUserActor(), $e)
            );

            throw $e;
        }
    }

}