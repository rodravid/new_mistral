<?php

namespace Vinci\Infrastructure\ERP\Order\Responses\Parsers;

use Exception;
use Vinci\Infrastructure\ERP\Order\Responses\GetShippingAddressResponse;
use Vinci\Infrastructure\ERP\ResponseParser;

class GetShippingAddressResponseParser extends ResponseParser
{
    public function parseResponse($response)
    {
        try {

            $addressId = $this->extractAddressId($response);

            return new GetShippingAddressResponse($response, $addressId);

        } catch (Exception $e)  {

            return new GetShippingAddressResponse($response);
        }
    }

    protected function extractAddressId($response)
    {
        return trim((string) simplexml_load_string($this->sanitizeResponse($response))->PXML->ENDERECO_ENTREGA->ID_ENDER);
    }

}