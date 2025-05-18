<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class NoVerifyCsrfToken
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Passe directement la requête au middleware suivant sans vérification CSRF
        return $next($request);
    }
}
