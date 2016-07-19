<?php

namespace Vinci\Domain\ERP\Order\Commands;

use Vinci\Domain\Order\OrderInterface;

class SaveOrderCommand
{

    private $order;

    private $userActor;

    public function __construct(OrderInterface $order, $userActor = null)
    {
        $this->order = $order;

        if (empty($userActor)) {
            $userActor = $this->getDefaultUserActor();
        }

        $this->userActor = $userActor;
    }

    public function getOrder()
    {
        return $this->order;
    }

    public function getUserActor()
    {
        return $this->userActor;
    }

    protected function getDefaultUserActor()
    {
        return 'Sistema';
    }

}