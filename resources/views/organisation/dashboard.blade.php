@extends('layouts.app')

@section('styles')
<style>
    :root {
        --primary-color: #8A2BE2;
        --secondary-color: #F8F9FA;
        --text-color: #333333;
    }

    .custom-card {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        transition: all 0.3s ease;
        border: 1px solid #E9ECEF;
    }

    .custom-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(138, 43, 226, 0.1);
    }

    .custom-card .card-header {
        background-color: var(--primary-color);
        color: white;
        border-bottom: none;
    }

    .btn-primary {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .btn-primary:hover {
        background-color: #7024b7;
        border-color: #7024b7;
    }

    .btn-outline-primary {
        color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .btn-outline-primary:hover {
        background-color: var(--primary-color);
        color: white;
    }

    .custom-alert {
        background-color: var(--secondary-color);
        border-left: 4px solid var(--primary-color);
        color: var(--text-color);
    }

    .list-group-item {
        border-left: 4px solid transparent;
        transition: all 0.2s ease;
    }

    .list-group-item:hover {
        border-left-color: var(--primary-color);
        background-color: var(--secondary-color);
    }

    .badge.bg-primary {
        background-color: var(--primary-color) !important;
    }

    .table th {
        background-color: var(--secondary-color);
    }
</style>
@endsection

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

            <!-- Section Bienvenue -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="alert custom-alert">
                        <h5>Bienvenue, {{ session('user_name') }}!</h5>
                        <p>Vous êtes connecté en tant qu'organisation.</p>
                    </div>
                </div>
            </div>

            <!-- Section Ressources Partagées -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card custom-card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Ressources Partagées</h5>
                            <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#addResourceModal">
                                <i class="fas fa-plus"></i> Ajouter une ressource
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Titre</th>
                                            <th>Type</th>
                                            <th>Date de publication</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($resources ?? [] as $resource)
                                        <tr data-resource-id="{{ $resource->id }}">
                                            <td>{{ $resource->title }}</td>
                                            <td>{{ $resource->type }}</td>
                                            <td>{{ $resource->created_at->format('d/m/Y') }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i></button>
                                                <button class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></button>
                                                <button class="btn btn-sm btn-outline-primary"><i class="fas fa-trash"></i></button>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4" class="text-center">Aucune ressource disponible</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section Gestion des Cas -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card custom-card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Gestion des Cas</h5>
                            <div>
                                <a href="{{ route('organisation.cases.index') }}" class="btn btn-light btn-sm me-2">
                                    <i class="fas fa-folder-open"></i> Voir tous les cas
                                </a>
                                <button id="viewStatisticsBtn" class="btn btn-light btn-sm">
                                    <i class="fas fa-chart-bar"></i> Statistiques
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="statisticsContainer" class="row" style="display: none;">
                                <div class="col-md-3">
                                    <div class="card bg-primary text-white">
                                        <div class="card-body">
                                            <h6>Total des cas</h6>
                                            <h3 id="totalCases">-</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-warning text-white">
                                        <div class="card-body">
                                            <h6>En cours</h6>
                                            <h3 id="inProgressCases">-</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-success text-white">
                                        <div class="card-body">
                                            <h6>Résolus</h6>
                                            <h3 id="resolvedCases">-</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-info text-white">
                                        <div class="card-body">
                                            <h6>Ce mois</h6>
                                            <h3 id="thisMonthCases">-</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section Consultations et Événements -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card custom-card">
                        <div class="card-header">
                            <h5 class="mb-0">Consultations avec les Victimes</h5>
                        </div>
                        <div class="card-body">
                            <div class="list-group">
                                @forelse($consultations ?? [] as $consultation)
                                <div class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">Consultation #{{ $consultation->id }}</h6>
                                        <small>{{ $consultation->date->format('d/m/Y H:i') }}</small>
                                    </div>
                                    <p class="mb-1">{{ $consultation->victim_name }}</p>
                                    <small class="text-muted">Statut: {{ $consultation->status }}</small>
                                </div>
                                @empty
                                <div class="list-group-item">Aucune consultation programmée</div>
                                @endforelse
                            </div>
                            <div class="mt-3">
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addConsultationModal">
                                    <i class="fas fa-calendar-plus"></i> Nouvelle consultation
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card custom-card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Événements</h5>
                            <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#addEventModal">
                                <i class="fas fa-plus"></i> Créer un événement
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="list-group">
                                @forelse($events ?? [] as $event)
                                <div class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">{{ $event->title }}</h6>
                                        <small>{{ $event->date->format('d/m/Y') }}</small>
                                    </div>
                                    <p class="mb-1">{{ Str::limit($event->description, 100) }}</p>
                                    <small class="text-muted">{{ $event->location }}</small>
                                </div>
                                @empty
                                <div class="list-group-item">Aucun événement planifié</div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section Annonces -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card custom-card">
                        <div class="card-header">
                            <h5 class="mb-0">Annonces et Interactions</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @forelse($announcements ?? [] as $announcement)
                                <div class="col-md-4 mb-3">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <h6 class="card-title">{{ $announcement->title }}</h6>
                                            <p class="card-text">{{ Str::limit($announcement->content, 150) }}</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <small class="text-muted">{{ $announcement->created_at->diffForHumans() }}</small>
                                                <button class="btn btn-sm btn-outline-primary">Répondre</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <div class="col-12">
                                    <p class="text-center">Aucune annonce disponible</p>
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section Profil -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card custom-card">
                        <div class="card-header">
                            <h5 class="mb-0">Profil de l'organisation</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="text-muted">Informations de base</h6>
                                    <hr>
                                    <p><strong>Nom:</strong> {{ session('user_name') }}</p>
                                    <p><strong>Email:</strong> {{ session('user_email') }}</p>
                                    <p><strong>Type:</strong> <span class="badge bg-primary">ONG</span></p>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-muted">Coordonnées</h6>
                                    <hr>
                                    <p><strong>Adresse:</strong> <em>{{ $organisation->address ?? 'Non spécifiée' }}</em></p>
                                    <p><strong>Téléphone:</strong> <em>{{ $organisation->phone ?? 'Non spécifié' }}</em></p>
                                    <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editProfileModal">
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

<!-- Modals -->
@include('organisation.modals.add-resource')
@include('organisation.modals.add-consultation')
@include('organisation.modals.add-event')
@include('organisation.modals.edit-profile')
@include('organisation.modals.event-modal')

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const viewStatisticsBtn = document.getElementById('viewStatisticsBtn');
    const statisticsContainer = document.getElementById('statisticsContainer');
    let statisticsVisible = false;

    viewStatisticsBtn.addEventListener('click', function() {
        if (!statisticsVisible) {
            statisticsContainer.style.display = 'flex';
            fetch('{{ route("organisation.cases.statistics") }}')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('totalCases').textContent = data.total;
                    document.getElementById('inProgressCases').textContent = data.in_progress;
                    document.getElementById('resolvedCases').textContent = data.resolved;
                    document.getElementById('thisMonthCases').textContent = data.this_month;
                })
                .catch(error => {
                    console.error('Erreur lors du chargement des statistiques:', error);
                    alert('Une erreur est survenue lors du chargement des statistiques.');
                });
        } else {
            statisticsContainer.style.display = 'none';
        }
        statisticsVisible = !statisticsVisible;
    });

    document.querySelectorAll('.table').forEach(table => {
        table.addEventListener('click', function(e) {
            const target = e.target.closest('button');
            if (!target) return;

            const row = target.closest('tr');
            const resourceId = row.dataset.resourceId;
            const resourceTitle = row.querySelector('td:first-child').textContent;

            if (target.querySelector('.fa-eye')) {
                window.location.href = `/organisation/resources/${resourceId}`;
            } else if (target.querySelector('.fa-edit')) {
                window.location.href = `/organisation/resources/${resourceId}/edit`;
            } else if (target.querySelector('.fa-trash')) {
                if (confirm(`Êtes-vous sûr de vouloir supprimer la ressource "${resourceTitle}" ?`)) {
                    fetch(`/organisation/resources/${resourceId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            row.remove();
                            alert('Ressource supprimée avec succès');
                        } else {
                            alert('Erreur lors de la suppression de la ressource');
                        }
                    })
                    .catch(error => {
                        console.error('Erreur:', error);
                        alert('Une erreur est survenue lors de la suppression');
                    });
                }
            }
        });
    });
});
</script>
@endsection
