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
        //setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
        Carbon::setLocale($this->app->getLocale());
    }

    private function registerRamseyUuid()
    {
        if (! DBALType::hasType('uuid')) {
            DBALType::addType('uuid', 'Ramsey\Uuid\Doctrine\UuidType');
        }
    }

}
