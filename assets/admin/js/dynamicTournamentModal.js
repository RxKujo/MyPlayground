document.addEventListener('DOMContentLoaded', async () => {
    const response = await fetch("/api/tournaments/", {
            method: 'GET'
    });

    let tbody = document.getElementById('tournamentsShowing');

    const data = await response.json();
    const tournaments = data.tournaments;
    const userIdSession = data.waiter;

    
    for (const tourney of tournaments) {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${tourney.id_tournoi}</td>
            <td>${tourney.nom}</td>
            <td>${tourney.date_tournoi}</td>
            <td>${tourney.lieu ?? "Pas de code"}</td>
            <td>${tourney.age ?? "Pas d'age"}</td>
            <td>${tourney.description ?? "Pas de description"}</td>
            <td>
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editTeam${tourney.id_tournoi}">Modifier</button>
                <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteTeam${tourney.id_tournoi}">Supprimer</button>
                ${generateDeleteModal(tourney)}
                ${generateEditModal(tourney)}
            </td>
        `;
        tbody.appendChild(tr);
    }


    function generateEditModal(tourney) {
        return `<div class="modal fade" id="editTeam${tourney.id_tournoi}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" action="../../processes/edit_team_process.php">
                                <div class="modal-header">
                                    <h5 class="modal-title">Modifier une équipe</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="id_equipe" value="${tourney.id_tournoi}">
                                    <div class="mb-3">
                                        <label>Nom</label>
                                        <input class="form-control" name="nom" type="text" value="${tourney.nom}">
                                    </div>
                                    <div class="mb-3">
                                        <label>Date</label>
                                        <input type="datetime-local" class="form-control" id="date_tournoi" name="date_tournoi" value="${tourney.date_tournoi}">
                                    </div>
                                    <div class="mb-3">
                                        <label>Lieu</label>
                                        <input class="form-control" name="code" type="text" value="${tourney.lieu}">
                                    </div>
                                    <div class="mb-3">
                                        <label>Âge minimum</label>
                                        <input class="form-control" name="age" min="0" type="text" value="${tourney.age}">
                                    </div>
                                    <div class="mb-3">
                                        <label>Description</label>
                                        <input class="form-control" name="description" type="text" value="${tourney.description}">
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

    function generateDeleteModal(tourney) {
        return `<div class="modal fade" id="deleteTeam${tourney.id_tournoi}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" action="../../processes/delete_team_process.php">
                                <div class="modal-header">
                                    <h5 class="modal-title">Supprimer une équipe</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    Êtes-vous sûr de vouloir supprimer cette équipe ?
                                    <input type="hidden" name="id_equipe" value="${tourney.id_tournoi}">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                    <button type="submit" class="btn btn-danger">Supprimer</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            `;
    }


    function generateDeleteModal(team) {
        return `<div class="modal fade" id="newTeamModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" action="../../processes/add_team_process.php">
                                <div class="modal-header">
                                    <h5 class="modal-title">Ajouter une équipe</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label>Nom</label>
                                        <input class="form-control" name="nom" type="text" value="">
                                    </div>
                                    <div class="mb-3">
                                        <label>Privée</label>
                                        <select class="form-select" name="privee">
                                            <option value="0">Non</option>
                                            <option value="1">Oui</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label>Code (si privée)</label>
                                        <input class="form-control" name="code" type="text" value="">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                    <button type="submit" class="btn btn-primary">Ajouter</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            `;
    }
});