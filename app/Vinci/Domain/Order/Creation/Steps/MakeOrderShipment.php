<?php

namespace Vinci\Domain\Order\Creation\Steps;

use Vinci\Domain\Address\PostalCode;
use Vinci\Domain\Shipping\Services\ShippingService;
use Vinci\Domain\Shipping\Shipment;

class MakeOrderShipment
{
    private $shippingService;

    public function __construct(ShippingService $shippingService)
    {
        $this->shippingService = $shippingService;
    }

    public function handle($data, $next)
    {
        $order = $data['order'];

        $postalCode = new PostalCode($order->getShippingAddress()->getPostalCode());

        $shippingOption = $this->shippingService->getShippingByLowestPrice($postalCode, $order);

        $shipment = new Shipment;

        $shipment
            ->setCarrier($shippingOption->getCarrier())
            ->setDeadline($shippingOption->getDeadline())
            ->setAmount($shippingOption->getPrice());

        $order->setShipment($shipment);

        return $next($data);
    }

}