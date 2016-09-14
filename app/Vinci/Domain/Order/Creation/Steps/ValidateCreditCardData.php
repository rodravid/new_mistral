<?php

namespace Vinci\Domain\Order\Creation\Steps;

use Carbon\Carbon;
use Illuminate\Support\MessageBag;
use Vinci\App\Core\Services\Validation\Exceptions\ValidationException;
use Vinci\Domain\Payment\Repositories\PaymentMethodsRepository;
use Vinci\Domain\Payment\Validators\CreditCardValidator;
use Inacho\CreditCard as CreditCardNumberValidator;

class ValidateCreditCardData
{
    private $paymentMethodRepository;

    private $validator;

    public function __construct(PaymentMethodsRepository $paymentMethodRepository, CreditCardValidator $validator)
    {
        $this->paymentMethodRepository = $paymentMethodRepository;
        $this->validator = $validator;
    }

    public function handle($data, $next)
    {
        $paymentMethod = $this->getPaymentMethod($data);

        $data['payment']['method_type'] = $paymentMethod->getDescription();

        $this->validator->with($data)->passesOrFail();

        if(! CreditCardNumberValidator::validCreditCard(only_numbers(array_get($data, 'card.number')), $paymentMethod->getName())['valid']) {
            throw new ValidationException(new MessageBag([
                'card.number' => 'Cartão de crédito inválido para a bandeira selecionada.'
            ]));
        }

        $installments = array_get($data, 'payment.installments');

        $creditcardExpires = Carbon::createFromDate(array_get($data, 'card.expiry_year'), array_get($data, 'card.expiry_month'));
        $now = Carbon::now();
        $message = 'A validade do cartão de crédito está expirada.';

        if ($installments > 1) {
            $message = 'O mês de validade do cartão não pode ser menor ou igual ao mês da última parcela.';
            $now->addMonths($installments);
        }

        if ($creditcardExpires < $now) {
            throw new ValidationException(new MessageBag([
                'card.expiry_month' => $message,
            ]));
        }

        return $next($data);
    }

    private function getPaymentMethod($data)
    {
        return $this->paymentMethodRepository->findOneById(array_get($data, 'payment.method'));
    }

}