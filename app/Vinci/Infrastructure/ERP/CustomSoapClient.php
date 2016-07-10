<?php

namespace Vinci\Infrastructure\ERP;

use SoapClient;

class CustomSoapClient extends SoapClient
{

    public function __doRequest($req, $location, $action, $version, $one_way = 0)
    {
        $xml = explode("\r\n", parent::__doRequest($req, $location, $action, $version, $one_way))[0];

        $xml = str_replace('<?xml version="1.0" ?>', '', str_replace('<?xml version="1.0"?>', '', $xml));

        $xml = '<?xml version="1.0" encoding="ISO-8859-1" ?>' . trim($xml);

        return $xml;
    }

    public function call($function, $params)
    {
        return $this->__call($function, $params);
    }

}