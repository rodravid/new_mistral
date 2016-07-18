<?php

namespace Vinci\Domain\ERP;

use Illuminate\Contracts\Events\Dispatcher;
use Vinci\Infrastructure\ERP\EnvelopeFactory;

abstract class BaseErpService
{

    protected $envelopeFactory;

    protected $eventDispatcher;

    public function __construct(EnvelopeFactory $envelopeFactory, Dispatcher $eventDispatcher)
    {
        $this->envelopeFactory = $envelopeFactory;
        $this->eventDispatcher = $eventDispatcher;
    }

    protected function dispatchEvents($model)
    {
        foreach ($model->releaseEvents() as $event) {
            $this->eventDispatcher->fire($event);
        }
    }

}