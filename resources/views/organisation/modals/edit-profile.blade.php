<!-- Modal Éditer le Profil -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProfileModalLabel">Modifier le profil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('organisation.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nom de l'organisation</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $organisation->name ?? '' }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ $organisation->email ?? '' }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Téléphone</label>
                        <input type="tel" class="form-control" id="phone" name="phone" value="{{ $organisation->phone ?? '' }}">
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Adresse</label>
                        <textarea class="form-control" id="address" name="address" rows="2">{{ $organisation->address ?? '' }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3">{{ $organisation->description ?? '' }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="website" class="form-label">Site web</label>
                        <input type="url" class="form-control" id="website" name="website" value="{{ $organisation->website ?? '' }}">
                    </div>
                    <div class="mb-3">
                        <label for="logo" class="form-label">Logo</label>
                        <input type="file" class="form-control" id="logo" name="logo" accept="image/*">
                        @if(isset($organisation->logo))
                        <div class="mt-2">
                            <img src="{{ asset($organisation->logo) }}" alt="Logo actuel" class="img-thumbnail" style="max-height: 100px;">
                        </div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="specialties" class="form-label">Spécialités (séparées par des virgules)</label>
                        <input type="text" class="form-control" id="specialties" name="specialties" value="{{ $organisation->specialties ?? '' }}">
                    </div>
                    <div class="mb-3">
                        <label for="social_media" class="form-label">Réseaux sociaux</label>
                        <div class="input-group mb-2">
                            <span class="input-group-text"><i class="fab fa-facebook"></i></span>
                            <input type="url" class="form-control" name="social_media[facebook]" value="{{ $organisation->social_media['facebook'] ?? '' }}" placeholder="Facebook">
                        </div>
                        <div class="input-group mb-2">
                            <span class="input-group-text"><i class="fab fa-twitter"></i></span>
                            <input type="url" class="form-control" name="social_media[twitter]" value="{{ $organisation->social_media['twitter'] ?? '' }}" placeholder="Twitter">
                        </div>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fab fa-linkedin"></i></span>
                            <input type="url" class="form-control" name="social_media[linkedin]" value="{{ $organisation->social_media['linkedin'] ?? '' }}" placeholder="LinkedIn">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                </div>
            </form>
        </div>
    </div>
</div>
