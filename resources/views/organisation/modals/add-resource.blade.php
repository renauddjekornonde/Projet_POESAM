<!-- Modal Ajouter une Ressource -->
<div class="modal fade" id="addResourceModal" tabindex="-1" aria-labelledby="addResourceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addResourceModalLabel">Ajouter une ressource</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('organisation.resources.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">Titre</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="type" class="form-label">Type de ressource</label>
                        <select class="form-select" id="type" name="type" required>
                            <option value="">Sélectionnez un type</option>
                            <option value="document">Document</option>
                            <option value="video">Vidéo</option>
                            <option value="audio">Audio</option>
                            <option value="image">Image</option>
                            <option value="link">Lien</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="file" class="form-label">Fichier</label>
                        <input type="file" class="form-control" id="file" name="file">
                        <small class="text-muted">Formats acceptés: PDF, DOC, DOCX, MP4, MP3, JPG, PNG (max. 10MB)</small>
                    </div>
                    <div class="mb-3">
                        <label for="url" class="form-label">URL (optionnel)</label>
                        <input type="url" class="form-control" id="url" name="url">
                    </div>
                    <div class="mb-3">
                        <label for="tags" class="form-label">Tags (séparés par des virgules)</label>
                        <input type="text" class="form-control" id="tags" name="tags">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Ajouter la ressource</button>
                </div>
            </form>
        </div>
    </div>
</div>
