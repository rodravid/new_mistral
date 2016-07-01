<?php

namespace Vinci\Domain\Order\History;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Vinci\Domain\Common\Traits\Timestampable;
use Vinci\Domain\Core\Model;
use Vinci\Domain\Order\Order;
use Vinci\Domain\Order\OrderInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="orders_history")
 */
class OrderHistory extends Model
{

    use Timestampable;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="Vinci\Domain\Order\Order", inversedBy="history")
     * @ORM\JoinColumn(name="order_id", referencedColumnName="id")
     */
    protected $order;

    /**
     * @ORM\OneToMany(targetEntity="Vinci\Domain\Order\History\OrderHistoryEntry", mappedBy="history")
     */
    protected $entries;

    public function __construct(Order $order)
    {
        $this->entries = new ArrayCollection;
        $this->setOrder($order);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getOrder()
    {
        return $this->order;
    }

    public function setOrder(OrderInterface $order)
    {
        $this->order = $order;
        return $this;
    }

    public function addEntry(OrderHistoryEntry $entry)
    {
        if (! $this->hasEntry($entry)) {

            $entry->setHistory($this);

            $this->entries->add($entry);
        }

        return $this;
    }

    public function removeEntry(OrderHistoryEntry $entry)
    {
        if ($this->hasEntry($entry)) {
            $this->entries->removeElement($entry);
        }

        return $this;
    }

    public function hasEntry(OrderHistoryEntry $entry)
    {
        return $this->entries->contains($entry);
    }

    public function logEntry($type, $user, $oldStatus, $newStatus, $description = null)
    {
        $entry = new OrderHistoryEntry;

        $entry
            ->setType($type)
            ->setOldStatus($oldStatus)
            ->setNewStatus($newStatus)
            ->setDescription($description);

        $this->addEntry($entry);
    }

}