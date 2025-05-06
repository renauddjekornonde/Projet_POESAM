<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SimpleAuthController extends Controller
{
    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        
        // Récupérer l'utilisateur directement depuis la base de données
        $user = DB::table('users')->where('email', $email)->first();
        
        if ($user && Hash::check($password, $user->password)) {
            // Récupérer les informations de la victime
            $victime = DB::table('victimes')->where('id_user', $user->id)->first();
            
            if ($victime) {
                // Stocker les informations dans la session
                session(['user_id' => $user->id]);
                session(['user_email' => $user->email]);
                session(['user_name' => $victime->prenom . ' ' . $victime->nom]);
                session(['is_logged_in' => true]);
                
                return redirect('/simple-dashboard');
            }
        }
        
        // Échec de l'authentification
        return redirect('/simple-login')->with('error', 'Identifiants incorrects');
    }
    
    public function showLoginForm()
    {
        return view('simple.login');
    }
    
    public function showDashboard()
    {
        if (!session('is_logged_in')) {
            return redirect('/simple-login');
        }
        
        return view('simple.dashboard');
    }
    
    public function logout()
    {
        session()->forget(['user_id', 'user_email', 'user_name', 'is_logged_in']);
        return redirect('/simple-login');
    }
}
