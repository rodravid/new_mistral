<?php

namespace Vinci\Domain\Common\Traits;

use Carbon\Carbon;
use Doctrine\ORM\Mapping as ORM;

trait Schedulable
{

    /**
     * @ORM\Column(name="starts_at", type="datetime", nullable=true)
     */
    protected $startsAt;

    /**
     * @ORM\Column(name="expiration_at", type="datetime", nullable=true)
     */
    protected $expirationAt;

    /**
     * @return Carbon
     */
    public function getStartsAt()
    {
        return $this->startsAt;
    }

    /**
     * @return Carbon
     */
    public function getExpirationAt()
    {
        return $this->expirationAt;
    }

    /**
     * @param Carbon $startsAt
     * @return $this
     */
    public function setStartsAt(Carbon $startsAt)
    {
        $this->startsAt = $startsAt;
        return $this;
    }

    /**
     * @param Carbon $expirationAt
     * @return $this
     */
    public function setExpirationAt(Carbon $expirationAt = null)
    {
        $this->expirationAt = $expirationAt;
        return $this;
    }

}