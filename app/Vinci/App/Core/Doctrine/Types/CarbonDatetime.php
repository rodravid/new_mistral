<?php

namespace Vinci\App\Core\Doctrine\Types;

use Carbon\Carbon;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\DateTimeType;

class CarbonDatetime extends DateTimeType
{
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (! is_null($value)) {
            return Carbon::instance(parent::convertToPHPValue($value, $platform));
        }
    }

}