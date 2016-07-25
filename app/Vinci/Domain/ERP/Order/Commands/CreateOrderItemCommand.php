<?php

namespace Vinci\Domain\ERP\Order\Commands;

use Vinci\Domain\ERP\BaseErpCommand;
use Vinci\Domain\Order\Item\OrderItem;

class CreateOrderItemCommand extends BaseErpCommand
{

    private $item;

    public function __construct(OrderItem $item, $userActor = null, $silent = false)
    {
        parent::__construct($userActor, $silent);

        $this->item = $item;
    }

    public function getItem()
    {
        return $this->item;
    }

}