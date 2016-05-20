<?php

namespace Vinci\Domain\Channel\Contracts;

interface Channel
{

    public function getCode();

    public function getAccessKey();

    public function isDefault();

}