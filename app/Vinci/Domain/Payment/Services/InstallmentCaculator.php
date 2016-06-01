<?php

namespace Vinci\Domain\Payment\Services;

class InstallmentCaculator
{

    public function getInstallmentOptions($value)
    {
        $installments = [];
        for ($i = 1; $i <= $this->getInstallmentQuantity($value); $i++) {
            $installments[] = $this->getInstallment($i, $value);
        }

        return $installments;
    }

    public function getInstallmentQuantity($value)
    {
        if ($value < 70) {
            return 1;
        } else if ($value >= 70 && $value < 110) {
            return 2;
        } else if ($value >= 110 && $value < 180) {
            return 3;
        } else if ($value >= 180 && $value < 300) {
            return 4;
        } else {
            return 5;
        }
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