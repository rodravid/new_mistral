<?php

namespace Vinci\App\Core\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Vinci\Domain\Auth\AuthService;
use Vinci\Domain\User\UserRepository;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'Vinci\Model' => 'Vinci\Policies\ModelPolicy',
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        Auth::provider('repository', function($app, array $config) {
            return $app->make($config['class']);
        });

    }


    public function register()
    {

        $this->app->singleton(AuthService::class, function($app) {
            return new AuthService($app['auth'], $app->make(UserRepository::class));
        });

    }

}
