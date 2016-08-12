<?php

namespace Vinci\Domain\Customer\Jobs;

use Exception;
use Illuminate\Contracts\Mail\Mailer;
use Log;
use Vinci\App\Core\Jobs\Job;
use Vinci\App\Core\Services\Presenter\Presenter;
use Vinci\App\Website\Http\Customer\Presenters\CustomerPresenter;
use Vinci\Domain\Customer\CustomerInterface;

class SendCustomerAccountUpdateMail extends Job
{

    protected $customer;

    public function __construct(CustomerInterface $customer)
    {
        $this->customer = $customer;
    }

    public function handle(Mailer $mailer, Presenter $presenter)
    {
        $this->customer = $presenter->model($this->customer, CustomerPresenter::class);

        try {

            $mailer->send('website::layouts.emails.account.default.account_update', ['customer' => $this->customer], function ($message) {
                $message
                    ->subject(sprintf('Vinci Vinhos – Atualização de cadastro.'))
                    ->to($this->customer->getEmail(), $this->customer->getName());
            });

        } catch (Exception $e) {

            Log::error(sprintf('Erro ao enviar email de atualização de cadastro: %s', $e->getMessage()));

            throw $e;
        }
    }

}