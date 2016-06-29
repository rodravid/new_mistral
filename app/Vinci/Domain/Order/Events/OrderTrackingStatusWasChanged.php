<?php

namespace Vinci\Domain\Order\Events;

use Vinci\Domain\Admin\Admin;
use Vinci\Domain\Common\Event\Event;
use Vinci\Domain\Common\Event\FiredByAdminUser;
use Vinci\Domain\Order\OrderInterface;

class OrderTrackingStatusWasChanged extends Event implements FiredByAdminUser
{

    private $order;

    private $oldStatus;

    private $user;

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

    public function getUser()
    {
        return $this->user;
    }

    public function setUser(Admin $user)
    {
        $this->user = $user;
    }

}