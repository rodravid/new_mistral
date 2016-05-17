<?php

namespace Vinci\Domain\Product\Events\Subscribers;

use Vinci\Domain\Channel\Contracts\ChannelProvider;

class SetCurrentChannelSubscriber
{

    private $channelProvider;

    public function __construct(ChannelProvider $channelProvider)
    {
        $this->channelProvider = $channelProvider;
    }

    public function onProductLoaded($event)
    {
        $product = $event->product;

        $product->setCurrentChannel($this->channelProvider->getChannel());
    }

    public function subscribe($events)
    {
        $events->listen(
            'Vinci\Domain\Product\Events\ProductWasLoaded',
            'Vinci\Domain\Product\Events\Subscribers\SetCurrentChannelSubscriber@onProductLoaded'
        );
    }

}