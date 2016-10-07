<?php

namespace Vinci\App\Cms\Http\ViewComposers;

use Illuminate\View\View;
use Vinci\App\Cms\Http\Deadline\Presenters\DeadlinePresenter;
use Vinci\App\Core\Services\Presenter\Presenter;
use Vinci\Domain\Deadline\DeadlineRepository;
use Vinci\Domain\Dollar\DollarProvider;

class TopNavComposer
{
    private $dollarProvider;

    private $deadlineRepository;

    private $presenter;

    public function __construct(DollarProvider $dollarProvider, DeadlineRepository $deadlineRepository, Presenter $presenter)
    {
        $this->dollarProvider = $dollarProvider;
        $this->deadlineRepository = $deadlineRepository;
        $this->presenter = $presenter;
    }

    public function compose(View $view)
    {
        $dollar = $this->dollarProvider->getCurrentDollarAmount();

        if ($dollar && cmsUser()->canManageModule('dollar')) {
            $view->with('currentDollar', money($dollar));
        }

        $deadline = $this->deadlineRepository->getLast();

        if ($deadline && cmsUser()->canManageModule('deadline')) {
            $deadline = $this->presenter->model($deadline, DeadlinePresenter::class);
            $view->with('currentDeadline', $deadline);
        }

    }

}