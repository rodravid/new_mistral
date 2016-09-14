<?php

namespace Vinci\Domain\Order;

use Auth;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Contracts\Bus\Dispatcher as BusDispatcher;
use Vinci\Domain\Common\Event\FiredByAdminUser;
use Vinci\Domain\Order\Commands\ChangeOrderStatusCommand;
use Illuminate\Contracts\Events\Dispatcher;
use Vinci\Domain\Order\Creation\OrderCreationService;
use Vinci\Domain\Order\Jobs\SendOrderStatusMail;
use Vinci\Domain\Order\TrackingStatus\OrderTrackingStatus;

class OrderService
{

    protected $entityManager;

    protected $eventDispatcher;

    protected $bus;

    private $orderCreationService;

    public function __construct(
        EntityManagerInterface $entityManager,
        OrderCreationService $orderCreationService,
        Dispatcher $eventDispatcher,
        BusDispatcher $bus
    ) {
        $this->entityManager = $entityManager;
        $this->orderCreationService = $orderCreationService;
        $this->eventDispatcher = $eventDispatcher;
        $this->bus = $bus;
    }

    public function create(array $data)
    {
        return $this->orderCreationService->create($data);
    }

    protected function dispatchOrderEvents(OrderInterface $order)
    {
        foreach ($order->releaseEvents() as $event) {

            if ($event instanceof FiredByAdminUser) {
                $event->setUser(Auth::guard('cms')->user());
            }

            $this->eventDispatcher->fire($event);
        }
    }

    public function changeOrderStatus(ChangeOrderStatusCommand $command)
    {
        $this->entityManager->transactional(function($em) use ($command) {

            $order = $command->getOrder();

            $orderTtackingStatus = $this->normalizeTrackingStatus($command->getOrderTrackingStatus());

            $order->changeStatus($command->getOrderStatus());
            $order->changePaymentStatus($command->getPaymentStatus());
            $order->changeTrackingStatus($orderTtackingStatus);

            $em->persist($order);

            $this->dispatchOrderEvents($order);

        });

        if ($command->shouldSendMail()) {
            $this->bus->dispatchNow(new SendOrderStatusMail($command->getOrder(), $command->getMailSubject(), $command->getMailBody()));
        }
    }

    protected function normalizeTrackingStatus($status)
    {
        return is_object($status)
            ? $status : $this->entityManager->getReference(OrderTrackingStatus::class, $status);
    }
}