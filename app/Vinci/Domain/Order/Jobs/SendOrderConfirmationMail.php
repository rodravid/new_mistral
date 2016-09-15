<?php

namespace Vinci\Domain\Order\Jobs;

use Exception;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Message;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Log;
use Vinci\App\Core\Jobs\Job;
use Vinci\App\Core\Services\Presenter\Presenter;
use Vinci\App\Website\Http\Order\Presenter\OrderPresenter;
use Vinci\Domain\Order\OrderRepository;

class SendOrderConfirmationMail extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $orderId;

    public function __construct($orderId)
    {
        $this->orderId = $orderId;
    }

    public function handle(Mailer $mailer, Presenter $presenter, OrderRepository $orderRepository)
    {
        try {

            $order = $orderRepository->getOneById($this->orderId);

            $order = $presenter->model($order, OrderPresenter::class);

            $mailer->send('website::layouts.emails.order.default.created', compact('order'), function (Message $message) use ($order) {

                $message
                    ->subject(sprintf('Vinci Vinhos - Confirmação de Pedido nº %s', $order->getNumber()))
                    ->to($order->getCustomer()->getEmail(), $order->getCustomer()->getName());

                list($bccAddress, $bccName) = $this->getBccAddress();

                $message->bcc($bccAddress, $bccName);

            });

        } catch (Exception $e) {

            Log::error(sprintf('Erro ao enviar email de confirmacao de pedido: %s', $e->getMessage()));

            throw $e;

        } finally {
            app('em')->clear();
        }
    }

    private function getBccAddress()
    {
        return app()->environment('production') ?
            ['pedido@vinci.com.br', 'Vinci'] : ['tcavallini@webeleven.com.br', 'Thiago'];
    }

}