<?php

namespace Vinci\Domain\Order\Strategy;

use Vinci\Domain\Order\Creation\Steps\ValidateCreditCardData;
use Vinci\Domain\Order\OrderCreationStrategy;
use Vinci\Domain\Order\Creation\Steps\CollectOrderItems;
use Vinci\Domain\Order\Creation\Steps\MakeOrderInstance;
use Vinci\Domain\Order\Creation\Steps\MakeOrderPayment;
use Vinci\Domain\Order\Creation\Steps\MakeOrderShipment;
use Vinci\Domain\Order\Creation\Steps\SendOrderObjectToService;
use Vinci\Domain\Order\Creation\Steps\SetOrderTrackingStatus;
use Vinci\Domain\Order\Creation\Steps\ValidateRequest;

class CreditCardOrderCreationStrategy extends PipelineBasedOrderCreationStrategy implements OrderCreationStrategy
{

    protected $steps = [
        ValidateRequest::class,
        ValidateCreditCardData::class,
        MakeOrderInstance::class,
        SetOrderTrackingStatus::class,
        CollectOrderItems::class,
        MakeOrderShipment::class,
        MakeOrderPayment::class,
        SendOrderObjectToService::class
    ];

}