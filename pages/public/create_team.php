<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once '../../includes/global/session.php';
notLogguedSecurity("../../index.php");

$root = $_SERVER['DOCUMENT_ROOT'];
$user = $_SESSION['user_info'];

include_once '../../includes/public/header.php';
include_once '../../assets/shared/icons/icons.php';
include_once "navbar/header.php";
?>

<div class="d-flex">
    <?php include_once "navbar/navbar.php"; ?>

    <div class="container-fluid px-0" id="content">
        <section class="text-white py-5" style="background-color: #3a3a3a;">
            <div class="text-center">
                <h2 class="fw-bold">Créer un Match</h2>
                <p class="mb-4">Remplissez les informations pour organiser un nouveau match.</p>
            </div>
        </section>

        <section class="py-5">
            <div class="container">
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
                <?php endif; ?>
                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
                <?php endif; ?>

                <form id="form_match" action="create-match-process.php" method="POST" class="bg-light p-4 rounded shadow">
                    <div class="mb-3">
                        <label for="nom_match" class="form-label">Nom du match</label>
                        <input type="text" name="nom_match" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="localisation" class="form-label">Localisation</label>
                        <input type="text" name="localisation" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="date_debut" class="form-label">Date de début</label>
                        <input type="datetime-local" name="date_debut" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="date_fin" class="form-label">Date de fin</label>
                        <input type="datetime-local" name="date_fin" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="categorie" class="form-label">Catégorie (joueurs par équipe)</label>
                        <select name="categorie" class="form-select" required>
                            <option value="0">1v1</option>
                            <option value="1">2v2</option>
                            <option value="2">3v3</option>
                            <option value="3">4v4</option>
                            <option value="4">5v5</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="niveau_min" class="form-label">Niveau minimum requis</label>
                        <input type="number" name="niveau_min" class="form-control" min="0" required>
                    </div>

                    <div class="mb-3">
                        <label for="commentaire" class="form-label">Commentaire</label>
                        <textarea name="commentaire" class="form-control" rows="4"></textarea>
                    </div>

                    <button type="submit" class="btn btn-dark w-100">Créer le match</button>
                </form>
            </div>
        </section>
    </div>
</div>

<?php include_once '../../includes/global/footer.php'; ?>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const form = document.querySelector("#form_match");
        if (form) {
            form.addEventListener("submit", function (e) {
                if (!confirm("Confirmer la création du match ?")) {
                    e.preventDefault();
                }
            });
        }
    });
</script>
