<?php

namespace Vinci\App\Core\Providers;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Vinci\App\Core\Services\Presenter\Presenter;

class AppServiceProvider extends ServiceProvider
{

    public function boot()
    {
        \Doctrine\DBAL\Types\Type::addType('uuid', 'Ramsey\Uuid\Doctrine\UuidType');
        $this->app['em']->getConnection()->getDatabasePlatform()->registerDoctrineTypeMapping('uuid', 'uuid');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->configureLocale();

        $this->app->singleton(Presenter::class, function($app) {
            return new Presenter($app);
        });

    }

    protected function configureLocale()
    {
        setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
        Carbon::setLocale($this->app->getLocale());
    }

}
