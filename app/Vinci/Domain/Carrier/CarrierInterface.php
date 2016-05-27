<?php

namespace Vinci\Domain\Carrier;

use Doctrine\Common\Collections\Criteria;

interface CarrierInterface
{

    const CARRIER_DEFAULT = 'default';

    public function getShippingCalculator();

    public function getMetrics();

    public function getMetricsMatching(Criteria $criteria);

    public function isDefault();

}