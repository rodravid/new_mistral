<?php

namespace Vinci\App\Cms\Http\ViewComposers;

use Illuminate\View\View;
use Vinci\App\Cms\Http\Dollar\Presenters\DollarPresenter;
use Vinci\App\Core\Services\Presenter\Presenter;
use Vinci\Domain\Dollar\DollarRepository;

class TopNavComposer
{
    private $dollarRepository;

    private $presenter;

    public function __construct(DollarRepository $dollarRepository, Presenter $presenter)
    {
        $this->dollarRepository = $dollarRepository;
        $this->presenter = $presenter;
    }

    public function compose(View $view)
    {
        $dollar = $this->dollarRepository->getLast();

        if ($dollar) {
            $dollar = $this->presenter->model($dollar, DollarPresenter::class);
            $view->with('currentDollar', $dollar);
        }
    }

}