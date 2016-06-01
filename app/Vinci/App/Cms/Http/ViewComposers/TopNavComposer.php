<?php

namespace Vinci\App\Cms\Http\ViewComposers;

use Illuminate\View\View;
use Vinci\App\Cms\Http\Deadline\Presenters\DeadlinePresenter;
use Vinci\App\Cms\Http\Dollar\Presenters\DollarPresenter;
use Vinci\App\Core\Services\Presenter\Presenter;
use Vinci\Domain\Deadline\DeadlineRepository;
use Vinci\Domain\Dollar\DollarRepository;

class TopNavComposer
{
    private $dollarRepository;

    private $deadlineRepository;

    private $presenter;

    public function __construct(DollarRepository $dollarRepository, DeadlineRepository $deadlineRepository, Presenter $presenter)
    {
        $this->dollarRepository = $dollarRepository;
        $this->deadlineRepository = $deadlineRepository;
        $this->presenter = $presenter;
    }

    public function compose(View $view)
    {
        $dollar = $this->dollarRepository->getLast();

        if ($dollar && cmsUser()->canManageModule('dollar')) {
            $dollar = $this->presenter->model($dollar, DollarPresenter::class);
            $view->with('currentDollar', $dollar);
        }

        $deadline = $this->deadlineRepository->getLast();

        if ($deadline && cmsUser()->canManageModule('deadline')) {
            $deadline = $this->presenter->model($deadline, DeadlinePresenter::class);
            $view->with('currentDeadline', $deadline);
        }

    }

}