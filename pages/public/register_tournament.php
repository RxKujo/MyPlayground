<?php
// filepath: c:\xampp\htdocs\MyPlayground\pages\public\register_tournament.php
include_once '../../includes/global/session.php';
include_once '../../includes/config/config.php';
notLogguedSecurity("../../index.php");

include_once $includesPublic . 'header.php';
include_once 'navbar/header.php';

// Messages flash
$message = "";
if (isset($_SESSION['success'])) {
    $message = "<div class='alert alert-success'>" . $_SESSION['success'] . "</div>";
    unset($_SESSION['success']);
}
if (isset($_SESSION['error'])) {
    $message = "<div class='alert alert-danger'>" . $_SESSION['error'] . "</div>";
    unset($_SESSION['error']);
}

// Récupérer les équipes
$stmt = $pdo->prepare("SELECT id_equipe, nom FROM equipe");
$stmt->execute();
$equipes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les tournois
$stmt = $pdo->prepare("SELECT id_tournoi, nom FROM tournoi");
$stmt->execute();
$tournois = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="d-flex">
    <!-- Navigation latérale -->
    <?php include_once 'navbar/navbar.php'; ?>

    <!-- Contenu principal -->
    <div class="container mt-4">
        <h2 class="mb-4">Inscrire une équipe à un tournoi</h2>

        <?= $message ?>

        <form action="../../processes/register_tournament_process.php" method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">Votre adresse e-mail</label>
                <input type="email" class="form-control" name="email" id="email" required placeholder="Entrez votre adresse e-mail" value="<?= htmlspecialchars($_SESSION['user']['email'] ?? '') ?>">
            </div>

            <div class="mb-3">
                <label for="id_equipe" class="form-label">Choisir une équipe</label>
                <select class="form-select" name="id_equipe" id="id_equipe" required>
                    <option value="" disabled selected>-- Sélectionner une équipe --</option>
                    <?php foreach ($equipes as $equipe): ?>
                        <option value="<?= $equipe['id_equipe'] ?>"><?= htmlspecialchars($equipe['nom']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="id_tournoi" class="form-label">Choisir un tournoi</label>
                <select class="form-select" name="id_tournoi" id="id_tournoi" required>
                    <option value="" disabled selected>-- Sélectionner un tournoi --</option>
                    <?php foreach ($tournois as $tournoi): ?>
                        <option value="<?= $tournoi['id_tournoi'] ?>"><?= htmlspecialchars($tournoi['nom']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Inscrire</button>
        </form>

        
    </div>
</div>

<?php include_once('../../includes/global/footer.php'); ?>
