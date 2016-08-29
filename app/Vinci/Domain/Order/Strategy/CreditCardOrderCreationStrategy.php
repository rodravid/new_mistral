<?php

namespace Vinci\Domain\Order\Strategy;

use Vinci\Domain\Order\OrderCreationStrategy;

class CreditCardOrderCreationStrategy extends PipelineBasedOrderCreationStrategy implements OrderCreationStrategy
{

    protected $steps = [
        
    ];

}