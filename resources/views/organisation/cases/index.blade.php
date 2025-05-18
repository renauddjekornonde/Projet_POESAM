@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('layouts.sidebar', ['userType' => 'organisation'])

        <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Gestion des Cas</h1>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCaseModal">
                    <i class="fas fa-plus"></i> Nouveau cas
                </button>
            </div>

            <!-- Filtres -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <select class="form-select" id="statusFilter">
                                        <option value="">Tous les statuts</option>
                                        <option value="en_cours">En cours</option>
                                        <option value="résolu">Résolu</option>
                                        <option value="en_attente">En attente</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select class="form-select" id="typeFilter">
                                        <option value="">Tous les types</option>
                                        <option value="harcèlement">Harcèlement</option>
                                        <option value="agression">Agression</option>
                                        <option value="discrimination">Discrimination</option>
                                        <option value="autre">Autre</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Liste des cas -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Titre</th>
                                            <th>Type</th>
                                            <th>Statut</th>
                                            <th>Date de création</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($cases as $case)
                                        <tr>
                                            <td>#{{ $case->id }}</td>
                                            <td>{{ $case->title }}</td>
                                            <td>
                                                <span class="badge bg-info">{{ $case->type }}</span>
                                            </td>
                                            <td>
                                                @if($case->status === 'en_cours')
                                                    <span class="badge bg-warning">En cours</span>
                                                @elseif($case->status === 'résolu')
                                                    <span class="badge bg-success">Résolu</span>
                                                @else
                                                    <span class="badge bg-secondary">En attente</span>
                                                @endif
                                            </td>
                                            <td>{{ $case->created_at->format('d/m/Y H:i') }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary me-1" title="Voir les détails">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-primary me-1" title="Modifier">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-danger" title="Supprimer">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center">Aucun cas enregistré</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal pour ajouter un cas -->
<div class="modal fade" id="addCaseModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nouveau cas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addCaseForm">
                    <div class="mb-3">
                        <label class="form-label">Titre</label>
                        <input type="text" class="form-control" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Type</label>
                        <select class="form-select" name="type" required>
                            <option value="harcèlement">Harcèlement</option>
                            <option value="agression">Agression</option>
                            <option value="discrimination">Discrimination</option>
                            <option value="autre">Autre</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Statut</label>
                        <select class="form-select" name="status" required>
                            <option value="en_attente">En attente</option>
                            <option value="en_cours">En cours</option>
                            <option value="résolu">Résolu</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary" onclick="submitCase()">Enregistrer</button>
            </div>
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
</style>
@endsection

@section('scripts')
<script>
function submitCase() {
    const form = document.getElementById('addCaseForm');
    const formData = new FormData(form);

    fetch('/organisation/cases', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(Object.fromEntries(formData))
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Erreur lors de l\'enregistrement du cas');
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        alert('Une erreur est survenue');
    });
}

// Filtres
document.getElementById('statusFilter').addEventListener('change', applyFilters);
document.getElementById('typeFilter').addEventListener('change', applyFilters);

function applyFilters() {
    const status = document.getElementById('statusFilter').value;
    const type = document.getElementById('typeFilter').value;

    // Implémenter la logique de filtrage ici
    // Vous pouvez soit recharger la page avec des paramètres de requête
    // soit filtrer les éléments existants en JavaScript
}
</script>
@endsection
