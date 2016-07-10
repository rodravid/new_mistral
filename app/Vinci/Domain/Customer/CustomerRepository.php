<?php

namespace Vinci\Domain\Customer;

use Vinci\Domain\User\UserRepository;

interface CustomerRepository extends UserRepository
{

    public function findByDocument($document);

}