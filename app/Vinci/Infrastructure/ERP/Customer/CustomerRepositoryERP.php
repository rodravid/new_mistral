<?php

namespace Vinci\Infrastructure\ERP\Customer;

use Illuminate\Contracts\Config\Repository;
use Spatie\Fractal\Fractal;
use Vinci\Domain\ERP\Customer\Customer;
use Vinci\Domain\ERP\Customer\CustomerErpTransformer;
use Vinci\Domain\ERP\Customer\CustomerRepository;
use Vinci\Infrastructure\ERP\BaseERPRepository;

class CustomerRepositoryERP extends BaseERPRepository implements CustomerRepository
{

    protected $fractal;

    public function __construct(Repository $config, Fractal $fractal)
    {
        parent::__construct($config);

        $this->fractal = $fractal;
    }

    public function create(Customer $customer)
    {
        try {

            $client = $this->buildClient('customers.create_customer');

            $response = $client->call('CRIAPESSOA', [
                'CRIAPESSOAInput' => $this->getCustomerInput($customer)
            ]);

            $customerId = $this->parseResponse($response);

            dd($customerId);

            return trim($customerId);

        } catch (Exception $e) {
            throw $e;
        }
    }

    protected function getCustomerInput(Customer $customer)
    {
        return $this->fractal
            ->item($customer)
            ->transformWith(new CustomerErpTransformer)
            ->toArray();
    }

    protected function parseResponse($response, $includeRoot = false)
    {
        return (string) $response->PMSG;
    }

}