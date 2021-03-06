<?php

namespace Vinci\Domain\ShoppingCart\Repositories;

use Vinci\Domain\Customer\CustomerInterface;

interface ShoppingCartRepository
{

    public function find($id);

    public function findLastOfCustomer(CustomerInterface $customer);

    public function getAllByCustomer(CustomerInterface $customer);

}