<?php

namespace Vinci\Domain\ERP\Order\Item;

use Vinci\Domain\ERP\Transformer\BaseTransformer;

class ItemErpTransformer extends BaseTransformer
{

    public function transform(Item $item)
    {
        return [
            'PCODMATERIAL-VARCHAR2-IN' => $item->sku,
            'PCODUNIDADE-VARCHAR2-IN' => 'UN',
            'PIDPEDIDO-NUMBER-IN' => $item->order_number,
            'PPCTDESCONTO-NUMBER-IN' => $item->discount_percent,
            'PQTD-NUMBER-IN' => $item->quantity,
            'PVLRDESCONTO-NUMBER-IN' => $item->discount,
            'PVLRUNITREAIS-NUMBER-IN' => $item->price,
            'PVMSG-VARCHAR2-OUT' => ''
        ];
    }

}