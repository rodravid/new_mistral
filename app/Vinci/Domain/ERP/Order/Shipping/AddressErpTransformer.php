<?php

namespace Vinci\Domain\ERP\Order\Shipping;

use Vinci\Domain\ERP\Address\Address;
use Vinci\Domain\ERP\Transformer\BaseTransformer;

class AddressErpTransformer extends BaseTransformer
{

    public function transform(Address $address)
    {
        return [
            'PBAIRRO-VARCHAR2-IN' => $address->district,
            'PCEP-VARCHAR2-IN' => $address->postal_code,
            'PCNPJCPFCLIENTE-VARCHAR2-IN' => $address->customer_document,
            'PCODENDER-VARCHAR2-IN' => $address->type,
            'PCODUMIBGE-NUMBER-IN' => $address->city_code,
            'PCOMPLEMENTO-VARCHAR2-IN' => $address->complement,
            'PCONTATO-VARCHAR2-IN' => '',
            'PDDDTEL-NUMBER-IN' => '',
            'PDESCRICAO-VARCHAR2-IN' => '',
            'PEMAIL-VARCHAR2-IN' => '',
            'PENDER-VARCHAR2-IN' => $address->address,
            'PFAX-VARCHAR2-IN' => '',
            'PIDENDERIN-NUMBER-IN' => $address->code,
            'PNOMERESP-VARCHAR2-IN' => '',
            'PNUMENDER-VARCHAR2-IN' => '',
            'PNUMTELEX-VARCHAR2-IN' => '',
            'PTELEFONE-VARCHAR2-IN' => '',
            'PTIPOLOGRADOURO-VARCHAR2-IN' => '',
            'PIDENDEROUT-NUMBER-OUT' => '',
            'PMSG-VARCHAR2-OUT' => '',
        ];
    }

}