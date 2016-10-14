<?php

namespace Vinci\Domain\Address\State;

interface StateRepository extends \Vinci\App\Integration\ERP\State\StateRepository
{

    public function find($id);

    public function getByCountry($country);

}