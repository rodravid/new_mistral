<?php

namespace Vinci\Domain\Product;

use Doctrine\ORM\Mapping as ORM;
use Vinci\Domain\Core\Model;

/**
 * @ORM\Embeddable
 */
class ShippingMetrics extends Model
{

    /**
     * @ORM\Column(name="deadline", type="integer", nullable=true)
     */
    protected $deadline = 0;

    public function getDeadline()
    {
        return $this->deadline;
    }

    public function setDeadline($deadline)
    {
        $this->deadline = (int) $deadline;
        return $this;
    }

}