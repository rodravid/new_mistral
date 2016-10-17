<?php
namespace Vinci\App\Integration\ERP\City;

interface CityRepository
{

    public function exists($id);

    public function createCity(array $data);

    public function updateCity(array $data);

}