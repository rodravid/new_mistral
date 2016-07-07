<?php

namespace Vinci\Domain\Order;

use Vinci\App\Core\Contracts\RepositoryInterface;

interface OrderRepository extends RepositoryInterface
{

    public function getOneById($id);

    public function getOneByNumber($number);

    public function getByCustomer($customerId, $perPage = 5, $pageName = 'page');

    public function getByPeriod($dateStart, $dateStop);

}