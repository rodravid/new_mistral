<?php

namespace Vinci\Infrastructure\Users;

use Illuminate\Contracts\Auth\UserProvider;
use Vinci\Domain\User\Customer\Customer;
use Vinci\Domain\User\Customer\CustomerRepository;
use Vinci\Infrastructure\Users\Criteria\CustomerCriteria;

class EloquentCustomerRepository extends EloquentUserRepository implements
    CustomerRepository,
    UserProvider
{

    public function boot()
    {
        $this->pushCriteria(new CustomerCriteria);
    }

    public function model()
    {
        return Customer::class;
    }

    public function createProfile(array $attributes, $customerId)
    {
        $customer = $this->skipCriteria()->find($customerId);

        return $customer->profile()->create($attributes);
    }

    public function updateProfile(array $attributes, $customerId)
    {
        $customer = $this->find($customerId);

        return $customer->profile()->update($attributes);
    }

}