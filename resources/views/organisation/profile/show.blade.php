@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('layouts.sidebar', ['userType' => 'organisation'])

        <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Profil de l'Organisation</h1>
            </div>

            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if(!$organisation)
                <div class="alert alert-warning">
                    Aucune organisation trouvée pour cet utilisateur.
                </div>
            @else
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('organisation.profile.update') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="mb-3">
                                        <label for="name" class="form-label">Nom de l'organisation</label>
                                        <input type="text" class="form-control" id="name" name="name" value="{{ $organisation->name }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" value="{{ $organisation->email }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Téléphone</label>
                                        <input type="tel" class="form-control" id="phone" name="phone" value="{{ $organisation->phone }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="address" class="form-label">Adresse</label>
                                        <textarea class="form-control" id="address" name="address" rows="3">{{ $organisation->address }}</textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea class="form-control" id="description" name="description" rows="5">{{ $organisation->description }}</textarea>
                                    </div>

                                    <div class="mb-4">
                                        <label for="logo" class="form-label">Logo de l'organisation</label>
                                        <input type="file" class="form-control" id="logo" name="logo" accept="image/*">
                                        @if($organisation->logo)
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/' . $organisation->logo) }}" alt="Logo" class="img-thumbnail" style="max-height: 100px;">
                                        </div>
                                        @endif
                                    </div>

                                    <div class="mb-3">
                                        <label for="new_password" class="form-label">Nouveau mot de passe (laisser vide si inchangé)</label>
                                        <input type="password" class="form-control" id="new_password" name="new_password">
                                    </div>

                                    <div class="mb-4">
                                        <label for="new_password_confirmation" class="form-label">Confirmer le nouveau mot de passe</label>
                                        <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation">
                                    </div>

                                    <button type="submit" class="btn btn-primary">Mettre à jour le profil</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Statistiques du profil</h5>
                                <ul class="list-unstyled">
                                    <li class="mb-2">
                                        <i class="fas fa-folder me-2"></i>
                                        Total des cas : <span class="fw-bold">{{ $stats['total_cases'] ?? 0 }}</span>
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-clock me-2"></i>
                                        Membre depuis : <span class="fw-bold">{{ $organisation->created_at }}</span>
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-check-circle me-2"></i>
                                        Cas résolus : <span class="fw-bold">{{ $stats['resolved_cases'] ?? 0 }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    :root {
        --primary-color: #8A2BE2;
        --secondary-color: #F8F9FA;
        --text-color: #333333;
    }

    .card {
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        margin-bottom: 1rem;
    }

    .btn-primary {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .btn-primary:hover {
        background-color: #7024b7;
        border-color: #7024b7;
    }
</style>
@endsection
