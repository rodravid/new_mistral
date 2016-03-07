<?php

namespace Vinci\App\Website\Http\Home;

use Vinci\App\Website\Http\Controller;

class HomeController extends Controller
{

    public function index()
    {
        return $this->view('home.index');
    }

}