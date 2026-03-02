<?php

namespace App\Providers;

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
        Gate::before(function ($user) {
            if ($user && $user->hasRole('super_admin')) {
                return true;
            }
            return null;
        });

        Gate::define('permission', function ($user, string $permission) {
            return $user->roles()
                ->whereHas('permissions', fn ($q) => $q->where('name', $permission))
                ->exists();
        });
    }
}
