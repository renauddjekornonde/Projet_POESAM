@extends('layouts.app')

@section('content')
<div class="min-vh-100 d-flex align-items-center" style="background: linear-gradient(135deg, #7C3AED 0%, #4F46E5 100%);">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card border-0 shadow-lg">
                    <div class="card-body p-5">
                        <div class="text-center mb-5">
                            <h1 class="display-4 fw-bold text-primary mb-3">Bienvenue</h1>
                            <p class="text-muted mb-0">Connectez-vous à votre espace sécurisé</p>
                        </div>

                        <form action="{{ route('victime.login') }}" method="POST">
                            @csrf
                            <div class="form-floating mb-4">
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                    id="email" name="email" placeholder="nom@exemple.com" 
                                    value="{{ old('email') }}" required>
                                <label for="email">Adresse email</label>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-floating mb-4">
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                    id="password" name="password" placeholder="Mot de passe" required>
                                <label for="password">Mot de passe</label>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                    <label class="form-check-label text-muted" for="remember">Se souvenir de moi</label>
                                </div>
                                <a href="#" class="text-primary text-decoration-none">Mot de passe oublié ?</a>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-3 mb-4">
                                <i class="fas fa-sign-in-alt me-2"></i>Se connecter
                            </button>

                            <p class="text-center mb-0">
                                Vous n'avez pas de compte ? 
                                <a href="{{ route('victime.register') }}" class="text-primary text-decoration-none">
                                    Inscrivez-vous
                                </a>
                            </p>
                        </form>
                    </div>
                </div>

                <!-- Informations supplémentaires -->
                <div class="text-center mt-4 text-white">
                    <p class="mb-0"><i class="fas fa-shield-alt me-2"></i>Espace sécurisé et confidentiel</p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .form-floating > .form-control:focus ~ label,
    .form-floating > .form-control:not(:placeholder-shown) ~ label {
        color: #7C3AED;
    }
    .form-control:focus {
        border-color: #7C3AED;
        box-shadow: 0 0 0 0.25rem rgba(124, 58, 237, 0.25);
    }
    .btn-primary {
        transition: all 0.3s ease;
    }
    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(124, 58, 237, 0.25);
    }
</style>
@endpush
@endsection
