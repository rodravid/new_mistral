<?php

namespace Vinci\Domain\ERP\Order\Commands;

use Vinci\Domain\Order\Item\OrderItem;

class CreateOrderItemCommand
{

    private $item;

    private $userActor;

    private $silent;

    public function __construct(OrderItem $item, $userActor = null, $silent = false)
    {
        $this->item = $item;

        if (empty($userActor)) {
            $userActor = $this->getDefaultUserActor();
        }

        $this->userActor = $userActor;
        $this->silent = $silent;
    }

    public function getItem()
    {
        return $this->item;
    }

    public function getUserActor()
    {
        return $this->userActor;
    }

    protected function getDefaultUserActor()
    {
        return 'Sistema';
    }

    public function isSilent()
    {
        return $this->silent;
    }

}