<?php

namespace Vinci\Infrastructure\ERP\Customer;

use Vinci\Domain\ERP\Customer\Customer;
use Vinci\Domain\ERP\Customer\CustomerRepository;
use Vinci\Infrastructure\ERP\BaseHttpErpRepository;
use Vinci\Infrastructure\ERP\Customer\Responses\Parsers\CreateCustomerResponseParser;

class CustomerRepositoryERP extends BaseHttpErpRepository implements CustomerRepository
{

    public function create(Customer $customer)
    {
        return $this->erpRequest(
            $this->config->get('erp.wsdl.customers.create_customer'),
            $this->envelopeFactory->make($customer, 'create'),
            CreateCustomerResponseParser::class
        );
    }

}