<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Victime;

class UrgentAuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('victime')->attempt($credentials)) {
            // Authentification réussie
            $user = Auth::guard('victime')->user();
            $victime = Victime::where('id_user', $user->id)->first();
            
            if ($victime) {
                session(['is_authenticated' => true]);
                session(['user_name' => $victime->prenom . ' ' . $victime->nom]);
                return redirect('/')->with('success', 'Connexion réussie');
            }
        }

        // Échec de l'authentification
        return redirect('/')->with('error', 'Identifiants incorrects');
    }

    public function logout()
    {
        Auth::guard('victime')->logout();
        session()->forget('is_authenticated');
        session()->forget('user_name');
        return redirect('/');
    }
}
