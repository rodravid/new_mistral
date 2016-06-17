<?php

namespace Vinci\Domain\Pricing\Contracts;

interface PriceConfigurationProvider
{

    /**
     * @return PriceConfiguration
     */
    public function getConfiguration();

}