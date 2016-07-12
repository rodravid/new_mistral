<?php

namespace Vinci\Domain\ERP\Customer\Phone;

use League\Fractal\TransformerAbstract;

class PhoneTransformer extends TransformerAbstract
{

    public function transform($phone = '')
    {
        list($ddd, $number) = $this->splitPhoneNumber($phone);

        return [
            'ddd' => $ddd,
            'number' => $number,
        ];
    }

    public function splitPhoneNumber($phoneNumber)
    {
        if (empty($phoneNumber)) {
            return ['', ''];
        }

        return [substr($phoneNumber, 0, 2), substr($phoneNumber, 2)];
    }

}