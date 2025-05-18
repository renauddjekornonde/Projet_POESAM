<!-- Modal Ajouter une Consultation -->
<div class="modal fade" id="addConsultationModal" tabindex="-1" aria-labelledby="addConsultationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addConsultationModalLabel">Programmer une consultation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('organisation.consultations.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="victim_id" class="form-label">Victime</label>
                        <select class="form-select" id="victim_id" name="victim_id" required>
                            <option value="">Sélectionnez une victime</option>
                            @foreach($victims ?? [] as $victim)
                                <option value="{{ $victim->id }}">{{ $victim->prenom }} {{ $victim->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="consultation_date" class="form-label">Date de la consultation</label>
                        <input type="datetime-local" class="form-control" id="consultation_date" name="consultation_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="type" class="form-label">Type de consultation</label>
                        <select class="form-select" id="type" name="type" required>
                            <option value="">Sélectionnez un type</option>
                            <option value="psychologique">Psychologique</option>
                            <option value="juridique">Juridique</option>
                            <option value="medical">Médical</option>
                            <option value="social">Social</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="mode" class="form-label">Mode de consultation</label>
                        <select class="form-select" id="mode" name="mode" required>
                            <option value="presentiel">Présentiel</option>
                            <option value="distance">À distance</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="location" class="form-label">Lieu (si présentiel)</label>
                        <input type="text" class="form-control" id="location" name="location">
                    </div>
                    <div class="mb-3">
                        <label for="notes" class="form-label">Notes préliminaires</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-success">Programmer la consultation</button>
                </div>
            </form>
        </div>
    </div>
</div>
