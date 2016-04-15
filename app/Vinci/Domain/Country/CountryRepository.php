<?php

namespace Vinci\Domain\Country;

interface CountryRepository
{

    public function find($id);

    public function create(array $data);

}