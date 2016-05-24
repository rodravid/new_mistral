<?php

namespace Vinci\Domain\Order\Events;

use Vinci\Domain\Common\Event\Event;
use Vinci\Domain\Order\OrderInterface;

class NewOrderWasCreated extends Event
{
    public $order;

    public function __construct(OrderInterface $order)
    {
        $this->order = $order;
    }

}