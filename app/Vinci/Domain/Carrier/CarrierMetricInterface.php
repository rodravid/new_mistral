<?php

namespace Vinci\Domain\Carrier;

interface CarrierMetricInterface
{
    public function getId();

    public function getCarrier();

    public function setCarrier(Carrier $carrier);

    public function getInitialTrack();

    public function setInitialTrack($initialTrack);

    public function getFinalTrack();

    public function setFinalTrack($finalTrack);

    public function getInitialWeight();

    public function setInitialWeight($initialWeight);

    public function getFinalWeight();

    public function setFinalWeight($finalWeight);

    public function getDeadline();

    public function setDeadline($deadline);

    public function getPrice();

    public function setPrice($price);

    public function getTaxes();

    public function addTax(TaxInterface $tax);

    public function hasTax(TaxInterface $tax);

    public function hasTaxes();
}