<?php

namespace Vinci\Domain\User\Customer;

use Vinci\Domain\User\UserRepository;

interface CustomerRepository extends UserRepository
{

    public function createProfile(array $attributes, $customerId);

    public function updateProfile(array $attributes, $customerId);

}