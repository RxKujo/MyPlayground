<?php 

include_once "../../includes/config/variables.php";

include_once $includesConfig . "config.php";
include_once $includesConfig . "functions.php";
include_once $includesAdmin . "header.php";

$sql = 'SELECT id, nom, prenom, email, role FROM utilisateur ORDER BY cree_le DESC';
$stmt = $pdo->prepare($sql);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>



<div class="d-flex">
    <?php
        include_once "navbar/navbar.php";
    ?>

    <div class="container-fluid p-4" style="flex-grow: 1;" id="content">
        <h2>Gestion des Utilisateurs</h2>
        <input
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
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    foreach ($users as $user): 
                        $niveau = getUserLevel($user);
                        $poste = getUserPosition($user);
                        $role = getUserRole($role);
                ?>
                    <tr>
                        <td><?= $user['id'] ?></td>
                        <td><?= $user['nom'] ?></td>
                        <td><?= $user['prenom'] ?></td>
                        <td><?= $user['email'] ?></td>
                        <td><?= $user['role'] ?></td>
                        <td>
                            <span>
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editProfile">
                                Modifier
                                </button>
                                
                                <!-- Modal -->
                                <div class="modal fade" id="editProfile" tabindex="-1" aria-labelledby="editProfileLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="editProfileLabel">Modifier un profil</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="../../processes/edit_profile_process.php">
                                            <input class="form-control" name="id" type="hidden" value="" />
                                            
                                            <div class="mb-3">
                                                <label class="form-label" for="nom">Nom</label>
                                                <input class="form-control" id="nom" name="nom" type="text" value="<?= $user['nom'] ?>"/>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="prenom">Prenom</label>
                                                <input class="form-control" id="prenom" name="prenom" type="text" value="<?= $user['prenom'] ?>"/>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label class="form-label" for="pseudo">Pseudonyme</label>
                                                <input class="form-control" id="pseudo" name="pseudo" type="text" value="<?= $user['pseudo'] ?>"/>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label class="form-label" for="tel">Téléphone</label>
                                                <input class="form-control" id="tel" name="tel" type="tel" value="<?= $user['tel'] ?>"/>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label class="form-label" for="email">Email</label>
                                                <input class="form-control" id="email" name="email" type="email" value="<?= $user['email'] ?>"/>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label" for="localisation">Adresse</label>
                                                <input class="form-control" id="localisation" name="localisation" type="text" value="<?= $user['localisation'] ?>"/>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label class="form-label" for="niveau">Niveau</label>
                                                <select class="form-select" id="niveau" name="niveau" aria-label="">
                                                    <option value="<?= $user['niveau'] ?>" selected><?= $niveau ?></option>
                                                    <option value="0">Débutant</option>
                                                    <option value="1">Intermédiaire</option>
                                                    <option value="2">Avancé</option>
                                                    <option value="3">Pro</option>
                                                </select>
                                            </div>
                                            
                                            
                                            <div class="mb-3">
                                                <label class="form-label" for="role">Role</label>
                                                <select class="form-select" id="role" name="role" aria-label="">
                                                    <option value="<?= $user['role'] ?>" selected><?= $role ?></option>
                                                    <option value="0">Joueur</option>
                                                    <option value="1">Arbitre</option>
                                                    <option value="2">Organisateur</option>
                                                    <option value="3">Spectateur</option>
                                                </select>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label class="form-label" for="poste">Poste</label>
                                                <select class="form-select" id="poste" name="poste">
                                                    <option value="<?= $user['poste'] ?>" selected=""><?= $position ?></option>
                                                    <option value="0">Meneur</option>
                                                    <option value="1">Arrière</option>
                                                    <option value="2">Ailier</option>
                                                    <option value="3">Ailier fort</option>
                                                    <option value="4">Pivot</option>
                                                </select>
                                                
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label for="commentaire">Commentaire</label>
                                                <div class="form-floating">
                                                    <textarea class="form-control" id="commentaire" name="commentaire" style="height: 100px"></textarea>
                                                    <label for="commentaire">Commente ici</label>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <button type="submit" class="btn btn-primary w-100">Valider</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                        <button type="button" class="btn btn-primary">Sauvegarder les changements</button>
                                    </div>
                                    </div>
                                </div>
                                </div>
                            </span>
                            <span>
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteProfile">
                                Supprimer
                                </button>
                                
                                <!-- Modal -->
                                <div class="modal fade" id="deleteProfile" tabindex="-1" aria-labelledby="deleteProfileLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="deleteProfileLabel">Supprimer un profil</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Êtes-vous sûr de vouloir supprimer cet utilisateur ?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                        <button type="button" class="btn btn-danger">Supprimer l'utilisateur</button>
                                    </div>
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

<?php include_once "../../includes/global/footer.php"; ?>
