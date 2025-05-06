@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('layouts.sidebar', ['userType' => 'admin'])
        
        <!-- Contenu principal -->
        <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Détails de l'organisation</h1>
                <div>
                    <a href="/admin/organisations" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-arrow-left me-2"></i> Retour
                    </a>
                </div>
            </div>
            
            @if(request()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ request()->get('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            
            <div class="row">
                <div class="col-md-8">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0">Informations générales</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-3 fw-bold">Nom de l'organisation</div>
                                <div class="col-md-7">{{ $organisation['nom_organisation'] ?? 'N/A' }}</div>
                                <div class="col-md-2 text-end">
                                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#updateNomModal">
                                        <i class="fas fa-edit"></i> Modifier
                                    </button>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-3 fw-bold">Type d'organisation</div>
                                <div class="col-md-7">{{ $organisation['type_organisation'] ?? 'N/A' }}</div>
                                <div class="col-md-2 text-end">
                                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#updateTypeModal">
                                        <i class="fas fa-edit"></i> Modifier
                                    </button>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-3 fw-bold">Email</div>
                                <div class="col-md-7">{{ $organisation['email'] ?? 'N/A' }}</div>
                                <div class="col-md-2 text-end">
                                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#updateEmailModal">
                                        <i class="fas fa-edit"></i> Modifier
                                    </button>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-3 fw-bold">Téléphone</div>
                                <div class="col-md-7">{{ $organisation['telephone_organisation'] ?? 'N/A' }}</div>
                                <div class="col-md-2 text-end">
                                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#updateTelephoneModal">
                                        <i class="fas fa-edit"></i> Modifier
                                    </button>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-3 fw-bold">Adresse</div>
                                <div class="col-md-7">{{ $organisation['adresse_organisation'] ?? 'N/A' }}</div>
                                <div class="col-md-2 text-end">
                                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#updateAdresseModal">
                                        <i class="fas fa-edit"></i> Modifier
                                    </button>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4 fw-bold">Date de création</div>
                                <div class="col-md-8">{{ \Carbon\Carbon::parse($organisation['date_creation'])->format('d/m/Y H:i') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0">Actions</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteOrganisationModal">
                                    <i class="fas fa-trash me-2"></i> Supprimer l'organisation
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Modales pour la modification rapide -->
<!-- Modal pour modifier le nom -->
<div class="modal fade" id="updateNomModal" tabindex="-1" aria-labelledby="updateNomModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateNomModalLabel">Modifier le nom</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="nom_organisation_modal" class="form-label">Nom de l'organisation</label>
                    <input type="text" class="form-control" id="nom_organisation_modal" value="{{ $organisation['nom_organisation'] }}">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <a href="#" onclick="updateField('nom_organisation')" class="btn btn-primary">Enregistrer</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal pour modifier le type -->
<div class="modal fade" id="updateTypeModal" tabindex="-1" aria-labelledby="updateTypeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateTypeModalLabel">Modifier le type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="type_organisation_modal" class="form-label">Type d'organisation</label>
                    <select class="form-select" id="type_organisation_modal">
                        <option value="ONG" {{ $organisation['type_organisation'] == 'ONG' ? 'selected' : '' }}>ONG</option>
                        <option value="Association" {{ $organisation['type_organisation'] == 'Association' ? 'selected' : '' }}>Association</option>
                        <option value="Entreprise" {{ $organisation['type_organisation'] == 'Entreprise' ? 'selected' : '' }}>Entreprise</option>
                        <option value="Autre" {{ $organisation['type_organisation'] == 'Autre' ? 'selected' : '' }}>Autre</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <a href="#" onclick="updateField('type_organisation')" class="btn btn-primary">Enregistrer</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal pour modifier l'email -->
<div class="modal fade" id="updateEmailModal" tabindex="-1" aria-labelledby="updateEmailModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateEmailModalLabel">Modifier l'email</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="email_modal" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email_modal" value="{{ $organisation['email'] }}">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <a href="#" onclick="updateField('email')" class="btn btn-primary">Enregistrer</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal pour modifier le téléphone -->
<div class="modal fade" id="updateTelephoneModal" tabindex="-1" aria-labelledby="updateTelephoneModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateTelephoneModalLabel">Modifier le téléphone</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="telephone_organisation_modal" class="form-label">Téléphone</label>
                    <input type="text" class="form-control" id="telephone_organisation_modal" value="{{ $organisation['telephone_organisation'] }}">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <a href="#" onclick="updateField('telephone_organisation')" class="btn btn-primary">Enregistrer</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal pour modifier l'adresse -->
<div class="modal fade" id="updateAdresseModal" tabindex="-1" aria-labelledby="updateAdresseModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateAdresseModalLabel">Modifier l'adresse</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="adresse_organisation_modal" class="form-label">Adresse</label>
                    <textarea class="form-control" id="adresse_organisation_modal" rows="3">{{ $organisation['adresse_organisation'] }}</textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <a href="#" onclick="updateField('adresse_organisation')" class="btn btn-primary">Enregistrer</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmation de suppression -->
<div class="modal fade" id="deleteOrganisationModal" tabindex="-1" aria-labelledby="deleteOrganisationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteOrganisationModalLabel">Confirmer la suppression</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Êtes-vous sûr de vouloir supprimer l'organisation <strong>{{ $organisation['nom_organisation'] }}</strong> ? Cette action est irréversible.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <a href="/admin/delete-organisation/{{ $organisation['id'] }}" class="btn btn-danger">Supprimer</a>
            </div>
        </div>
    </div>
</div>

<script>
function updateField(fieldName) {
    // Récupérer la valeur du champ
    let value = document.getElementById(fieldName + '_modal').value;
    
    // Valider la valeur
    if (!value && fieldName !== 'adresse_organisation') {
        alert('Ce champ ne peut pas être vide');
        return;
    }
    
    // Construire l'URL avec les paramètres
    let url = '/admin/update-organisation/{{ $organisation["id"] }}?field=' + fieldName + '&value=' + encodeURIComponent(value);
    
    // Rediriger vers l'URL
    window.location.href = url;
}
</script>
@endsection
