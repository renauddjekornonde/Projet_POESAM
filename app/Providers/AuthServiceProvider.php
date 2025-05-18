<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Config;

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
        // Définir les routes d'authentification personnalisées
        Config::set('auth.defaults.guard', 'victime');
        
        // Définir les routes de redirection personnalisées
        Config::set('auth.guards.victime.redirects.login', 'victime.login');
        Config::set('auth.guards.victime.redirects.logout', '/');
        Config::set('auth.guards.victime.redirects.home', '/victime/dashboard');
    }
}
