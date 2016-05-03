<?php

namespace Vinci\Domain\Address\State;

interface StateRepository
{

    public function find($id);

    public function getByCountry($country);

}