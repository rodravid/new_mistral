<?php

namespace Vinci\App\Core\Providers;

use Carbon\Carbon;
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
        $this->configureLocale();
    }

    protected function configureDebugBarDoctrineCollector()
    {
        $debugStack = new DebugStack();
        $this->app['em']->getConnection()->getConfiguration()->setSQLLogger($debugStack);
        $this->app['debugbar']->addCollector(new DoctrineCollector($debugStack));
    }

    protected function configureLocale()
    {
        setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
        Carbon::setLocale($this->app->getLocale());
    }

}
