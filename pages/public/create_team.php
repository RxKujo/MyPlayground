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

                <h3 class="mb-4">Créer une équipe</h3>
                <p class="mb-4">Remplissez le formulaire ci-dessous pour créer une  nouvelle équipe.</p>    
<form id="form_team" action="/create_team_process" method="POST" enctype="multipart/form-data">        <label for="nom_equipe" class="form-label">Nom de l'équipe</label>
        <input type="text" name="nom_equipe" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Description de l'équipe</label>
        <textarea name="description" class="form-control" rows="3"></textarea>
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
        <label for="categorie_age" class="form-label">Catégorie d'âge</label>
        <select name="categorie_age" class="form-select" required>
            <option value="" selected disabled>-- Sélectionner --</option>
            <option value="cadet">Cadet</option>
            <option value="junior">Junior</option>
            <option value="senior">Senior</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="logo" class="form-label">Logo de l'équipe <span class="text-muted">(optionnel)</span></label>
        <input type="file" name="logo" id="logo" class="form-control" accept="image/*">
    </div>

    <div class="mb-3">
        <label for="ville" class="form-label">Ville</label>
        <input type="text" name="ville" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="niveau_min" class="form-label">Niveau minimum requis</label>
        <select name="niveau_min" class="form-select" required>
            <option value="" selected disabled>-- Sélectionner --</option>
            <option value="0">Débutant</option>
            <option value="1">Intermédiaire</option>
            <option value="2">Pro</option>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label" style="font-size:1.3em;font-weight:bold;">Équipe privée ?</label>
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" id="privee" name="privee" value="1" onchange="toggleCodeEquipe()">
            <label class="form-check-label" for="privee">Oui</label>
        </div>
    </div>

    <div class="mb-3" id="codeEquipeField" style="display:none;">
        <label for="code_equipe" class="form-label">Code d'accès (pour rejoindre l'équipe)</label>
        <input type="text" name="code_equipe" id="code_equipe" class="form-control">
    </div>

    <div class="mb-3">
        <label for="commentaire" class="form-label">Commentaire</label>
        <textarea name="commentaire" class="form-control" rows="3"></textarea>
    </div>

    <button type="submit" class="btn btn-dark w-100">Créer l'équipe</button>
</form>

<script>
function toggleCodeEquipe() {
    const privee = document.getElementById('privee');
    const codeField = document.getElementById('codeEquipeField');
    if (privee.checked) {
        codeField.style.display = 'block';
        document.getElementById('code_equipe').setAttribute('required', 'required');
    } else {
        codeField.style.display = 'none';
        document.getElementById('code_equipe').removeAttribute('required');
        document.getElementById('code_equipe').value = '';
    }
}
document.addEventListener("DOMContentLoaded", toggleCodeEquipe);
</script>