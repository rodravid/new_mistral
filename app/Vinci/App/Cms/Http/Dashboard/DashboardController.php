<?php

namespace Vinci\App\Cms\Http\Dashboard;

use Vinci\App\Cms\Http\Controller;

class DashboardController extends Controller
{

    public function index()
    {
        if (! $this->user->hasPermissionTo('cms.dashboard.show')) {
            return $this->view('dashboard.default');
        }

        return $this->view('dashboard.index');
    }

}