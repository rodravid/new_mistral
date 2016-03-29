<?php

namespace Vinci\Domain\Order;

use Vinci\App\Core\Contracts\RepositoryInterface;

interface OrderRepository extends RepositoryInterface
{

    public function getByCustomer($customerId);

}