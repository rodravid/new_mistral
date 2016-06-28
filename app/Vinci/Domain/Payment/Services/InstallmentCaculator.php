<?php

namespace Vinci\Domain\Payment\Services;

use Vinci\Domain\Payment\Repositories\PaymentInstallmentRepository;

class InstallmentCaculator
{
    protected $paymentInstallmentRepository;

    public function __construct(PaymentInstallmentRepository $paymentInstallmentRepository)
    {
        $this->paymentInstallmentRepository = $paymentInstallmentRepository;
    }

    public function getInstallmentOptions($amount, $paymentMethod)
    {
        $installments = [];
        for ($i = 1; $i <= $this->getInstallmentQuantity($amount, $paymentMethod); $i++) {
            $installments[] = $this->getInstallment($i, $amount);
        }

        return $installments;
    }

    public function getInstallmentQuantity($amount, $paymentMethod)
    {
        $installmentOptions = $this->paymentInstallmentRepository->getInstallmentQuantityBy($amount, $paymentMethod);

        if (empty($installmentOptions)) {
            return 1;
        }

        return $installmentOptions->getQuantity();

    }

    public function getInstallment($number, $value)
    {
        $value = round($value / $number, 2);
        $realValue = money($value);

        return [
            'quantity' => $number,
            'value' => $value,
            'real_value' => $realValue,
            'label' => "{$number}x de {$realValue}"
        ];
    }

}