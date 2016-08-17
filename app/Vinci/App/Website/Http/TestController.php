<?php

namespace Vinci\App\Website\Http;

//use Illuminate\Routing\Controller;

class TestController extends Controller
{

    public function index()
    {
        return '<html><head><title>Teste</title></head><body></body></html>';
    }

}