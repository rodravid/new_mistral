<?php

namespace Vinci\Domain\Order\History;

use Doctrine\ORM\EntityManagerInterface;
use Vinci\Domain\Admin\Admin;
use Vinci\Domain\Order\OrderInterface;

class OrderHistoryEntryBuilder
{

    protected $user;

    protected $order;

    protected $type;

    protected $oldStatus;

    protected $newStatus;

    protected $message;

    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function user(Admin $user)
    {
        $this->user = $user;
        return $this;
    }

    public function handle(OrderInterface $order)
    {
        $this->order = $order;
        return $this;
    }

    public function changingOldStatus($oldStatus)
    {
        $this->type = OrderHistoryEntryType::ORDER_STATUS_CHANGE;
        $this->message = 'Alterou o status do pedido';
        $this->oldStatus = $oldStatus;
        return $this;
    }

    public function changingOldTrackingStatus($oldStatus)
    {
        $this->type = OrderHistoryEntryType::ORDER_TRACKING_STATUS_CHANGE;
        $this->message = 'Alterou o status de acompanhamento do pedido';
        $this->oldStatus = $oldStatus;
        return $this;
    }

    public function changingOldPaymentStatus($oldStatus)
    {
        $this->type = OrderHistoryEntryType::ORDER_PAYMENT_STATUS_CHANGE;
        $this->message = 'Alterou o status do pagamento do pedido';
        $this->oldStatus = $oldStatus;
        return $this;
    }

    public function toNewStatus($newStatus)
    {
        $this->newStatus = $newStatus;
        return $this;
    }

    public function withMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    public function save()
    {
        $entry = new OrderHistoryEntry;

        $entry
            ->setUser($this->user)
            ->setType($this->type)
            ->setOldStatus($this->oldStatus)
            ->setNewStatus($this->newStatus)
            ->setDescription($this->message);

        $this->order->getHistory()->addEntry($entry);

        $this->entityManager->persist($this->order);
        $this->entityManager->persist($entry);
        $this->entityManager->flush();

        return $entry;
    }

    public static function make(EntityManagerInterface $em)
    {
        return new static($em);
    }

}