<?php

namespace Vinci\Domain\ERP\Order\Shipping;

use Vinci\Domain\ERP\Address\Address;
use Vinci\Domain\ERP\Transformer\BaseTransformer;

class AddressGetErpTransformer extends BaseTransformer
{

    public function transform(Address $address)
    {
        return [
            'PBAIRRO-VARCHAR2-IN' => $address->district,
            'PCEP-VARCHAR2-IN' => $address->postal_code,
            'PCNPJCPFCLIENTE-VARCHAR2-IN' => $address->customer_document,
            'PCODUMIBGE-NUMBER-IN' => $address->city_code,
            'PENDER-VARCHAR2-IN' => $address->address,
            'PNUMENDER-VARCHAR2-IN' => $address->number,
            'PTPLOGRADOURO-VARCHAR2-IN' => $address->public_place,
            'PXML-XMLTYPE-OUT' => '',
        ];
    }

}