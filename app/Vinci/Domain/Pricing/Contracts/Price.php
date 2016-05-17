<?php

namespace Vinci\Domain\Pricing\Contracts;

interface Price
{

    public function getChannel();

    public function hasChannel();

    public function getPrice();

    public function getCostPrice();

    public function getCurrencyAmount();

    public function getCurrencyOriginalAmount();

    public function getDiscountType();

    public function getDiscountAmount();

    public function getAliquotIpi();

    public function asSalePrice();

    public function asOriginalSalePrice();

}