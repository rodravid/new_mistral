<?php

namespace Vinci\Domain\Order\Creation;

use Auth;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Contracts\Bus\Dispatcher as BusDispatcher;
use Vinci\Domain\Common\Event\FiredByAdminUser;
use Illuminate\Contracts\Events\Dispatcher;
use Vinci\Domain\Order\OrderInterface;
use Vinci\Domain\Order\Strategy\BankDepositOrderCreationStrategy;
use Vinci\Domain\Order\Strategy\CreditCardOrderCreationStrategy;
use Vinci\Domain\Payment\Repositories\PaymentMethodsRepository;

class OrderCreationService
{

    protected $entityManager;

    protected $eventDispatcher;

    protected $paymentMethodRepository;

    protected $bus;

    public function __construct(
        EntityManagerInterface $entityManager,
        Dispatcher $eventDispatcher,
        BusDispatcher $bus,
        PaymentMethodsRepository $paymentMethodsRepository
    ) {
        $this->entityManager = $entityManager;
        $this->eventDispatcher = $eventDispatcher;
        $this->bus = $bus;
        $this->paymentMethodRepository = $paymentMethodsRepository;
    }

    public function create(array $data)
    {
        $strategy = $this->chooseCreationStrategy($data);

        $strategy->setFinisherHandler(function(OrderInterface $order) {

            return $this->entityManager->transactional(function($em) use ($order) {

                $em->persist($order);

                $this->dispatchOrderEvents($order);

                return $order;
            });

        });

        return $strategy->execute($data);
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

    protected function getPaymentMethod($data)
    {
        return $this->paymentMethodRepository->findOneById(array_get($data, 'payment.method'));
    }

    private function chooseCreationStrategy(array $data)
    {
        $paymentMethod = $this->getPaymentMethod($data);

        if ($paymentMethod->isCreditCard()) {
            return app(CreditCardOrderCreationStrategy::class);
        } elseif ($paymentMethod->isBankDeposit()) {
            return app(BankDepositOrderCreationStrategy::class);
        }
    }

}