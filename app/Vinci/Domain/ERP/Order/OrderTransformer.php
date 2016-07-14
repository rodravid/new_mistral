<?php

namespace Vinci\Domain\ERP\Order;

use Vinci\Domain\Order\OrderInterface;
use Vinci\Domain\ERP\Transformer\BaseTransformer;

class OrderTransformer extends BaseTransformer
{

    public function transform(OrderInterface $order)
    {
        return [

        ];
    }

}