<?php

namespace Vinci\Domain\Pricing\Contracts;

interface DiscountType
{

    const FIXED = 'fixed';
    const PERCENTAGE = 'percent';
    const EXCHANGE_RATE = 'exchange-rate';

}