<?php

namespace Vinci\Domain\Pricing;

class PriceConfiguration
{

    protected $discountType;

    protected $discountAmount;

    protected $currencyAmount;

    protected $currencyOriginalAmount;

    protected $aliquotIpi;

    public function getDiscountType()
    {
        return $this->discountType;
    }

    public function setDiscountType($discountType = null)
    {
        $this->discountType = $discountType;
        return $this;
    }

    public function getDiscountAmount()
    {
        return $this->discountAmount;
    }

    public function setDiscountAmount($discountAmount = null)
    {
        $this->discountAmount = $discountAmount;
        return $this;
    }

    public function getCurrencyAmount()
    {
        return $this->currencyAmount;
    }

    public function setCurrencyAmount($currencyAmount = null)
    {
        $this->currencyAmount = $currencyAmount;
        return $this;
    }

    public function getCurrencyOriginalAmount()
    {
        return $this->currencyOriginalAmount;
    }

    public function setCurrencyOriginalAmount($currencyOriginalAmount = null)
    {
        $this->currencyOriginalAmount = $currencyOriginalAmount;
        return $this;
    }

    public function getAliquotIpi()
    {
        return $this->aliquotIpi;
    }

    public function setAliquotIpi($aliquotIpi)
    {
        $this->aliquotIpi = $aliquotIpi;
        return $this;
    }

}