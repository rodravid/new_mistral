<?php

namespace Vinci\App\Core\Providers;

use Validator;
use Illuminate\Support\ServiceProvider;
use Vinci\Domain\User\User;
use Vinci\Domain\User\UserRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('unique_user', function($attribute, $value, $parameters, $validator) {

            //$entityName = ucfirst($parameters[0]);
            //$repository = $this->app->make("Vinci\\Domain\\User\\{$entityName}\\{$entityName}Repository");
            //$user = $repository->findByField($attribute, $value)->first();

            $entityName = "Vinci\\Domain\\" . ucfirst($parameters[0]) . '\\' . ucfirst($parameters[0]);
            $user = $this->app['em']->getRepository(User::class)->findOneBy(['email' => $value]);

            dd($user);


            if (! empty($user)) {

                if (isset($parameters[1])) {
                    return $user->id == $parameters[1];
                }

                return false;
            }

            return true;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {


    }
}
