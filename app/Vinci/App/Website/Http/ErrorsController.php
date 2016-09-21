<?php

namespace Vinci\App\Website\Http;


class ErrorsController extends Controller
{

    public function render($code)
    {
        return $this->view("errors.http.{$code}");
    }

}