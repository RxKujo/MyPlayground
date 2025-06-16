<?php
include_once '../../includes/global/session.php';
notLogguedSecurity("../../index.php");

include_once($assetsShared . 'icons/icons.php');
include_once($includesPublic . 'header.php');
include_once "navbar/header.php";

$user = $_SESSION['user_info'];

$error = $_SESSION['error'] ?? null;
$success = $_SESSION['success'] ?? null;
unset($_SESSION['error'], $_SESSION['success'], $_SESSION['form_data']);
?>

<div class="d-flex">
    <?php include_once "navbar/navbar.php"; ?>

    <div class="container">
        <div class="header-title">
            <h1>Créer un tournoi</h1>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <div class="form-container">
            <form method="POST" action="../../processes/create_tournament_process.php">

                <div class="mb-3">
                    <label class="form-label" for="nom_tournoi">Nom du tournoi</label>
                    <input class="form-control" id="nom_tournoi" name="nom_tournoi" type="text" required />
                </div>

                <div class="mb-3">
                    <label class="form-label" for="lieu">Lieu</label>
                    <input class="form-control" id="lieu" name="lieu" type="text" required />
                </div>

                <div class="mb-3">
                    <label class="form-label" for="date_tournoi">Date et heure du tournoi</label>
                    <input class="form-control" id="date_tournoi" name="date_tournoi" type="datetime-local" required />
                </div>

                <div class="mb-3">
                    <label class="form-label" for="categorie">Catégorie</label>
                    <select class="form-select" id="categorie" name="categorie" required>
                        <option value="">-- Sélectionner --</option>
                        <option value="Junior">Junior</option>
                        <option value="Senior">Senior</option>
                        <option value="Pro">Pro</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="age">Âge minimum</label>
                    <input class="form-control" id="age" name="age" type="number" min="0" required />
                </div>

                <div class="mb-3">
                    <label class="form-label" for="nombre_utilisateurs_max">Nombre maximum de participants</label>
                    <input class="form-control" id="nombre_utilisateurs_max" name="nombre_utilisateurs_max" type="number" min="1" required />
                </div>

                <div class="mb-3">
                    <label class="form-label" for="statut">Statut</label>
                    <select class="form-select" id="statut" name="statut" required>
                        <option value="">-- Sélectionner --</option>
                        <option value="en_attente">En attente</option>
                        <option value="en_cours">En cours</option>
                        <option value="termine">Terminé</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="description">Description ou règlement</label>
                    <div class="form-floating">
                        <textarea class="form-control" id="description" name="description" style="height: 100px"></textarea>
                        <label for="description">Informations supplémentaires</label>
                    </div>
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-primary w-100">Créer le tournoi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include_once('../../includes/global/footer.php'); ?>
