<!-- Modal Ajout/Modification d'événement -->
<div class="modal fade" id="addEventModal" tabindex="-1" aria-labelledby="addEventModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addEventModalLabel">Ajouter un événement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="eventForm">
                    <input type="hidden" id="eventId" name="id">
                    <div class="mb-3">
                        <label for="eventTitle" class="form-label">Titre</label>
                        <input type="text" class="form-control" id="eventTitle" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="eventDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="eventDescription" name="description" rows="3"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="eventStartDate" class="form-label">Date de début</label>
                            <input type="datetime-local" class="form-control" id="eventStartDate" name="start_date" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="eventEndDate" class="form-label">Date de fin</label>
                            <input type="datetime-local" class="form-control" id="eventEndDate" name="end_date" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="eventLocation" class="form-label">Lieu</label>
                        <input type="text" class="form-control" id="eventLocation" name="location">
                    </div>
                    <div class="mb-3">
                        <label for="eventType" class="form-label">Type d'événement</label>
                        <select class="form-select" id="eventType" name="type" required>
                            <option value="">Sélectionnez un type</option>
                            <option value="consultation">Consultation</option>
                            <option value="reunion">Réunion</option>
                            <option value="atelier">Atelier</option>
                            <option value="formation">Formation</option>
                            <option value="autre">Autre</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary" id="saveEventBtn">Enregistrer</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Détails de l'événement -->
<div class="modal fade" id="eventDetailsModal" tabindex="-1" aria-labelledby="eventDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventDetailsModalLabel">Détails de l'événement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h4 id="detailsEventTitle"></h4>
                <p class="text-muted">
                    <i class="fas fa-calendar"></i> <span id="detailsEventDate"></span><br>
                    <i class="fas fa-map-marker-alt"></i> <span id="detailsEventLocation"></span><br>
                    <i class="fas fa-tag"></i> <span id="detailsEventType"></span>
                </p>
                <div class="mt-3">
                    <h6>Description</h6>
                    <p id="detailsEventDescription"></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-primary" id="editEventBtn">Modifier</button>
                <button type="button" class="btn btn-danger" id="deleteEventBtn">Supprimer</button>
            </div>
        </div>
    </div>
</div>
