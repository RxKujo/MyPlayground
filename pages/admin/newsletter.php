<?php 

include_once '../../includes/global/session.php';
notLogguedSecurity("../../index.php");

include_once $assetsShared . 'icons/icons.php';
include_once $includesAdmin . 'header.php';

?>

<div class="d-flex">
    <?php include_once 'navbar/navbar.php'; ?>

    <div class="container-fluid p-4" style="flex-grow: 1;" id="content">
        <h2>Gestion de la newsletter</h2>
        <input
            id="searchNewsletterField"
            type="text"
            class="form-control my-3"
            placeholder="Rechercher un post..."
        />
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Objet</th>
                    <th>Corps</th>
                    <th>Date de publication</th>
                </tr>
            </thead>
            <tbody id="newsletterGShowing">
                
            </tbody>
        </table>
    </div>
</div>

<script src=""></script>

<?php include_once $includesGlobal . "footer.php"; ?>