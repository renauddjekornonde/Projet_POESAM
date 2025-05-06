@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('layouts.sidebar', ['userType' => 'organisation'])
        
        <!-- Contenu principal -->
        <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Tableau de bord</h1>
            </div>
            
            @if(request()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ request()->get('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            
            @if(request()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ request()->get('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="alert alert-info">
                        <h5>Bienvenue, {{ session('user_name') }}!</h5>
                        <p>Vous êtes connecté en tant qu'organisation.</p>
                    </div>
                </div>
            </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0">Gestion des cas</h5>
                                </div>
                                <div class="card-body">
                                    <p>Consultez et gérez les cas de violences qui vous sont assignés.</p>
                                    <a href="#" class="btn btn-primary">
                                        <i class="fas fa-folder-open"></i> Voir les cas assignés
                                    </a>
                                    <a href="#" class="btn btn-outline-secondary">
                                        <i class="fas fa-history"></i> Historique des cas
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-info text-white">
                                    <h5 class="mb-0">Statistiques</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <div class="card bg-light">
                                                <div class="card-body text-center">
                                                    <h3 class="display-4">0</h3>
                                                    <p class="text-muted">Cas en cours</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="card bg-light">
                                                <div class="card-body text-center">
                                                    <h3 class="display-4">0</h3>
                                                    <p class="text-muted">Cas résolus</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header bg-warning text-dark">
                                    <h5 class="mb-0">Profil de l'organisation</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6 class="text-muted">Informations de base</h6>
                                            <hr>
                                            <p><strong>Nom:</strong> {{ session('user_name') }}</p>
                                            <p><strong>Email:</strong> {{ session('user_email') }}</p>
                                            <p><strong>Type:</strong> <span class="badge bg-secondary">ONG</span></p>
                                        </div>
                                        <div class="col-md-6">
                                            <h6 class="text-muted">Coordonnées</h6>
                                            <hr>
                                            <p><strong>Adresse:</strong> <em>Non spécifiée</em></p>
                                            <p><strong>Téléphone:</strong> <em>Non spécifié</em></p>
                                            <button class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-edit"></i> Modifier le profil
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
