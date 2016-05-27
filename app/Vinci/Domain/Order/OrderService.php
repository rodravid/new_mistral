<?php

namespace Vinci\Domain\Order;

use Doctrine\ORM\EntityManagerInterface;
use Vinci\Domain\Order\Factory\OrderFactory;
use Illuminate\Contracts\Events\Dispatcher;

class OrderService
{

    protected $entityManager;

    protected $validator;

    protected $factory;

    protected $eventDispatcher;

    public function __construct(
        EntityManagerInterface $entityManager,
        OrderValidator $validator,
        OrderFactory $factory,
        Dispatcher $eventDispatcher
    ) {
        $this->entityManager = $entityManager;
        $this->validator = $validator;
        $this->factory = $factory;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function create(array $data)
    {
        $this->validator->with($data)->passesOrFail();

        return $this->entityManager->transactional(function($em) use ($data) {

            $order = $this->factory->make($data);

            dd($order);

            $this->dispatchEvents($order);

            $em->persist($order);

            return $order;
        });
    }

    protected function dispatchEvents(OrderInterface $order)
    {
        foreach ($order->releaseEvents() as $event) {
            $this->eventDispatcher->fire($event);
        }
    }

}