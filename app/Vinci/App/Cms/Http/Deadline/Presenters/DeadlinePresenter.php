<?php

namespace Vinci\App\Cms\Http\Deadline\Presenters;

use Vinci\App\Core\Services\Presenter\AbstractPresenter;

class DeadlinePresenter extends AbstractPresenter
{

    public function presentDaysWritten()
    {
        $days = $this->getDays();
        return $days == 1 ? $days . ' dia' : $days . ' dias';
    }

}