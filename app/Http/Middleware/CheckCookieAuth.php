<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckCookieAuth
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
        // Vérifier si l'utilisateur est connecté via cookies
        if (!isset($_COOKIE['is_logged_in']) || $_COOKIE['is_logged_in'] !== 'true') {
            // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
            return redirect('/direct-login.php')->with('message', 'Veuillez vous connecter pour accéder à cette page');
        }

        // Si l'utilisateur est connecté, mettre à jour la session avec les informations des cookies
        session([
            'user_id' => $_COOKIE['user_id'] ?? null,
            'user_email' => $_COOKIE['user_email'] ?? null,
            'user_name' => $_COOKIE['user_name'] ?? null,
            'user_type' => $_COOKIE['user_type'] ?? null,
            'is_logged_in' => true
        ]);

        return $next($request);
    }
}