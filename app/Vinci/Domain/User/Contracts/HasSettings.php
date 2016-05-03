<?php

namespace Vinci\Domain\User\Contracts;

interface HasSettings
{

    public function settings($key = null, $value = null);

}