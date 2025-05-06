<?php

namespace App\Http\Controllers\Auth\Victime;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Victime\LoginRequest;
use App\Http\Requests\Auth\Victime\RegisterRequest;
use App\Models\Victime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class VictimeAuthController extends Controller
{
    /**
     * Constructor to disable CSRF verification for now
     */
    public function __construct()
    {
        $this->middleware('web')->except(['login', 'register']);
    }
    public function showLoginForm()
    {
        return view('auth.victime.login');
    }

    public function showRegisterForm()
    {
        return view('auth.victime.register');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (Auth::guard('victime')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/victime/dashboard');
        }

        return back()->withErrors([
            'email' => 'Les identifiants fournis ne correspondent pas à nos enregistrements.',
        ])->withInput($request->except('password'));
    }

    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);

        $victime = Victime::create($data);
        Auth::guard('victime')->login($victime);

        return redirect('/victime/dashboard');
    }

    public function logout()
    {
        Auth::guard('victime')->logout();
        return redirect('/');
    }
}
