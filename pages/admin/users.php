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
        <?php 
            displayAlert('modif_success', 0);
        ?>
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
            <tbody id="usersShowing">

            </tbody>
        </table>
    </div>
</div>

<script>
    const users = <?= json_encode($users) ?>;
    const userIdSession = <?= $_SESSION['user_info']['id'] ?>;
</script>

<script src="/assets/admin/js/dynamicUserModal.js"></script>

<?php include_once $includesGlobal . "footer.php"; ?>
