function getUserRole(role) {
    role = parseInt(role, 10);
    
    switch (role) {
      case 0:
          roleString = 'Joueur';
          break;
      case 1:
          roleString = 'Arbitre';
          break;
      case 2:
          roleString = 'Organisateur';
          break;
      case 3:
          roleString = 'Spectateur';
          break;
      default:
          roleString = 'Inconnu';
          break;
    }

    return roleString;
}

function getUserLevel(level) {
    level = parseInt(level, 10);

    switch (level) {
      case 0:
        level = 'Débutant';
        break;
      case 1:
        level = 'Intérmediaire';
        break;
      case 2:
        level = 'Avancé';
        break;
      case 3:
        level = 'Pro';
        break;
      default:
        level = 'Inconnu';
        break;
    }

    return level;
}

function getUserPosition(poste) {
    poste = parseInt(poste, 10);

    switch (poste) {
        case 0:
            poste = 'Meneur de jeu';
            break;
        case 1:
            poste = 'Arrière';
            break;
        case 2:
            poste = 'Ailier';
            break;
        case 3:
            poste = 'Ailier fort';
            break;
        case 4:
            poste = 'Pivot';
            break;
        default:
            poste = 'Inconnu';
            break;
    }

    return poste;
}

document.addEventListener('DOMContentLoaded', async function () {
    const response = await fetch("/api/users/static/all/", {
            method: 'GET'
    });

    const tbody = document.querySelector('#usersShowing');

    const data = await response.json();
    const users = data.users;
    const userIdSession = data.waiter;

    for (const user of users) {
        const id = user.id;
        const username = user.pseudo;
        const nom = user.nom;
        const prenom = user.prenom;
        const email = user.email;
        const role = getUserRole(user.role);
        const isAdmin = user.droits == 1;
        const lastLogin = user.derniere_connexion;
        const isBanned = user.is_banned == 1;
        const nom_ville = user.ville_nom;

        user.niveau = parseInt(user.niveau);
        user.poste = parseInt(user.poste);
        user.role = parseInt(user.role);


        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${id}</td>
            <td>${username}</td>
            <td>${nom}</td>
            <td>${prenom}</td>
            <td>${email}</td>
            <td>${role}</td>
            <td>${nom_ville}</td>
            <td>${lastLogin}</td>
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
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editProfile${id}"}><i class="bi bi-pencil-fill"></i></button>
                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteProfile${id}" ${id === userIdSession ? 'disabled' : ''}><i class="bi bi-trash3-fill"></i></button>
                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#banProfile${id}" ${id === userIdSession || isBanned ? 'disabled' : ''}><i class="bi bi-ban-fill"></i></button>
                ${generateDeleteModal(id)}
                ${generateEditModal(id, user)}
                ${generateBanModal(id, user)}

            </td>`;
                
        tbody.appendChild(tr);

        const banCheckbox = document.getElementById(`bandefcheck${id}`);
        const banDateInput = document.getElementById(`date${id}`);
    
        if (banCheckbox && banDateInput) {
            banDateInput.disabled = banCheckbox.checked;
    
            banCheckbox.addEventListener('change', function () {
                banDateInput.disabled = this.checked;
            });
        }
        // Initialiser l'autocomplétion pour le champ ville de cet utilisateur
        const villeInput = document.getElementById(`ville_input${id}`);
        const villeHidden = document.getElementById(`ville_id${id}`);
        const villeSuggestions = document.getElementById(`ville_suggestions${id}`);
    
        if (villeInput && villeHidden && villeSuggestions) {
            villeInput.addEventListener('input', async () => {
                const query = villeInput.value;
                if (query.length < 2) {
                    villeSuggestions.innerHTML = '';
                    return;
                }
    
                try {
                    const res = await fetch('/api/cities?q=' + encodeURIComponent(query));
                    const data = await res.json();
                    villeSuggestions.innerHTML = '';
    
                    (data.cities || []).forEach(city => {
                        const item = document.createElement('div');
                        item.className = 'list-group-item list-group-item-action';
                        item.textContent = `${city.ville} (${city.code_postal})`;
                        item.addEventListener('click', () => {
                            villeInput.value = `${city.ville} (${city.code_postal})`;
                            villeHidden.value = city.id;
                            villeSuggestions.innerHTML = '';
                        });
                        villeSuggestions.appendChild(item);
                    });
                } catch (err) {
                    console.error("Erreur lors de la récupération des villes :", err);
                }
            });
    
            // Fermer les suggestions quand on clique en dehors
            document.addEventListener('click', (e) => {
                if (!villeSuggestions.contains(e.target) && e.target !== villeInput) {
                    villeSuggestions.innerHTML = '';
                }
            });
        }

    }



   
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

    function generateBanModal(id) {
        const date = new Date();

        let day = date.getDate();
        let month = date.getMonth() + 1;
        if (month.toString().length < 2) {
            month = '0' + month;
        }
        let year = date.getFullYear();
        let currentDate = `${year}-${month}-${day}`;

        return `
        <div class="modal fade" id="banProfile${id}" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <form method="POST" action="../../processes/ban_user_process.php">
                <div class="modal-header">
                  <h5 class="modal-title">Bannir un profil</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" value="1" id="bandefcheck${id}" name="bandef">
                    <label class="form-check-label" for="bandefcheck${id}">
                      Bannir définitivement
                    </label>
                  </div>
                  <div class="form-control">
                    Combien de temps voulez-vous bannir cet utilisateur ?
                    <input type="hidden" name="id" value="${id}">
                    <label class="form-label" for="date${id}">Date</label>
          			<input class="form-control" id="date${id}" name="date" min="${currentDate}" type="date" />
                  </div>
                  <div class="form-control">
                    <label class="form-label" for="raison${id}">Raison</label>
                    <textarea class="form-control" id="raison${id}" name="raison"></textarea>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                  <button type="submit" class="btn btn-danger">Bannir</button>
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
              <form method="POST" action="../../processes/edit_profile_from_admin_process.php">
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
                  
                  <div class="mb-3 position-relative">
                    <label for="ville_input${id}" class="form-label">Ville*</label>
                    <input type="text" class="form-control" id="ville_input${id}" name="ville_text" autocomplete="off"
                      value="${user.ville_nom}" required>
                    <input type="hidden" id="ville_id${id}" name="ville_id" value="${user.ville_id}">
                    <div id="ville_suggestions${id}" class="list-group position-absolute w-100" style="z-index: 9999;"></div>
                  </div>
                  
                  <div class="mb-3">
                  <label>Niveau</label>
                    <select name="niveau" class="form-select">
                      <option value="0" ${user.niveau === 0 ? 'selected' : ''}>Débutant</option>
                      <option value="1" ${user.niveau === 1 ? 'selected' : ''}>Intermédiaire</option>
                      <option value="2" ${user.niveau === 2 ? 'selected' : ''}>Avancé</option>
                      <option value="3" ${user.niveau === 3 ? 'selected' : ''}>Pro</option>
                    </select>
                  </div>

                  <div class="mb-3">
                  <label>Poste</label>
                    <select name="poste" class="form-select">
                      <option value="0" ${user.poste === 0 ? 'selected' : ''}>Meneur de jeu</option>
                      <option value="1" ${user.poste === 1 ? 'selected' : ''}>Arrière</option>
                      <option value="2" ${user.poste === 2 ? 'selected' : ''}>Ailier</option>
                      <option value="3" ${user.poste === 3 ? 'selected' : ''}>Ailier fort</option>
                      <option value="4" ${user.poste === 4 ? 'selected' : ''}>Pivot</option>
                    </select>
                  </div>

                  <div class="mb-3">
                  <label>Rôle</label>
                    <select name="role" class="form-select">
                      <option value="0" ${user.role === 0 ? 'selected' : ''}>Joueur</option>
                      <option value="1" ${user.role === 1 ? 'selected' : ''}>Arbitre</option>
                      <option value="2" ${user.role === 2 ? 'selected' : ''}>Organisateur</option>
                      <option value="3" ${user.role === 3 ? 'selected' : ''}>Spectateur</option>
                    </select>
                  </div>

                  <div class="mb-3"><label>Commentaire</label><textarea name="commentaire" class="form-control">${user.description}"</textarea></div>
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
