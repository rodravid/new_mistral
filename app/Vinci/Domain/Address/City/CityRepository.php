<?php

namespace Vinci\Domain\Address\City;

interface CityRepository extends \Vinci\App\Integration\ERP\City\CityRepository
{

    public function find($id);

    public function getByState($state);

}