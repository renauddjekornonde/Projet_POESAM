@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('layouts.sidebar', ['userType' => 'admin'])

        <!-- Contenu principal -->
        <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Liste des organisations</h1>
                <a href="/admin/create-organisation" class="btn btn-primary"><i class="fas fa-plus-circle me-2"></i> Ajouter une organisation</a>
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

            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Type</th>
                                    <th>Email</th>
                                    <th>Téléphone</th>
                                    <th>Date de création</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($organisations) > 0)
                                    @foreach($organisations as $organisation)
                                    <tr>
                                        <td>{{ $organisation->nom ?? 'N/A' }}</td>
                                        <td>{{ $organisation->type ?? 'N/A' }}</td>
                                        <td>{{ $organisation->email ?? 'N/A' }}</td>
                                        <td>{{ $organisation->telephone ?? 'N/A' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($organisation->date_creation ?? now())->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="/admin/show-organisation/{{ $organisation->id }}" class="btn btn-sm btn-outline-primary" title="Voir les détails"><i class="fas fa-eye"></i></a>
                                                <button type="button" class="btn btn-sm btn-outline-danger" title="Supprimer" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $organisation->id }}"><i class="fas fa-trash"></i></button>
                                            </div>

                                            <!-- Modal de confirmation de suppression -->
                                            <div class="modal fade" id="deleteModal{{ $organisation->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $organisation->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="deleteModalLabel{{ $organisation->id }}">Confirmer la suppression</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Êtes-vous sûr de vouloir supprimer l'organisation <strong>{{ $organisation->nom }}</strong> ? Cette action est irréversible.
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                            <a href="/admin/delete-organisation/{{ $organisation->id }}" class="btn btn-danger">Supprimer</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted">Aucune organisation à afficher</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
