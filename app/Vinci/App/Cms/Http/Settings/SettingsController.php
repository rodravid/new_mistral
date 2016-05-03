<?php

namespace Vinci\App\Cms\Http\Settings;

use Vinci\App\Cms\Http\Controller;

class SettingsController extends Controller
{

    public function store($key, $value)
    {
        $this->user
            ->settings($key, $value)
            ->save();
    }

}