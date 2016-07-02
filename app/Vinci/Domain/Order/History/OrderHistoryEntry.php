<?php

namespace Vinci\Domain\Order\History;

use Doctrine\ORM\Mapping as ORM;
use Vinci\Domain\Common\Relationships\HasOneAdminUser;
use Vinci\Domain\Common\Traits\Timestampable;

/**
 * @ORM\Entity
 * @ORM\Table(name="orders_history_entries")
 */
class OrderHistoryEntry
{

    use Timestampable, HasOneAdminUser;

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

    /**
     * @ORM\Column(type="string")
     */
    protected $type;

    /**
     * @ORM\Column(type="string")
     */
    protected $oldStatus;

    /**
     * @ORM\Column(type="string")
     */
    protected $newStatus;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;

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

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    public function getOldStatus()
    {
        return $this->oldStatus;
    }

    public function setOldStatus($oldStatus)
    {
        $this->oldStatus = $oldStatus;
        return $this;
    }

    public function getNewStatus()
    {
        return $this->newStatus;
    }

    public function setNewStatus($newStatus)
    {
        $this->newStatus = $newStatus;
        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description = null)
    {
        $this->description = $description;
        return $this;
    }

}