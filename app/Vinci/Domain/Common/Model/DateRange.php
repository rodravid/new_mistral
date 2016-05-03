<?php

namespace Vinci\Domain\Common\Model;

final class DateRange
{
    /**
     * @var \DateTime
     */
    private $start;

    /**
     * @var \DateTime
     */
    private $end;

    /**
     * @param \DateTime $start
     * @param \DateTime $end
     */
    public function __construct(\DateTime $start = null, \DateTime $end = null)
    {
        $this->start = $start;
        $this->end = $end;
    }

    /**
     * Checks whether current datetime meets two requirements:
     * is greater than $start or equal,
     * is smaller than $end or equal.
     * Checks only these conditions which values ($start, $end) are not null.
     *
     * @return bool
     */
    public function isInRange()
    {
        if ($this->start > new \DateTime() || ($this->end !== null && $this->end < new \DateTime())) {
            return false;
        }

        return true;
    }

    /**
     * @param \DateTime $start
     */
    public function setStart(\DateTime $start = null)
    {
        $this->start = $start;
    }

    /**
     * @param \DateTime $end
     */
    public function setEnd(\DateTime $end = null)
    {
        $this->end = $end;
    }

    /**
     * @return \DateTime
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @return \DateTime
     */
    public function getEnd()
    {
        return $this->end;
    }
}
