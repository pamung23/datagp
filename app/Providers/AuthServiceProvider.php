<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('admin-only', function ($user) {
            return $user->level === 'Admin';
        });

        Gate::define('balai-only', function ($user) {
            return $user->level === 'Balai';
        });

        // Gate untuk level Wilayah Cianjur, Wilayah Sukabumi, Wilayah Bogor
        Gate::define('wilayah-only', function ($user) {
            return in_array($user->level, ['Wilayah Cianjur', 'Wilayah Sukabumi', 'Wilayah Bogor']);
        });
    }
}
