<?php

namespace Vinci\App\Website\Http\Controllers;

class CustomerController extends Controller
{

    public function index()
    {
        return $this->view('home');
    }

}