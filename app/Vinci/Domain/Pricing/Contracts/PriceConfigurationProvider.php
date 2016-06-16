<?php

namespace Vinci\Domain\Pricing\Contracts;

use Vinci\Domain\Pricing\PriceConfiguration;

interface PriceConfigurationProvider
{

    /**
     * @return PriceConfiguration
     */
    public function getConfiguration();

}