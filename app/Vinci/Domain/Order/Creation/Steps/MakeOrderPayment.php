<?php

namespace Vinci\Domain\Order\Creation\Steps;

use Vinci\Domain\Payment\CreditCard;
use Vinci\Domain\Payment\Payment;
use Vinci\Domain\Payment\Repositories\PaymentMethodsRepository;

class MakeOrderPayment
{
    private $paymentMethodRepository;

    public function __construct(PaymentMethodsRepository $paymentMethodRepository)
    {
        $this->paymentMethodRepository = $paymentMethodRepository;
    }

    public function handle($data, $next)
    {
        $order = $data['order'];

        $payment = new Payment;

        $paymentMethod = $this->getPaymentMethod($data);

        $payment->setMethod($paymentMethod);

        if ($paymentMethod->isCreditCard()) {

            $creditCard = $this->getCreditCard($data);
            $creditCard->setBrand($paymentMethod->getCode());

            $payment = $payment
                ->setCreditCard($creditCard)
                ->setInstallments($this->getPaymentInstallments($data));

        }

        $payment->setAmount($order->getTotal());

        $order->addPayment($payment);

        return $next($data);
    }

    private function getCreditCard(array $data)
    {
        $card = new CreditCard;

        $card
            ->setHolderName(array_get($data, 'card.holdername'))
            ->setHolderDocument(array_get($data, 'document'))
            ->setNumber(array_get($data, 'card.number'))
            ->setExpiryMonth(array_get($data, 'card.expiry_month'))
            ->setExpiryYear(array_get($data, 'card.expiry_year'))
            ->setSecurityCode(array_get($data, 'card.security_code'));

        return $card;
    }

    private function getPaymentMethod($data)
    {
        return $this->paymentMethodRepository->findOneById(array_get($data, 'payment.method'));
    }

    private function getPaymentInstallments(array $data)
    {
        return array_get($data, 'payment.installments');
    }

}