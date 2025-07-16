document.addEventListener('DOMContentLoaded', async () => {
    const response = await fetch("/api/matches/", {
            method: 'GET'
    });

    const tbody = document.getElementById('matchesShowing');

    const data = await response.json();
    const matches = data.matches;
    const userIdSession = data.waiter;

    if (matches.length === 0) {
        const div = document.getElementById("nomatch");
        div.innerHTML = "Aucun match à afficher.";
        return;
    }

    for (const match of matches) {
        const id = match.id_match;
        const team1Id = match.id_equipe1;
        const team2Id = match.id_equipe2;
        const status = match.statut;
        const creatorId = match.id_createur;
        const creatorUsername = match.createur_pseudo;
        const fieldName = match.nom_terrain;
        const location = match.localisation;
        const message = match.message;
    
        const tr = document.createElement('tr');
    
        tr.innerHTML = `
            <td>${id}</td>
            <td>${fieldName}</td>
            <td>${location}</td>
            <td><span class="badge bg-secondary">${status}</span></td>
            <td>${message}</td>
            <td>@${creatorUsername ?? "Inconnu"}</td>
            <td>
                <button class="btn btn-sm btn-warning me-1 open-edit-modal" data-bs-toggle="modal" data-bs-target="#editMatch${id}">
                    <i class="bi bi-pencil"></i>
                </button>
                <button class="btn btn-sm btn-danger me-1 open-edit-modal" data-bs-toggle="modal" data-bs-target="#deleteMatch${id}">
                    <i class="bi bi-trash"></i>
                </button>
                ${generateEditModal(match)}
                ${generateDeleteModal(match)}
            </td>
        `;
        tbody.appendChild(tr);

    }
    document.getElementById("dynamic-modal-container").innerHTML = generateAddModal();

    function generateEditModal(match) {
        return `<div class="modal fade" id="editMatch${match.id_match}" tabindex="-1" aria-hidden="true">
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
    }

    function generateDeleteModal(match) {
        return `
        <div class="modal fade" id="deleteMatch${match.id_match}" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <form method="POST" action="../../processes/delete_match_process.php">
                <div class="modal-header">
                  <h5 class="modal-title">Supprimer un match</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  Êtes-vous sûr de vouloir supprimer ce match ?
                  <input type="hidden" name="id" value="${match.id_match}">
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                  <button type="submit" class="btn btn-danger">Supprimer</button>
                </div>
              </form>
            </div>
          </div>
        </div>`;
    }

    function generateAddModal() {
        return `
            <div class="modal fade" id="createMatch" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content text-dark">
                    <form method="POST" action="../../processes/create_match_process.php">
                        <div class="modal-header">
                            <h5 class="modal-title">Créer un match</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label" for="nom_match">Nom du match</label>
                                <input class="form-control" id="nom_match" name="nom_match" type="text" required />
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="localisation">Localisation</label>
                                <input class="form-control" id="localisation" name="localisation" type="text" required />
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="date">Date</label>
                                <input class="form-control" id="date" name="date" type="date" required />
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="debut">Heure de début</label>
                                <input class="form-control" id="debut" name="debut" type="time" required />
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="fin">Heure de fin</label>
                                <input class="form-control" id="fin" name="fin" type="time" required />
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="categorie">Catégorie</label>
                                <select class="form-select" id="categorie" name="categorie" aria-label="">
                                    <option value="0" selected>1v1</option>
                                    <option value="1">2v2</option>
                                    <option value="2">3v3</option>
                                    <option value="3">4v4</option>
                                    <option value="4">5v5</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="niveau_min">Niveau minimum requis</label>
                                <select class="form-select" id="niveau_min" name="niveau_min">
                                    <option value="0">Débutant</option>
                                    <option value="1">Intermédiaire</option>
                                    <option value="2">Avancé</option>
                                    <option value="3">Pro</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="commentaire">Message ou commentaire</label>
                                <div class="form-floating">
                                    <textarea class="form-control" id="commentaire" name="commentaire" style="height: 100px"></textarea>
                                    <label for="commentaire">Indications supplémentaires</label>
                                </div>
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
    }

});