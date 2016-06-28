<?php

namespace Vinci\Domain\Order\Events;

use Vinci\Domain\Common\Event\Event;
use Vinci\Domain\Order\OrderInterface;

class OrderTrackingStatusWasChanged extends Event
{

    private $order;

    private $oldStatus;

    public function __construct(OrderInterface $order, $oldStatus)
    {
        $this->order = $order;
        $this->oldStatus = $oldStatus;
    }

    public function getOrder()
    {
        return $this->order;
    }

    public function getOldStatus()
    {
        return $this->oldStatus;
    }

}