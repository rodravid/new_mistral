<?php

namespace Vinci\App\Cms\Http\Tests;

use View;
use Vinci\App\Cms\Http\Controller;

class MailTemplateController extends Controller
{
    public function render($namespace, $type, $template)
    {
        return View::make(sprintf('website::layouts.emails.%s.%s.%s', $namespace, $type, $template));
    }

}