<?php

namespace Vinci\Domain\DeliveryTrack;

use Vinci\App\Core\Services\Validation\LaravelValidator;

class DeliveryTrackValidator extends LaravelValidator
{

    protected $rules = [
        'title' => 'required',
    ];

}