<?php

namespace Vinci\App\Cms\Http\ViewComposers;

use Illuminate\View\View;
use Vinci\Domain\Grape\GrapeRepository;

class ProductViewComposer
{

    protected $grapeRepository;

    public function __construct(GrapeRepository $grapeRepository)
    {
        $this->grapeRepository = $grapeRepository;
    }

    public function compose(View $view)
    {
        $g = $this->grapeRepository->getAll();

        $grapes = [];
        foreach ($g as $grape) {
            $grapes[$grape->getId()] = $grape->getName();
        }

        $view->with('grapes', $grapes);
    }

}