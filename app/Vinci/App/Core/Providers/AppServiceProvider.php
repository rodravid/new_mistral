<?php

namespace Vinci\App\Core\Providers;

use DebugBar\Bridge\DoctrineCollector;
use Doctrine\DBAL\Logging\DebugStack;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureDebugBarDoctrineCollector();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public function configureDebugBarDoctrineCollector()
    {
        $debugStack = new DebugStack();
        $this->app['em']->getConnection()->getConfiguration()->setSQLLogger($debugStack);
        $this->app['debugbar']->addCollector(new DoctrineCollector($debugStack));
    }
}
