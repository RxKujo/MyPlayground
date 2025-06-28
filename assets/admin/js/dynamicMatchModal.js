document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById('dynamic-modal-container');

    document.body.addEventListener('click', (e) => {
        if (e.target.closest('.open-edit-modal')) {
            const match = JSON.parse(e.target.closest('.open-edit-modal').dataset.match);

            container.innerHTML = `
                <div class="modal fade" id="editMatchModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content text-dark">
                            <form method="POST" action="../../processes/edit_match_process.php">
                                <div class="modal-header">
                                    <h5 class="modal-title">Modifier le match #${match.id_match}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="id_match" value="${match.id_match}">

                                    <div class="mb-3">
                                        <label>Terrain</label>
                                        <input class="form-control" value="${match.nom_terrain ?? ''}" disabled>
                                    </div>

                                    <div class="mb-3">
                                        <label>Localisation</label>
                                        <input class="form-control" value="${match.localisation ?? ''}" disabled>
                                    </div>

                                    <div class="mb-3">
                                        <label>Statut</label>
                                        <select name="statut" class="form-select">
                                            <option value="en_attente" ${match.statut === 'en_attente' ? 'selected' : ''}>En attente</option>
                                            <option value="termine" ${match.statut === 'termine' ? 'selected' : ''}>Terminé</option>
                                            <option value="annule" ${match.statut === 'annule' ? 'selected' : ''}>Annulé</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label>Message</label>
                                        <textarea class="form-control" name="message">${match.message ?? ''}</textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label>Créateur</label>
                                        <input class="form-control" value="@${match.createur_pseudo ?? 'Inconnu'}" disabled>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                    <button type="submit" class="btn btn-primary">Sauvegarder</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            `;

            const modal = new bootstrap.Modal(document.getElementById('editMatchModal'));
            modal.show();
        }
    });
});