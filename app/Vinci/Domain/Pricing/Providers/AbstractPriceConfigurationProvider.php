<?php

namespace Vinci\Domain\Pricing\Providers;

use Vinci\Domain\Pricing\Factory\PriceConfigurationFactory;

class AbstractPriceConfigurationProvider
{

    protected $configurationFactory;

    public function __construct(PriceConfigurationFactory $configurationFactory)
    {
        $this->configurationFactory = $configurationFactory;
    }

}