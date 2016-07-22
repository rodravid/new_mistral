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
            'PCONTATO-VARCHAR2-IN' => $address->customer_name,
            'PDDDTEL-NUMBER-IN' => $address->phone->ddd,
            'PDESCRICAO-VARCHAR2-IN' => '',
            'PEMAIL-VARCHAR2-IN' => $address->customer_email,
            'PENDER-VARCHAR2-IN' => $address->address,
            'PFAX-VARCHAR2-IN' => '',
            'PIDENDERIN-NUMBER-IN' => $address->code,
            'PNOMERESP-VARCHAR2-IN' => '',
            'PNUMENDER-VARCHAR2-IN' => $address->number,
            'PNUMTELEX-VARCHAR2-IN' => '',
            'PTELEFONE-VARCHAR2-IN' => $address->phone->number,
            'PTIPOLOGRADOURO-VARCHAR2-IN' => $address->public_place,
            'PIDENDEROUT-NUMBER-OUT' => '',
            'PMSG-VARCHAR2-OUT' => '',
        ];
    }

}