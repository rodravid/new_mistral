<?php

namespace Vinci\App\Cms\Http\Dashboard;

use Vinci\App\Cms\Http\Controller;

class DashboardController extends Controller
{

    public function index()
    {
        return $this->view('dashboard.index');
    }

}