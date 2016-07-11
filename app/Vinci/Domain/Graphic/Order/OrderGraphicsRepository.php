<?php

namespace Vinci\Domain\Graphic\Order;


interface OrderGraphicsRepository
{

    public function countAllByPeriod($startAt, $endAt);

    public function countPaidByPeriod($startAt, $endAt);

}