<?php

namespace Vinci\Domain\Payment;

interface CreditCardInterface
{

    const BRAND_VISA = 'visa';
    const BRAND_MASTERCARD = 'mastercard';
    const BRAND_DISCOVER = 'discover';
    const BRAND_AMEX = 'amex';
    const BRAND_DINERS_CLUB = 'diners_club';
    const BRAND_JCB = 'jcb';
    const BRAND_SWITCH = 'switch';
    const BRAND_SOLO = 'solo';
    const BRAND_DANKORT = 'dankort';
    const BRAND_MAESTRO = 'maestro';
    const BRAND_FORBRUGSFORENINGEN = 'forbrugsforeningen';
    const BRAND_LASER = 'laser';

    public function getBrand();

    public function setBrand($brand);

    public function getHolderName();

    public function setHolderName($cardholderName);

    public function getNumber();

    public function setNumber($number);

    public function getMaskedNumber();

    public function getSecurityCode();

    public function setSecurityCode($securityCode);

    public function getExpiryMonth();

    public function setExpiryMonth($expiryMonth);

    public function getExpiryYear();

    public function setExpiryYear($expiryYear);
}
