<?php
namespace Vinci\App\Integration\ERP\State;

use Vinci\App\Integration\ERP\Core\ErpBaseApi;

class ErpStateApi extends ErpBaseApi implements StateApi
{

    public function getServiceName()
    {
        return 'states';
    }

    public function getAllStatesOfCountry($countryId)
    {
        $soap = $this->service(config('erp.wsdl.states.get_states'));
        $data = $soap->__soapCall('GETESTADOS', [
            'GETESTADOSInput' => [
                'PCODPAISIBGE-NUMBER-IN' => $countryId,
                'PXML-XMLTYPE-OUT' => ''
            ]
        ]);

        $result = $this->parseResult($data);

        return $result;
    }

    public function parseResult($result)
    {
        $result = simplexml_load_string("<xml>{$result->PXML->any}</xml>");

        return $this->toCollection($result, [
            'COD_UF' => 'uf',
            'DESCRICAO' => 'name',
            'COD_PAIS' => 'country_id',
            'COD_UF_IBGE' => 'ibge_code'
        ]);
    }

}