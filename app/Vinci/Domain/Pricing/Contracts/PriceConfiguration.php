<?php

namespace Vinci\Domain\Pricing\Contracts;

interface PriceConfiguration
{
    public function getDiscountType();

    public function getDiscountAmount();

    public function getCurrencyAmount();

    public function getCurrencyOriginalAmount();

    public function getAliquotIpi();
}