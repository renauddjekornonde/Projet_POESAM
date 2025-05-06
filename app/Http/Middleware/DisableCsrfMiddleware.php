<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DisableCsrfMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Générer un nouveau jeton CSRF s'il n'existe pas déjà
        if (!Session::has('_token')) {
            Session::regenerateToken();
        }

        // Ajouter le jeton CSRF à la requête pour toutes les méthodes
        $request->request->add(['_token' => Session::token()]);
        
        // Désactiver la vérification CSRF pour cette requête
        $request->attributes->set('middleware.disable_csrf', true);

        return $next($request);
    }
}
