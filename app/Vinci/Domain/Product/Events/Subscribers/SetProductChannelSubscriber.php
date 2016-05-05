<?php

namespace Vinci\Domain\Product\Events\Subscribers;

use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;

class SetProductChannelSubscriber implements EventSubscriber
{

    public function postLoad(LifecycleEventArgs $event)
    {

        //dd($event->getObject());

    }

    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return array
     */
    public function getSubscribedEvents()
    {
        return [Events::postLoad];
    }

}