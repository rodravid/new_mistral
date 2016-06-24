<?php

namespace Vinci\App\Website\Http\ViewComposers;


use Illuminate\View\View;
use Vinci\Domain\Payment\Repositories\PaymentMethodsRepository;

class PaymentMethodsComposer
{
    protected $paymentMethodsRepository;

    public function __construct(PaymentMethodsRepository $paymentMethodsRepository)
    {
        $this->paymentMethodsRepository = $paymentMethodsRepository;
    }

    public function compose(View $view)
    {
        $view->with('paymentMethods', $this->getPaymentMethods());
    }

    protected function getPaymentMethods()
    {
        return $this->paymentMethodsRepository->getAll();
    }
}