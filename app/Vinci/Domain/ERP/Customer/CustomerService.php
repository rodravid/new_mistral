<?php

namespace Vinci\Domain\ERP\Customer;

use Exception;
use Vinci\Domain\ERP\BaseErpService;
use Vinci\Domain\ERP\Customer\Commands\SaveCustomerCommand;
use Vinci\Domain\ERP\Customer\Events\CustomerSaveOnErpFailed;
use Vinci\Domain\ERP\Customer\Events\CustomerWasSavedOnErp;
use Vinci\Domain\ERP\Exceptions\ErpException;
use Vinci\Infrastructure\ERP\EnvelopeFactory;
use Illuminate\Contracts\Events\Dispatcher;

class CustomerService extends BaseErpService
{

    private $customerRepository;

    private $customerTranslator;

    public function __construct(
        EnvelopeFactory $envelopeFactory,
        Dispatcher $dispatcher,
        CustomerRepository $customerRepository,
        CustomerTranslator $customerTranslator
    ) {
        parent::__construct($envelopeFactory, $dispatcher);

        $this->customerRepository = $customerRepository;
        $this->customerTranslator = $customerTranslator;
    }

    public function save(SaveCustomerCommand $command)
    {
        try {

            $customer = $this->customerTranslator->translate($command->getCustomer());

            $request = $this->envelopeFactory->make($customer, 'create');
            
            $response = $this->customerRepository->create($customer);

            if ($response && $response->wasSuccessfullyCreated()) {

                $this->eventDispatcher->fire(
                    new CustomerWasSavedOnErp($command, $request, $response->getRaw())
                );

                return $response;
            }

            throw new ErpException('Error when saving customer on erp.', $response);

        } catch (Exception $e) {

            $response = $e instanceof ErpException ? $e->getResponse()->getRaw() : '';

            $request = isset($request) ? $request : '';

            $this->eventDispatcher->fire(
                new CustomerSaveOnErpFailed($command, $request, $response, $e)
            );

            throw $e;
        }
    }

}