<?php

namespace Vinci\Domain\Product\Events;

use Illuminate\Support\ServiceProvider;
use Vinci\Domain\Product\Events\Subscribers\SetProductChannelSubscriber;

class EventingServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->app['em']->getEventManager()->addEventSubscriber(
            new SetProductChannelSubscriber
        );
    }

    public function register()
    {
        //
    }
}