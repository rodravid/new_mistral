<?php

namespace Vinci\Domain\Order\Jobs;

use Exception;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Mail\Message;
use Log;
use Vinci\App\Core\Jobs\Job;
use Vinci\Domain\Order\Events\OrderStatusMailWasSended;
use Vinci\Domain\Order\OrderInterface;
use Vinci\Infrastructure\Exceptions\MailingException;

class SendOrderStatusMail extends Job
{

    private $order;

    private $mailSubject;

    private $mailBody;

    public function __construct(OrderInterface $order, $mailSubject, $mailBody)
    {
        $this->order = $order;
        $this->mailSubject = $mailSubject;
        $this->mailBody = $mailBody;
    }

    public function handle(Mailer $mailer, Dispatcher $dispatcher)
    {
        try {

            $mailer->send([], [], function (Message $message) {
                $message
                    ->to($this->order->getCustomer()->getEmail(), $this->order->getCustomer()->getName())
                    ->bcc('pedido@vinci.com.br', 'Vinci')
                    ->subject($this->mailSubject)
                    ->setBody($this->mailBody, 'text/html');
            });

            $dispatcher->fire(new OrderStatusMailWasSended($this->order, $this->mailSubject, $this->mailBody));

        } catch (Exception $e) {

            Log::error(sprintf('Erro ao enviar email de status do pedido: %s', $e->getMessage()));

            throw new MailingException('Não foi possível enviar o email de status do pedido.');
        }
    }

}