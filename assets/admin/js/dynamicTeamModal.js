document.addEventListener('DOMContentLoaded', async () => {
    const response = await fetch("/api/teams/", {
            method: 'GET'
    });

    let tbody = document.getElementById('teamsShowing');

    const data = await response.json();
    const teams = data.teams;
    console.log(teams);
    const userIdSession = data.waiter;

    
    for (const team of teams) {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${team.id_equipe}</td>
            <td>${team.nom}</td>
            <td>${team.privee}</td>
            <td>${team.code ?? "Pas de code"}</td>
            <td>${team.commentaire ?? "Pas de commentaires"}</td>
            <td>
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editTeam${team.id_equipe}">Modifier</button>
                <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteTeam${team.id_equipe}">Supprimer</button>
                ${generateDeleteModal(team)}
                ${generateEditModal(team)}
            </td>
        `;
        tbody.appendChild(tr);
    }


    function generateEditModal(team) {
        return `<div class="modal fade" id="editTeam${team.id_equipe}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" action="../../processes/edit_team_process.php">
                                <div class="modal-header">
                                    <h5 class="modal-title">Modifier une équipe</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="id_equipe" value="${team.id_equipe}">
                                    <div class="mb-3">
                                        <label>Nom</label>
                                        <input class="form-control" name="nom" type="text" value="${team.nom}">
                                    </div>
                                    <div class="mb-3">
                                        <label>Privée</label>
                                        <select class="form-select" name="privee">
                                            <option value="0" ${team.privee == 0 ? 'selected' : ''}>Non</option>
                                            <option value="1" ${team.privee == 1 ? 'selected' : ''}>Oui</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label>Code (si privée)</label>
                                        <input class="form-control" name="code" type="text" value="${team.code}">
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

    function generateDeleteModal(team) {
        return `<div class="modal fade" id="deleteTeam${team.id_equipe}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" action="../../processes/delete_team_process.php">
                                <div class="modal-header">
                                    <h5 class="modal-title">Supprimer une équipe</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    Êtes-vous sûr de vouloir supprimer cette équipe ?
                                    <input type="hidden" name="id_equipe" value="${team.id_equipe}">
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