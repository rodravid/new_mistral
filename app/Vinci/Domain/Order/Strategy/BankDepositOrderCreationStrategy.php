<?php

namespace Vinci\Domain\Order\Strategy;

use Vinci\Domain\Order\Creation\Steps\CollectOrderItems;
use Vinci\Domain\Order\Creation\Steps\MakeOrderInstance;
use Vinci\Domain\Order\Creation\Steps\MakeOrderPayment;
use Vinci\Domain\Order\Creation\Steps\MakeOrderShipment;
use Vinci\Domain\Order\Creation\Steps\SendOrderObjectToService;
use Vinci\Domain\Order\Creation\Steps\SetOrderTrackingStatus;
use Vinci\Domain\Order\Creation\Steps\ValidateBankDepositData;
use Vinci\Domain\Order\Creation\Steps\ValidateRequest;
use Vinci\Domain\Order\OrderCreationStrategy;

class BankDepositOrderCreationStrategy extends PipelineBasedOrderCreationStrategy implements OrderCreationStrategy
{

    protected $steps = [
        ValidateRequest::class,
        ValidateBankDepositData::class,
        MakeOrderInstance::class,
        SetOrderTrackingStatus::class,
        CollectOrderItems::class,
        MakeOrderShipment::class,
        MakeOrderPayment::class,
        SendOrderObjectToService::class
    ];

}