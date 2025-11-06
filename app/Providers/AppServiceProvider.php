<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //gates en laravel
        Gate::define('see-admin', function (User $user) {
            return $user->role === 'admin';
        });

        Gate::define('see-sales', function (User $user) {
            return in_array($user->role, ['admin', 'user']);
        });
    }
}
