<?php
namespace Vinci\App\Integration\ERP\Core;

use Closure;

abstract class ErpBaseApi
{
    public abstract function getServiceName();

    public function service($url)
    {
        return new \SoapClient($url . '?wsdl', [
            'login' => config('erp.username'),
            'password' => config('erp.password')
        ]);
    }

    public function parseResult($result)
    {
        return $result;
    }

    public function toArray($data, array $map)
    {
        $result = [];

        $i = 0;
        foreach ($data as $item) {

            foreach ($map as $key => $value) {

                $result[$i][$value] = (string) $item->$key;
            }

            $i++;
        }

        return $result;
    }

    public function toCollection($data, array $map)
    {
        return collect($this->toArray($data, $map));
    }

}