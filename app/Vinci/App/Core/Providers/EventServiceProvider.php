<?php

namespace Vinci\App\Core\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'Illuminate\Auth\Events\Login' => [
            'Vinci\App\Website\Auth\Events\Listeners\LinkCustomerToCurrentCart',
        ],

        'Vinci\Domain\Order\Events\NewOrderWasCreated' => [
            'Vinci\Domain\Order\Events\Listeners\FinalizeCustomerShoppingCart',
            'Vinci\Domain\Order\Events\Listeners\CloseCustomerAbandonedCarts',
            'Vinci\Domain\Order\Events\Listeners\ReduceStockOfProducts',
            'Vinci\Domain\Order\Events\Listeners\SendOrderConfirmationMail',
            'Vinci\Domain\Order\Events\Listeners\SendOrderToIntegrationQueue'
        ],

        'Vinci\Domain\Customer\Events\CustomerWasCreated' => [
            'Vinci\Domain\Customer\Events\Listeners\SendCustomerConfirmationMail'
        ],

        'Vinci\Domain\Customer\Events\CustomerWasUpdated' => [
            'Vinci\Domain\Customer\Events\Listeners\SendCustomerAccountUpdateMail'
        ],

        'Vinci\Domain\Customer\Events\CustomerPasswordWasChanged' => [
            'Vinci\Domain\Customer\Events\Listeners\ClearCustomerKeyOnPasswordChange'
        ],

        'Vinci\Domain\Product\Events\ProductWasUpdated' => [
            'Vinci\Domain\Product\Events\Listeners\SendProductToElasticsearchIndexingQueue'
        ]
    ];

    protected $subscribe = [
        'Vinci\Domain\ShoppingCart\Events\Subscribers\ShoppingCartEventSubscriber',
        'Vinci\Domain\Order\Events\Subscribers\OrderStatusSubscriber',
        'Vinci\Domain\ERP\Customer\Events\Listeners\CustomerEventSubscriber',
        'Vinci\Domain\ERP\Order\Events\Listeners\OrderEventSubscriber',
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        //
    }
}
