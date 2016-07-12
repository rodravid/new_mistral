<?php

namespace Vinci\Domain\ERP\Customer;

use Spatie\Fractal\Fractal;
use Vinci\Domain\Customer\CustomerInterface;

class CustomerTranslator
{

    protected $customerFactory;

    protected $fractal;

    public function __construct(CustomerFactory $customerFactory, Fractal $fractal)
    {
        $this->customerFactory = $customerFactory;
        $this->fractal = $fractal;
    }

    public function translate(CustomerInterface $localCustomer)
    {
        $customer = $this->customerFactory->getNewInstance();

        $attributes = $this->getAttributesFrom($localCustomer);

        $customer->fill($attributes);

        dd($customer);

        return $customer;
    }

    public function getAttributesFrom(CustomerInterface $localCustomer)
    {
        return $this->fractal
            ->item($localCustomer)
            ->transformWith(new CustomerTransformer)
            ->toArray();
    }

}