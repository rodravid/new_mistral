<?php

namespace Vinci\App\Website\Http\Home;

use Vinci\App\Website\Http\Controller;
use Vinci\Domain\Highlight\HighlightRepository;

class HomeController extends Controller
{

    public function index(HighlightRepository $repo)
    {
        $highlights = $repo->lists();

        return $this->view('home.index', compact('highlights'));
    }

}