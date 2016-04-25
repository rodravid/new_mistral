<?php

namespace Vinci\Domain\Address\City;

interface CityRepository
{

    public function find($id);

    public function getByState($state);

}