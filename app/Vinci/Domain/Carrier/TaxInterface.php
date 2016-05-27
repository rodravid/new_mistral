<?php

namespace Vinci\Domain\Carrier;

interface TaxInterface
{
    CONST TYPE_FIXED = 'fixed';
    CONST TYPE_PERCENTAGE = 'percentage';

    public function getId();

    public function getTitle();

    public function setTitle($title);

    public function getCode();

    public function setCode($code);

    public function getType();

    public function setType($type);

    public function getAmount();

    public function setAmount($amount);

    public function getCarrierMetric();

    public function setCarrierMetric(CarrierMetric $carrierMetric);

    public function apply(&$amount);
}