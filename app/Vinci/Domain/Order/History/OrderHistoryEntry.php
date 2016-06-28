<?php

namespace Vinci\Domain\Order\History;

use Doctrine\ORM\Mapping as ORM;
use Vinci\Domain\Common\Traits\Timestampable;

/**
 * @ORM\Entity
 * @ORM\Table(name="orders_history_entries")
 */
class OrderHistoryEntry
{

    use Timestampable;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Vinci\Domain\Order\History\OrderHistory", inversedBy="entries")
     */
    protected $history;

    public function getId()
    {
        return $this->id;
    }

    public function getHistory()
    {
        return $this->history;
    }

    public function setHistory(OrderHistory $history)
    {
        $this->history = $history;
        return $this;
    }

}