<?php
include_once '../../includes/global/session.php';
include_once '../../includes/config/config.php';
notLogguedSecurity("../../index.php");

// En-têtes HTML + barre supérieure
include_once($includesPublic . 'header.php');
include_once 'navbar/header.php';

$id_equipe = isset($_GET['id_equipe']) ? intval($_GET['id_equipe']) : null;



// Récupération des tournois disponibles
$stmt = $pdo->prepare("SELECT * FROM tournoi");
$stmt->execute();
$tournois = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="d-flex">
    <?php include_once 'navbar/navbar.php'; ?>

    <div class="container mt-4">
        <h2 class="mb-4">Inscrire l'équipe à un tournoi</h2>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <form action="../../processes/register_tournament_process.php" method="POST">
            <input type="hidden" name="id_equipe" value="<?= $id_equipe ?>">

            <div class="mb-3">
                <label for="id_tournoi" class="form-label">Choisir un tournoi</label>
                <select class="form-select" name="id_tournoi" id="id_tournoi" required>
                    <option value="" disabled selected>-- Sélectionner --</option>
                    <?php foreach ($tournois as $tournoi): ?>
                        <option value="<?= $tournoi['id_tournoi'] ?>">
                            <?= htmlspecialchars($tournoi['nom']) ?> - <?= htmlspecialchars($tournoi['lieu']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Inscrire</button>
        </form>
    </div>
</div>

<?php include_once('../../includes/global/footer.php'); ?>
