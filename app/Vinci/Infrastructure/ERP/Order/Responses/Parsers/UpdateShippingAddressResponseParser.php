<?php

namespace Vinci\Infrastructure\ERP\Order\Responses\Parsers;

use Exception;
use Vinci\Infrastructure\ERP\Order\Responses\UpdateShippingAddressResponse;
use Vinci\Infrastructure\ERP\ResponseParser;

class UpdateShippingAddressResponseParser extends ResponseParser
{
    public function parseResponse($response)
    {
        try {

            $addressId = $this->extractAddressId($response);

            return new UpdateShippingAddressResponse($response, $addressId);

        } catch (Exception $e)  {

            return new UpdateShippingAddressResponse($response);
        }
    }

    protected function extractAddressId($response)
    {
        return trim((string) simplexml_load_string($this->sanitizeResponse($response))->PIDENDEROUT);
    }

}