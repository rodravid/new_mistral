<?php

namespace Vinci\Domain\Order;

use Vinci\App\Core\Contracts\RepositoryInterface;
use Vinci\Domain\Common\Model\DateRange;

interface OrderRepository extends RepositoryInterface
{

    public function getOneById($id);

    public function getOneByNumber($number);

    public function getByCustomer($customerId, $perPage = 5, $pageName = 'page');

    public function countOrdersByPeriod(DateRange $dateRange);

    public function countPaidOrdersByPeriod(DateRange $dateRange);

    public function countWaitingPaymentOrdersByPeriod(DateRange $dateRange);

    public function countCompletedOrdersByPeriod(DateRange $dateRange);

}