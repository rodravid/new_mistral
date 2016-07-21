<?php

namespace Vinci\Domain\ERP;

use ArrayAccess;
use Vinci\Domain\Common\Traits\Attributes;
use Vinci\Domain\ERP\Customer\Phone\Phone;

class Model implements ArrayAccess
{
    use Attributes;

    public function setPhone($phone)
    {
        if (is_array($phone)) {
            $this->attributes['phone'] = new Phone($phone);
            return $this;
        }

        $this->attributes['phone'] = $phone;
        return $this;
    }

}