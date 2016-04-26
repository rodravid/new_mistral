<?php

namespace Vinci\Domain\DeliveryTrack;

use Vinci\App\Core\Services\Validation\LaravelValidator;

class LineValidator extends LaravelValidator
{

    protected $rules = [
        'line.*.initial_track' => 'required|digits:8',
        'line.*.final_track' => 'required|digits:8'
    ];

}