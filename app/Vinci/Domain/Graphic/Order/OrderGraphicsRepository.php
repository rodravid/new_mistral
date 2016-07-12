<?php

namespace Vinci\Domain\Graphic\Order;


use Vinci\Domain\Common\Model\DateRange;

interface OrderGraphicsRepository
{

    public function countAllByPeriod(DateRange $dateRange);

    public function countPaidByPeriod(DateRange $dateRange);

}