<?php 
include_once '../../includes/global/session.php';
notLogguedSecurity("../../index.php");

include_once '../../includes/config/config.php';
$user = $_SESSION['user_info'];

include_once '../../includes/public/header.php';
include_once '../../assets/shared/icons/icons.php';
include_once 'navbar/header.php';
?>

<div class="d-flex">
    <?php
        $_SESSION['current_page'] = 'create_team';
        include_once "navbar/navbar.php";
    ?>

    <div class="container-fluid px-5 py-4" id="content">
        <h1 class="text-center fw-bold mb-4">Créer une équipe</h1>
        <p class="text-center fs-5 mb-5">Remplis le formulaire ci-dessous pour créer ta propre équipe de tournoi.</p>

        <div class="row justify-content-center">
            <div class="col-md-6">
                <form action="../../processes/process_create_team.php" method="POST" class="bg-dark text-white p-4 rounded shadow-lg" style="--bs-bg-opacity: .8;">
                    <div class="mb-3">
                        <label for="team_name" class="form-label">Nom de l'équipe</label>
                        <input type="text" name="team_name" id="team_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="position" class="form-label">Poste dans l'équipe</label>
                        <select name="position" id="position" class="form-select" required>
                            <option value="">Sélectionnez un poste</option>
                            <option value="Meneur">Meneur</option>
                            <option value="Arrière">Arrière</option>
                            <option value="Ailier">Ailier</option>
                            <option value="Ailier fort">Ailier fort</option>
                            <option value="Pivot">Pivot</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="pseudo" class="form-label">Ton pseudo</label>
                        <input type="text" name="pseudo" id="pseudo" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="age" class="form-label">Ton âge</label>
                        <input type="number" name="age" id="age" class="form-control" min="10" max="99" required>
                    </div>

                    <div class="mb-3">
                        <label for="privacy" class="form-label">Visibilité de l'équipe</label>
                        <select name="privacy" id="privacy" class="form-select" required>
                            <option value="">Sélectionnez une option</option>
                            <option value="public">Public</option>
                            <option value="private">Privé</option>
                        </select>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-light btn-lg">Créer l’équipe</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include_once '../../includes/global/footer.php'; ?>
