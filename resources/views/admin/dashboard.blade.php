@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('layouts.sidebar', ['userType' => 'admin'])
        
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
                        <p>Vous êtes connecté en tant qu'administrateur du système.</p>
                    </div>
                </div>
            </div>
            
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="me-3 rounded-circle p-3" style="background-color: rgba(52, 152, 219, 0.1);">
                                    <i class="fas fa-building fa-2x text-primary"></i>
                                </div>
                                <h5 class="mb-0">Organisations</h5>
                            </div>
                            <h2 class="mb-0">0</h2>
                            <div class="mt-2 text-muted small">
                                <span class="text-success"><i class="fas fa-arrow-up"></i> 0%</span> depuis le mois dernier
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="me-3 rounded-circle p-3" style="background-color: rgba(46, 204, 113, 0.1);">
                                    <i class="fas fa-users fa-2x text-success"></i>
                                </div>
                                <h5 class="mb-0">Victimes</h5>
                            </div>
                            <h2 class="mb-0">0</h2>
                            <div class="mt-2 text-muted small">
                                <span class="text-success"><i class="fas fa-arrow-up"></i> 0%</span> depuis le mois dernier
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="me-3 rounded-circle p-3" style="background-color: rgba(52, 152, 219, 0.1);">
                                    <i class="fas fa-file-alt fa-2x text-info"></i>
                                </div>
                                <h5 class="mb-0">Cas signalés</h5>
                            </div>
                            <h2 class="mb-0">0</h2>
                            <div class="mt-2 text-muted small">
                                <span class="text-success"><i class="fas fa-arrow-up"></i> 0%</span> depuis le mois dernier
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-white py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Liste des organisations</h5>
                                <a href="/admin/create-organisation" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i> Ajouter</a>
                            </div>
                        </div>
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
                                        @if(isset($organisations) && count($organisations) > 0)
                                            @foreach($organisations as $organisation)
                                            <tr>
                                                <td>{{ $organisation['nom_organisation'] ?? 'N/A' }}</td>
                                                <td>{{ $organisation['type_organisation'] ?? 'N/A' }}</td>
                                                <td>{{ $organisation['email'] ?? 'N/A' }}</td>
                                                <td>{{ $organisation['telephone_organisation'] ?? 'N/A' }}</td>
                                                <td>{{ \Carbon\Carbon::parse($organisation['date_creation'] ?? now())->format('d/m/Y H:i') }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="/admin/show-organisation/{{ $organisation['id'] }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i></a>
                                                        <a href="/admin/delete-organisation/{{ $organisation['id'] }}" class="btn btn-sm btn-outline-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette organisation ?')"><i class="fas fa-trash"></i></a>
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
            
            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0">Activité récente</h5>
                        </div>
                        <div class="card-body">
                            <div class="timeline">
                                <div class="timeline-item pb-3">
                                    <div class="d-flex">
                                        <div class="timeline-icon me-3 rounded-circle p-2" style="background-color: rgba(52, 152, 219, 0.1);">
                                            <i class="fas fa-user text-primary"></i>
                                        </div>
                                        <div>
                                            <p class="mb-0">Aucune activité récente à afficher</p>
                                            <small class="text-muted">-</small>
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
