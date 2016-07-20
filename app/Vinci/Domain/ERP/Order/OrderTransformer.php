<?php

namespace Vinci\Domain\ERP\Order;

use Vinci\Domain\Order\OrderInterface;
use Vinci\Domain\ERP\Transformer\BaseTransformer;

class OrderTransformer extends BaseTransformer
{

    public function transform(OrderInterface $order)
    {
        return [
            'document' => $order->getCustomer()->getDocument(),
            'id' => $order->getId(),
            'number' => $order->getNumber(),
            'person_type' => $order->getCustomer()->isIndividual() ? 'F' : 'J',
            'payment_condition' => $this->getPaymentCondition($order),
            'estimated_delivery_date' => $order->getEstimatedDeliveryDate()->format('d/M/Y'),
            'carrier_id' => $order->getShipment()->getCarrier()->getCode(),
            'shipping_value' => $order->getShipment()->getAmount(),
            'obs' => $this->getObs($order),
            'created_at' => $order->getCreatedAt()->format('d/M/Y'),
            'erp_shipping_address' => '', //Setado quando atualizado o endereço de entrega no erp
            'filial' => 6,
        ];
    }

    public function getPaymentCondition(OrderInterface $order)
    {
        $payment = $order->getPayment();

        if ($payment->wasMadeWithBankDeposit()) {
            return 'DEP';
        }

        return $payment->getInstallments() == 1 ?
            'CV' : sprintf('C%sX', $payment->getInstallments());
    }

    private function getObs(OrderInterface $order)
    {
        $phone = ! empty($order->getCustomer()->getPhone()) ?
            sprintf(' - TEL %s', $order->getCustomer()->getPhone()) : '';

        $landmark = ! empty($order->getShippingAddress()->getLandmark()) ?
            sprintf(' - REF. ENTREGA: %s', $order->getShippingAddress()->getLandmark()) : '';

        return $this->normalizeString(sprintf(
            "SITE %s - TRANSPORTADORA %s%s - CONSUMIDOR FINAL%s",
            $order->getNumber(),
            $order->getShipment()->getCarrier()->getTitle(),
            $phone,
            $landmark
        ));
    }

}