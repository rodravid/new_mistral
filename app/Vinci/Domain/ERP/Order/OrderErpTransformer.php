<?php

namespace Vinci\Domain\ERP\Order;

use Vinci\Domain\ERP\Transformer\BaseTransformer;

class OrderErpTransformer extends BaseTransformer
{

    public function transform(Order $order)
    {
        return [
            'PAPELIDOREPRES-VARCHAR2-IN' => 'MV NET FILIAL',
            'PCNPJCPFCLIENTE-VARCHAR2-IN' => $order->document,
            'PCODCONDPGTO-VARCHAR2-IN' => $order->payment_condition,
            'PCODLISTAPRECO-VARCHAR2-IN' => config('erp.products_price_list'),
            'PCODTIPOFAT-VARCHAR2-IN' => 'VEN',
            'PCODTIPOPESSOA-VARCHAR2-IN' => $order->person_type,
            'PCONTATO-VARCHAR2-IN' => '',
            'PDTENTREGA-DATE-IN' => $order->estimated_delivery_date,
            'PDTPEDIDO-DATE-IN' => $order->created_at,
            'PIDENDENTREGA-NUMBER-IN' => $order->erp_shipping_address,
            'PIDFILIAL-NUMBER-IN' => $order->filial,
            'PIDTRANSPORTADORA-NUMBER-IN' => $order->carrier_id,
            'PNUMPEDIDOCLI-VARCHAR2-IN' => $order->number,
            'POBS-VARCHAR2-IN' => $order->obs,
            'PVLRFRETE-NUMBER-IN' => $order->shipping_value,
            'PIDPED-NUMBER-OUT' => '',
            'PVMSG-VARCHAR2-OUT' => ''
        ];
    }

}