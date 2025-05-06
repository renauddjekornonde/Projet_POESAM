<?php

namespace App\Http\Controllers;

use App\Models\Victime;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class BasicAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.victime.login');
    }

    public function showRegisterForm()
    {
        return view('auth.victime.register');
    }

    public function login(Request $request)
    {
        // Accepter les requêtes GET ou POST
        $credentials = $request->only('email', 'password');

        // Tentative de connexion avec le garde 'victime'
        if (Auth::guard('victime')->attempt($credentials)) {
            $request->session()->regenerate();
            // Stocker le statut d'authentification dans la session
            $request->session()->put('victime_auth', true);
            // Rediriger vers la page d'accueil au lieu du dashboard
            return redirect()->route('home')->with('success', 'Bienvenue !');
        }

        return back()->withErrors([
            'email' => 'Les identifiants fournis ne correspondent pas à nos enregistrements.',
        ])->withInput($request->except('password'));
    }

    public function register(Request $request)
    {
        // Validation simplifiée pour les requêtes GET
        $data = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users', // Vérifier l'unicité dans users, pas victimes
            'telephone' => 'required|string|max:20',
            'adresse' => 'required|string|max:255',
            'password' => 'required|string|min:8',
        ]);

        // Utiliser une transaction pour s'assurer que les deux insertions réussissent
        DB::beginTransaction();
        
        try {
            // Créer d'abord un utilisateur
            $user = User::create([
                'name' => $data['prenom'] . ' ' . $data['nom'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);
            
            // Ensuite créer une victime liée à cet utilisateur
            $victime = Victime::create([
                'nom' => $data['nom'],
                'prenom' => $data['prenom'],
                'id_user' => $user->id,
            ]);
            
            DB::commit();
            
            // Connecter l'utilisateur avec le garde 'victime'
            Auth::guard('victime')->login($user);
            
            // Stocker le statut d'authentification dans la session
            $request->session()->put('victime_auth', true);
            
            // Rediriger vers la page d'accueil au lieu du dashboard
            return redirect()->route('home')->with('success', 'Bienvenue !');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors([
                'email' => 'Une erreur est survenue lors de l\'inscription : ' . $e->getMessage(),
            ])->withInput($request->except('password'));
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('victime')->logout();
        $request->session()->forget('victime_auth');
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
