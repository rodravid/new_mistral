<?php

namespace Vinci\App\Core\Providers;

use Blade;
use Carbon\Carbon;
use Doctrine\DBAL\Types\Type as DBALType;
use Illuminate\Support\ServiceProvider;
use LaravelDoctrine\ORM\Auth\DoctrineUserProvider;
use Validator;
use Vinci\App\Core\Services\Presenter\Presenter;

class AppServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->app['request']->setTrustedProxies(['127.0.0.1', $this->app['request']->server->get('REMOTE_ADDR')]);

        $this->extendAuthManager();

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

        Validator::extend('cpf_cnpj', function($attribute, $value, $parameters) {
            $value = only_numbers($value);

            if (strlen($value) == 11) {
                return validateCpf($value);
            }

            return validateCnpj($value);

        });

        $this->registerCustomDoctrineFunctions();
        $this->registerCustomDoctrineFilters();

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

    protected function extendAuthManager()
    {
        $this->app->make('auth')->provider('doctrine', function ($app, $config) {
            $entity = $config['model'];

            return new DoctrineUserProvider(
                $app['hash'],
                $app['em'],
                $entity
            );
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
        $doctrineConfig->addCustomStringFunction('DAY', 'DoctrineExtensions\Query\Mysql\Day');
        $doctrineConfig->addCustomStringFunction('MONTH', 'DoctrineExtensions\Query\Mysql\Month');
        $doctrineConfig->addCustomStringFunction('YEAR', 'DoctrineExtensions\Query\Mysql\Year');
    }

    private function registerCustomDoctrineFilters()
    {
        $doctrineConfig = $this->app['em']->getConfiguration();
        $doctrineConfig->addFilter('toggleable', 'Vinci\Infrastructure\Doctrine\Filters\ToggleableFilter');
    }

}
