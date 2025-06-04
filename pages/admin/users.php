<?php 

include_once '../../includes/global/session.php';

include_once $includesConfig . 'config.php';

include_once $assetsShared . 'icons/icons.php';
include_once $includesAdmin . 'header.php';

$sql = 'SELECT * FROM utilisateur ORDER BY cree_le DESC';
$stmt = $pdo->prepare($sql);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>



<div class="d-flex">
    <?php
        include_once 'navbar/navbar.php';
    ?>

    <div class="container-fluid p-4" style="flex-grow: 1;" id="content">
        <h2>Gestion des Utilisateurs</h2>
        <input
            id="searchUserField"
            type="text"
            class="form-control my-3"
            placeholder="Rechercher un utilisateur..."
        />
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Admin</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    foreach ($users as $user): 
                        $id = $user['id'];
                        $nom = $user['nom'];
                        $prenom = $user['prenom'];
                        $pseudo = $user['pseudo'];
                        $email = $user['email'];
                        $niveau = getUserLevel($user);
                        $position = getUserPosition($user);
                        $role = getUserRole($user);

                        $droitsBool = isAdmin($user);
                ?>
                    <tr>
                        <td><?= $id ?></td>
                        <td><?= $nom ?></td>
                        <td><?= $prenom ?></td>
                        <td><?= $email ?></td>
                        <td><?= $role ?></td>
                        <td>
                            <div class="form-check form-switch">
                                <input type="checkbox"
                                    class="form-check-input"
                                    id="switchUser<?= $id ?>"
                                    data-bs-toggle="modal"
                                    data-bs-target="#confirmSwitch<?= $id ?>"
                                    <?= $droitsBool ? "checked" : "" ?>
                                    onclick="return false;"
                                    <?= $id === $_SESSION['user_info']['id'] ? "disabled" : "" ?>
                                >
                                <label class="form-check-label" for="switchUser<?= $id ?>">
                                    <?= $droitsBool ? $personFillGear : $personFill ?>
                                </label>
                            </div>

                            <div class="modal fade" id="confirmSwitch<?= $id ?>" tabindex="-1" aria-labelledby="confirmSwitchLabel<?= $id ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="confirmSwitchLabel<?= $id ?>">Changer les droits</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                                    </div>
                                    <form method="POST" action="../../processes/toggle_admin_process.php">
                                        <div class="modal-body">
                                            <p>Voulez-vous vraiment <?= $droitsBool ? "retirer les droits administrateur" : "attribuer les droits administrateur" ?> à cet utilisateur ?</p>
                                            <input type="hidden" name="id" value="<?= $id ?>">
                                            <input type="hidden" name="new_droits" value="<?= $droitsBool ? 0 : 1 ?>">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                            <button type="submit" class="btn btn-primary">Confirmer</button>
                                        </div>
                                    </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span>
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editProfile<?= $id ?>">
                                Modifier
                                </button>
                                
                                <!-- Modal -->
                                <div class="modal fade" id="editProfile<?= $id ?>" tabindex="-1" aria-labelledby="editProfileLabel<?= $id ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="editProfileLabel<?= $id ?>">Modifier un profil</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form method="POST" action="../../processes/edit_profile_process.php">
                                        <div class="modal-body">
                                                <input class="form-control" name="id" type="hidden" value="<?= $id ?>" />
                                                
                                                <div class="mb-3">
                                                    <label class="form-label" for="nom<?= $id ?>">Nom</label>
                                                    <input class="form-control" id="nom<?= $id ?>" name="nom" type="text" value="<?= $nom ?>"/>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="prenom<?= $id ?>">Prenom</label>
                                                    <input class="form-control" id="prenom<?= $id ?>" name="prenom" type="text" value="<?= $prenom ?>"/>
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label" for="pseudo<?= $id ?>">Pseudonyme</label>
                                                    <input class="form-control" id="pseudo<?= $id ?>" name="pseudo" type="text" value="<?= $pseudo ?>"/>
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label" for="tel<?= $id ?>">Téléphone</label>
                                                    <input class="form-control" id="tel<?= $id ?>" name="tel" type="tel" value="<?= $user['tel'] ?>"/>
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label" for="email<?= $id ?>">Email</label>
                                                    <input class="form-control" id="email<?= $id ?>" name="email" type="email" value="<?= $email ?>"/>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label" for="localisation<?= $id ?>">Adresse</label>
                                                    <input class="form-control" id="localisation<?= $id ?>" name="localisation" type="text" value="<?= $user['localisation'] ?>"/>
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label" for="niveau<?= $id ?>">Niveau</label>
                                                    <select class="form-select" id="niveau<?= $id ?>" name="niveau" aria-label="">
                                                        <option value="<?= $niveau ?>" selected><?= $niveau ?></option>
                                                        <option value="0">Débutant</option>
                                                        <option value="1">Intermédiaire</option>
                                                        <option value="2">Avancé</option>
                                                        <option value="3">Pro</option>
                                                    </select>
                                                </div>
                                                
                                                
                                                <div class="mb-3">
                                                    <label class="form-label" for="role<?= $id ?>">Role</label>
                                                    <select class="form-select" id="role<?= $id ?>" name="role" aria-label="">
                                                        <option value="<?= $role ?>" selected><?= $role ?></option>
                                                        <option value="0">Joueur</option>
                                                        <option value="1">Arbitre</option>
                                                        <option value="2">Organisateur</option>
                                                        <option value="3">Spectateur</option>
                                                    </select>
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label" for="poste<?= $id ?>">Poste</label>
                                                    <select class="form-select" id="poste<?= $id ?>" name="poste">
                                                        <option value="<?= $position ?>" selected=""><?= $position ?></option>
                                                        <option value="0">Meneur</option>
                                                        <option value="1">Arrière</option>
                                                        <option value="2">Ailier</option>
                                                        <option value="3">Ailier fort</option>
                                                        <option value="4">Pivot</option>
                                                    </select>
                                                    
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label for="commentaire<?= $id ?>">Commentaire</label>
                                                    <div class="form-floating">
                                                        <textarea class="form-control" id="commentaire<?= $id ?>" name="commentaire" style="height: 100px"></textarea>
                                                        <label for="commentaire">Commente ici</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                                <button type="submit" class="btn btn-primary">Sauvegarder les changements</button>
                                            </div>
                                    </form>
                                    </div>
                                </div>
                                </div>
                            </span>
                            <span>
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteProfile<?= $id ?>">
                                    Supprimer
                                </button>
                                
                                <div class="modal fade" id="deleteProfile<?= $id ?>" tabindex="-1" aria-labelledby="deleteProfileLabel<?= $id ?>" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="deleteProfileLabel<?= $id ?>">Supprimer un profil</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form method="POST" action="../../processes/delete_user_process.php">
                                                <div class="modal-body">
                                                    Êtes-vous sûr de vouloir supprimer cet utilisateur ?
                                                    <input class="form-control" name="id" type="hidden" value="<?= $id ?>" />
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                                    <button type="submit" class="btn btn-danger">Supprimer l'utilisateur</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include_once $includesGlobal . "footer.php"; ?>
