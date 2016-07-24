<?php

namespace Vinci\App\Integration\ERP\Customer;

use Vinci\App\Integration\ERP\Logger\IntegrationLogger;
use Vinci\Domain\Customer\CustomerRepository;

class CustomerIntegrationLogger extends IntegrationLogger
{

    protected $table = 'customers_integration_logs';

    protected $customer;

    public function getResourceTypeAttribute()
    {
        return 'customer';
    }

    public function getCustomer()
    {
        if (! is_null($this->customer)) {
            return $this->customer;
        }

        return $this->customer = app(CustomerRepository::class)->findOrFail($this->resource_id);
    }

}