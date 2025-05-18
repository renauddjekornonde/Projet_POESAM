@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('layouts.sidebar', ['userType' => 'admin'])
        
        <!-- Contenu principal -->
        <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Modifier l'organisation</h1>
                <a href="/admin/organisations" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Retour à la liste
                </a>
            </div>
            
            @if(request()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ request()->get('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="/admin/update-organisation/{{ $organisation['id'] }}" method="POST" class="needs-validation" novalidate>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="nom_organisation" class="form-label">Nom de l'organisation <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nom_organisation" name="nom_organisation" value="{{ $organisation['nom_organisation'] }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="type_organisation" class="form-label">Type d'organisation <span class="text-danger">*</span></label>
                                <select class="form-select" id="type_organisation" name="type_organisation" required>
                                    <option value="">Sélectionner un type</option>
                                    <option value="ONG" {{ $organisation['type_organisation'] == 'ONG' ? 'selected' : '' }}>ONG</option>
                                    <option value="Association" {{ $organisation['type_organisation'] == 'Association' ? 'selected' : '' }}>Association</option>
                                    <option value="Entreprise" {{ $organisation['type_organisation'] == 'Entreprise' ? 'selected' : '' }}>Entreprise</option>
                                    <option value="Autre" {{ $organisation['type_organisation'] == 'Autre' ? 'selected' : '' }}>Autre</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ $organisation['email'] }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="telephone_organisation" class="form-label">Téléphone <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="telephone_organisation" name="telephone_organisation" value="{{ $organisation['telephone_organisation'] }}" required>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="adresse_organisation" class="form-label">Adresse</label>
                                <textarea class="form-control" id="adresse_organisation" name="adresse_organisation" rows="3">{{ $organisation['adresse_organisation'] }}</textarea>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="password" class="form-label">Nouveau mot de passe</label>
                                <input type="password" class="form-control" id="password" name="password" minlength="8">
                                <div class="form-text">Laissez vide pour conserver le mot de passe actuel.</div>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="/admin/organisations" class="btn btn-outline-secondary me-md-2">Annuler</a>
                            <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Validation des formulaires Bootstrap
(function () {
    'use strict'
    
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.querySelectorAll('.needs-validation')
    
    // Loop over them and prevent submission
    Array.prototype.slice.call(forms)
        .forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                
                form.classList.add('was-validated')
            }, false)
        })
})()
</script>
@endsection
