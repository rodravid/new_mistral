<?php

namespace Vinci\App\Core\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $viewNamespace;

    protected function view($view = null, $data = [], $mergeData = [])
    {
        if (! empty($this->viewNamespace) && ! str_contains($view, '::')) {
            $view = $this->viewNamespace . '::' . $view;
        }

        return view($view, $data, $mergeData);
    }
}
