<?php 

include_once "../../includes/config/config.php";

include_once "../../includes/admin/header.php";

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
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= $user['id'] ?></td>
                        <td><?= $user['nom'] ?></td>
                        <td><?= $user['prenom'] ?></td>
                        <td><?= $user['email'] ?></td>
                        <td><?= $user['role'] ?></td>
                        <td>
                            <button class="btn btn-primary btn-sm">Modifier</button>
                            <button class="btn btn-danger btn-sm">Supprimer</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include_once "../../includes/global/footer.php"; ?>
