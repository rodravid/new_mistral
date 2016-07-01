<?php

namespace Vinci\Domain\Order\Events;

use Vinci\App\Core\Jobs\Job;
use Vinci\Domain\Order\OrderInterface;

class OrderStatusMailWasSended extends Job
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

    public function getOrder()
    {
        return $this->order;
    }

    public function getMailSubject()
    {
        return $this->mailSubject;
    }

    public function getMailBody()
    {
        return $this->mailBody;
    }

}