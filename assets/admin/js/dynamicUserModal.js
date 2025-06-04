document.addEventListener('DOMContentLoaded', function () {
    const tbody = document.querySelector('#usersShowing');

    users.forEach(user => {
        const id = user.id;
        const nom = user.nom;
        const prenom = user.prenom;
        const email = user.email;
        const role = user.role; // ou transforme via une fonction JS si nécessaire
        const isAdmin = user.droits == 1;

        // Crée la ligne principale
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${id}</td>
            <td>${nom}</td>
            <td>${prenom}</td>
            <td>${email}</td>
            <td>${role}</td>
            <td>
                <div class="form-check form-switch">
                    <input type="checkbox"
                           class="form-check-input"
                           id="switchUser${id}"
                           data-bs-toggle="modal"
                           data-bs-target="#confirmSwitch${id}"
                           ${isAdmin ? 'checked' : ''}
                           ${id === userIdSession ? 'disabled' : ''}
                           onclick="return false;">
                    <label class="form-check-label" for="switchUser${id}">
                        ${isAdmin ? '<i class="bi bi-person-fill-gear"></i>' : '<i class="bi bi-person-fill"></i>'}
                    </label>
                </div>
                ${generateSwitchModal(id, isAdmin)}
            </td>
            <td>
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editProfile${id}">Modifier</button>
                <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteProfile${id}">Supprimer</button>
                ${generateDeleteModal(id)}
                ${generateEditModal(id, user)}
            </td>
        `;
        tbody.appendChild(tr);
    });

    // Fonctions pour générer les modals
    function generateSwitchModal(id, isAdmin) {
        return `
        <div class="modal fade" id="confirmSwitch${id}" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <form method="POST" action="../../processes/toggle_admin_process.php">
                <div class="modal-header">
                  <h5 class="modal-title">Changer les droits</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  Voulez-vous ${isAdmin ? "retirer" : "attribuer"} les droits administrateur ?
                  <input type="hidden" name="id" value="${id}">
                  <input type="hidden" name="new_droits" value="${isAdmin ? 0 : 1}">
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                  <button type="submit" class="btn btn-primary">Confirmer</button>
                </div>
              </form>
            </div>
          </div>
        </div>`;
    }

    function generateDeleteModal(id) {
        return `
        <div class="modal fade" id="deleteProfile${id}" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <form method="POST" action="../../processes/delete_user_process.php">
                <div class="modal-header">
                  <h5 class="modal-title">Supprimer un profil</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  Êtes-vous sûr de vouloir supprimer cet utilisateur ?
                  <input type="hidden" name="id" value="${id}">
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

    function generateEditModal(id, user) {
        return `
        <div class="modal fade" id="editProfile${id}" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <form method="POST" action="../../processes/edit_profile_process.php">
                <div class="modal-header">
                  <h5 class="modal-title">Modifier un profil</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                  <input type="hidden" name="id" value="${id}">
                  <div class="mb-3"><label>Nom</label><input name="nom" class="form-control" value="${user.nom}" /></div>
                  <div class="mb-3"><label>Prénom</label><input name="prenom" class="form-control" value="${user.prenom}" /></div>
                  <div class="mb-3"><label>Nom d'utilisateur</label><input name="pseudo" class="form-control" value="${user.pseudo}" /></div>
                  <div class="mb-3"><label>Téléphone</label><input name="tel" class="form-control" value="${user.tel}" /></div>
                  <div class="mb-3"><label>Email</label><input name="email" class="form-control" value="${user.email}" /></div>
                  <div class="mb-3"><label>Adresse</label><input name="localisation" class="form-control" value="${user.localisation}" /></div>
                  <div class="mb-3"><label>Niveau</label><input name="niveau" class="form-control" value="${user.niveau}" /></div>
                  <div class="mb-3"><label>Poste</label><input name="poste" class="form-control" value="${user.poste}" /></div>
                  <div class="mb-3"><label>role</label><input name="role" class="form-control" value="${user.role}" /></div>
                  <div class="mb-3"><label>Commentaire</label><textarea name="commentaire" class="form-control" value="${user.description}"></textarea></div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                  <button type="submit" class="btn btn-primary">Sauvegarder</button>
                </div>
              </form>
            </div>
          </div>
        </div>`;
    }
});
