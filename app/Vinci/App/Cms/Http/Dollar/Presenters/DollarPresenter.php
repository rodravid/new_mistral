<?php

namespace Vinci\App\Cms\Http\Dollar\Presenters;

use Carbon\Carbon;
use Vinci\App\Core\Services\Presenter\AbstractPresenter;
use Vinci\Domain\Dollar\DollarProvider;

class DollarPresenter extends AbstractPresenter
{

    public function presentScheduleStatusHtml()
    {
        $startsAt = $this->getStartsAt();

        if ($this->getId() == app(DollarProvider::class)->getCurrentDollar()->getId()) {
            return '<span class="badge bg-green"><i class="fa fa-check"></i> Ativo</span>';
        }

        if ($startsAt->isPast()) {
            return '<span class="badge bg-red"><i class="fa fa-calendar-times-o"></i> Expirado</span>';
        }

        if ($startsAt->isFuture()) {
            return '<span class="badge bg-yellow"><i class="fa fa-calendar-check-o"></i> Agendado</span>';
        }

    }

}