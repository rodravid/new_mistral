<?php

namespace Vinci\Domain\Customer\Jobs;

use Exception;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Log;
use Vinci\App\Core\Jobs\Job;
use Vinci\App\Core\Services\Presenter\Presenter;
use Vinci\App\Website\Http\Customer\Presenters\CustomerPresenter;
use Vinci\Domain\Customer\CustomerRepository;

class SendCustomerConfirmationMail extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $customer;

    public function __construct($customer)
    {
        $this->customer = $customer;
    }

    public function handle(Mailer $mailer, Presenter $presenter, CustomerRepository $customerRepository)
    {

        $this->customer = $presenter->model($customerRepository->findOrFail($this->customer), CustomerPresenter::class);

        try {

            $mailer->send('website::layouts.emails.account.default.new_account', ['customer' => $this->customer], function ($message) {
                $message
                    ->subject(sprintf('Vinci Vinhos – Confirmação de cadastro.'))
                    ->to($this->customer->getEmail(), $this->customer->getName());
            });

        } catch (Exception $e) {

            Log::error(sprintf('Erro ao enviar email de confirmacao de cadastro: %s', $e->getMessage()));

            throw $e;
            
        } finally {
            app('em')->clear();
        }
    }

}