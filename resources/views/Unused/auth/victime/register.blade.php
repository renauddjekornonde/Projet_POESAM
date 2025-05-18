@extends('layouts.app')

@section('content')
<div class="min-vh-100 d-flex align-items-center" style="background: linear-gradient(135deg, #7C3AED 0%, #4F46E5 100%);">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card border-0 shadow-lg">
                    <div class="card-body p-5">
                        <div class="text-center mb-5">
                            <h1 class="display-4 fw-bold text-primary mb-3">Rejoignez-nous</h1>
                            <p class="text-muted mb-0">Créez votre compte pour accéder à un espace sécurisé</p>
                        </div>

                        <form action="{{ route('victime.register') }}" method="POST">
                            @csrf
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control @error('nom') is-invalid @enderror" 
                                            id="nom" name="nom" placeholder="Votre nom" 
                                            value="{{ old('nom') }}" required>
                                        <label for="nom">Nom</label>
                                        @error('nom')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control @error('prenom') is-invalid @enderror" 
                                            id="prenom" name="prenom" placeholder="Votre prénom" 
                                            value="{{ old('prenom') }}" required>
                                        <label for="prenom">Prénom</label>
                                        @error('prenom')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

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
                                <input type="tel" class="form-control @error('telephone') is-invalid @enderror" 
                                    id="telephone" name="telephone" placeholder="Téléphone" 
                                    value="{{ old('telephone') }}" required>
                                <label for="telephone">Téléphone</label>
                                @error('telephone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-floating mb-4">
                                <input type="text" class="form-control @error('adresse') is-invalid @enderror" 
                                    id="adresse" name="adresse" placeholder="Votre adresse" 
                                    value="{{ old('adresse') }}" required>
                                <label for="adresse">Adresse</label>
                                @error('adresse')
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

                            <div class="form-floating mb-4">
                                <input type="password" class="form-control" 
                                    id="password_confirmation" name="password_confirmation" 
                                    placeholder="Confirmer le mot de passe" required>
                                <label for="password_confirmation">Confirmer le mot de passe</label>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-3 mb-4">
                                <i class="fas fa-user-plus me-2"></i>Créer mon compte
                            </button>

                            <p class="text-center mb-0">
                                Vous avez déjà un compte ? 
                                <a href="{{ route('victime.login') }}" class="text-primary text-decoration-none">
                                    Connectez-vous
                                </a>
                            </p>
                        </form>
                    </div>
                </div>

                <!-- Informations de sécurité -->
                <div class="text-center mt-4 text-white">
                    <div class="row justify-content-center">
                        <div class="col-auto">
                            <p class="mb-0"><i class="fas fa-shield-alt me-2"></i>Espace sécurisé</p>
                        </div>
                        <div class="col-auto">
                            <p class="mb-0"><i class="fas fa-lock me-2"></i>Données protégées</p>
                        </div>
                        <div class="col-auto">
                            <p class="mb-0"><i class="fas fa-user-secret me-2"></i>Anonymat respecté</p>
                        </div>
                    </div>
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
    .card {
        border-radius: 1rem;
    }
    .form-floating > .form-control {
        border-radius: 0.5rem;
    }
</style>
@endpush
@endsection
