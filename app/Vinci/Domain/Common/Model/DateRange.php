<?php

namespace Vinci\Domain\Common\Model;

use Carbon\Carbon;
use Vinci\Domain\Common\Period;

class DateRange
{

    private $start;

    private $end;

    public function __construct(\DateTime $start = null, \DateTime $end = null)
    {
        $this->start = $start;
        $this->end = $end;
    }

    public function isInRange()
    {
        if ($this->start > new \DateTime() || ($this->end !== null && $this->end < new \DateTime())) {
            return false;
        }

        return true;
    }

    public function getStart()
    {
        return $this->start;
    }

    public function setStart(\DateTime $start = null)
    {
        $this->start = $start;
    }

    public function getEnd()
    {
        return $this->end;
    }

    public function setEnd(\DateTime $end = null)
    {
        $this->end = $end;
    }

    public static function getPeriod($daysAgo = Period::DAYS_AGO_CHARTS)
    {
        return new static(Carbon::now()->subDays($daysAgo)->startOfDay(), Carbon::now()->endOfDay());
    }
}
