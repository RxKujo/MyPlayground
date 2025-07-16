<?php 

include_once '../../includes/global/session.php';

notLogguedSecurity("../../index.php");

include_once $assetsShared . 'icons/icons.php';
include_once $includesAdmin . 'header.php';

?>



<div class="d-flex">
    <?php
        include_once 'navbar/navbar.php';
    ?>

    <div class="container-fluid p-4" style="flex-grow: 1;" id="content">
        <?php 
            displayAlert('modif_success', 0);
        ?>
        <h2>Gestion des Utilisateurs Bannis</h2>
        <input
            id="searchUserField"
            type="text"
            class="form-control my-3"
            placeholder="Rechercher un utilisateur..."
        />
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nom d'utilisateur</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Raison</th>
                    <th>Banni le</th>
                    <th>Fin de bannissement</th>
                    <th>Banni</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="bannedUsersShowing">

            </tbody>
        </table>
    </div>
</div>

<script src="/assets/admin/js/searchBar.js"></script>
<script src="/assets/admin/js/dynamicBannedUserModal.js"></script>

<?php include_once $includesGlobal . "footer.php"; ?>
