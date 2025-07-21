<?php
include_once '../../includes/global/session.php';
notLogguedSecurity("/");


include_once($assetsShared . 'icons/icons.php');
include_once($includesPublic . 'header.php');
include_once 'navbar/header.php';

$user = $_SESSION['user_info'];
$error = $_SESSION['error'] ?? null;
$success = $_SESSION['success'] ?? null;
unset($_SESSION['error'], $_SESSION['success'], $_SESSION['form_data']);
?>

<div class="d-flex">
    <?php include_once 'navbar/navbar.php';  ?>

    <div class="container py-4">
        <div class="mb-4">
            <h1 class="h3">Créer un tournoi</h1>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <form method="POST" action="../../processes/create_tournament_process.php" class="bg-light p-4 rounded shadow-sm">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="nom_tournoi" class="form-label">Nom du tournoi</label>
                    <input type="text" class="form-control" id="nom_tournoi" name="nom_tournoi" required>
                </div>

                <div class="col-md-6">
                    <label for="lieu" class="form-label">Lieu</label>
                    <input type="text" class="form-control" id="lieu" name="lieu" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="date_tournoi" class="form-label">Date et heure</label>
                    <input type="date" class="form-control" id="datePicker" name="date_tournoi"  required>
                </div>

                <div class="col-md-6">
                    <label for="categorie" class="form-label">Catégorie</label>
                    <select class="form-select" id="categorie" name="categorie" required>
                        <option value="">-- Sélectionner --</option>
                        <option value="Junior">Junior</option>
                        <option value="Senior">Senior</option>
                        <option value="Pro">Pro</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="age" class="form-label">Âge minimum</label>
                    <input type="number" class="form-control" id="age" name="age" min="13" max="80">
                </div>

                <div class="col-md-6">
                    <label for="team-number" class="form-label">Nombre max d'équipes</label>
                    <input type="number" class="form-control" id="team-number" name="team-number" min="3" max="8" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="statut" class="form-label">Statut</label>
                <select class="form-select" id="statut" name="statut" required>
                    <option value="">-- Sélectionner --</option>
                    <option value="en_attente">En attente</option>
                    <option value="en_cours">En cours</option>
                    <option value="termine">Terminé</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="description" class="form-label">Description ou règlement</label>
                <textarea class="form-control" id="description" name="description" rows="4" placeholder="Informations supplémentaires..."></textarea>
            </div>

            <button type="submit" class="btn btn-primary w-100">Créer le tournoi</button>
        </form>
    </div>
</div>

<?php include_once($includesGlobal . 'footer.php'); ?>
