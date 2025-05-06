<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminSessionMiddleware
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
        // Vérifier si l'utilisateur est connecté en tant qu'admin via les cookies
        if (isset($_COOKIE['is_logged_in']) && $_COOKIE['is_logged_in'] === 'true' 
            && isset($_COOKIE['user_type']) && $_COOKIE['user_type'] === 'admin') {
            
            // Définir les variables de session pour la barre de navigation
            session([
                'is_logged_in' => true,
                'user_type' => 'admin',
                'user_name' => $_COOKIE['user_name'] ?? 'Administrateur',
                'user_email' => $_COOKIE['user_email'] ?? 'admin@example.com',
                'user_id' => $_COOKIE['user_id'] ?? null
            ]);
            
            return $next($request);
        }
        
        // Rediriger vers la page de connexion si l'utilisateur n'est pas un admin
        return redirect('/direct-login.php');
    }
}
