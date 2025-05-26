<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind('abilities', function () {
            return include base_path('data/abilities.php');
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {

        Gate::before(function ($user, $ability) {
            if ($user->super_admin) {
                return true;
            }
        });


        foreach ($this->app->make('abilities') as $code => $label) {
            Gate::define($code, function ($user) use ($code) {
                return $user->hasAbility($code);
            });
        }

        // Gate::define('categories', function ($user) {
        //     return false;
        // });

        // Gate::define('update-category', function ($user) {
        //     return true;
        // });

        // Gate::define('create-category', function ($user) {
        //     return true;
        // });
        // Gate::define('delete-category', function ($user) {
        //     return true;
        // });
    }
}
