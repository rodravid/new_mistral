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

    public function setStartsAtFromFormat($startsAt, $format = 'd/m/Y H:i')
    {
        return $this->setDateFromFormat('startsAt', $startsAt, $format);
    }

    public function setExpirationAtFromFormat($expirationAt, $format = 'd/m/Y H:i')
    {
        return $this->setDateFromFormat('expirationAt', $expirationAt, $format);
    }

    public function setScheduleFieldsFromArray(array &$data, $unset = true)
    {
        $this->setStartsAtFromFormat($data['startsAt']);
        $this->setExpirationAtFromFormat($data['expirationAt']);

        if ($unset) {
            unset($data['startsAt'], $data['expirationAt']);
        }

        return $this;
    }

}