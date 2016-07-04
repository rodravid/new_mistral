<?php

namespace Vinci\App\Core\Providers;

use Blade;
use Carbon\Carbon;
use Doctrine\DBAL\Types\Type as DBALType;
use Illuminate\Support\ServiceProvider;
use Validator;
use Vinci\App\Core\Services\Presenter\Presenter;

class AppServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->registerRamseyUuid();

        Blade::directive('isProductFavorited', function($expression) {
            return sprintf('<?php echo app("product.favorite.service")->productIsFavoritedByCustomer(with%s, auth("website")->getUser()); ?>', $expression);
        });

        Validator::extend('cpf', function($attribute, $value, $parameters) {
            return validateCpf($value);
        });

        Validator::extend('cnpj', function($attribute, $value, $parameters) {
            return validateCnpj($value);
        });

        $this->registerCustomDoctrineFunctions();

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
        Carbon::setLocale($this->app->getLocale());
    }

    private function registerRamseyUuid()
    {
        if (! DBALType::hasType('uuid')) {
            DBALType::addType('uuid', 'Ramsey\Uuid\Doctrine\UuidType');
        }
    }

    private function registerCustomDoctrineFunctions()
    {
        $doctrineConfig = $this->app['em']->getConfiguration();
        
        $doctrineConfig->addCustomStringFunction('RAND', 'DoctrineExtensions\Query\Mysql\Rand');
        $doctrineConfig->addCustomStringFunction('FIELD', 'DoctrineExtensions\Query\Mysql\Field');
    }

}
