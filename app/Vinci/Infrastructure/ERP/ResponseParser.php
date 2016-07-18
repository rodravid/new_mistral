<?php

namespace Vinci\Infrastructure\ERP;

use Exception;
use GuzzleHttp\Psr7\Response;

abstract class ResponseParser
{

    protected abstract function parseResponse($response);

    public function parse($response)
    {
        $response = $this->normalizeResponse($response);

        return $this->parseResponse($response);
    }

    protected function normalizeResponse($response)
    {
        if (is_string($response)) {
            return $response;
        }

        if ($response instanceof Response) {
            return $response->getBody()->getContents();
        }

        throw new Exception('Invalid response.');
    }

    protected function sanitizeResponse($response)
    {
        $response = str_replace('<?xml version="1.0" ?>', '', str_replace('<?xml version="1.0"?>', '', $response));

        $response = '<?xml version="1.0" encoding="ISO-8859-1" ?>' . trim($response);

        $response = str_replace('<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">', '', $response);
        $response = str_replace('<soap:Body>', '', $response);
        $response = str_replace('</soap:Body>', '', $response);
        $response = str_replace('</soap:Envelope>', '', $response);

        return $response;
    }

    protected function extractMessage($response)
    {
        return trim((string) simplexml_load_string($this->sanitizeResponse($response))->PMSG);
    }

}