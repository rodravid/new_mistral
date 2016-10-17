<?php
namespace Vinci\App\Integration\ERP\City;

use Vinci\App\Integration\ERP\Core\ErpBaseApi;

class ErpCityApi extends ErpBaseApi implements CityApi
{

    public function getServiceName()
    {
        return 'cities';
    }

    public function getAllCitiesOfState($stateId)
    {
        $soap = $this->service(config('erp.wsdl.cities.get_cities'));
        $data = $soap->__soapCall('GETCIDADES', [
            'GETESTADOSInput' => [
                'PCODUFIBGE-NUMBER-IN' => $stateId,
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
            'COD_UM' => 'id',
            'COD_UF' => 'uf',
            'DESCRICAO' => 'name',
            'COD_PAIS' => 'country_id',
            'COD_UM_IBGE' => 'ibge_code'
        ]);
    }

}