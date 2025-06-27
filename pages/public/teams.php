<?php
include_once '../../includes/global/session.php';
notLogguedSecurity("../../index.php");

include_once $includesPublic . 'header.php';
include_once $assetsShared . 'icons/icons.php';
include_once 'navbar/header.php';

$_SESSION['current_page'] = 'teams';
?>

<div class="d-flex">
    <?php include_once "navbar/navbar.php"; ?>

    <div class="container-fluid px-5 py-4" id="content">
        <h1 class="text-center fw-bold mb-4">Toutes les équipes</h1>
        <p class="text-center fs-5 mb-3">Voici la liste des équipes créées avec leurs membres.</p>

        <?php if (isset($_SESSION['success'])): ?>
            <div class='alert alert-success text-center'><?= $_SESSION['success'] ?></div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class='alert alert-danger text-center'><?= $_SESSION['error'] ?></div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

<<<<<<< HEAD
        <form method="GET" action="" class="mb-4">
            <input type="text" name="search" placeholder="Rechercher une équipe..." class="form-control"
                   value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
        </form>
=======
<form method="GET" action="" class="mb-4 d-flex gap-2">
    <input type="text" name="search" placeholder="Rechercher une équipe..." class="form-control"
           value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
    <a href="/create_team" class="btn btn-success">Créer une équipe</a>
</form>
>>>>>>> ff673fbea1b7db60135c8560152ce481a10361b8

        <?php
        try {
            $search = $_GET['search'] ?? '';

            if ($search) {
                $stmt = $pdo->prepare("
                    SELECT * FROM equipe 
                    WHERE nom LIKE ? 
                    AND id_equipe NOT IN (
                        SELECT id_equipe1 FROM `match` WHERE statut = 'en_attente'
                        UNION
                        SELECT id_equipe2 FROM `match` WHERE statut = 'en_attente'
                    )
                ");
                $stmt->execute(["%$search%"]);
            } else {
                $stmt = $pdo->query("
                    SELECT * FROM equipe 
                    WHERE id_equipe NOT IN (
                        SELECT id_equipe1 FROM `match` WHERE statut = 'en_attente'
                        UNION
                        SELECT id_equipe2 FROM `match` WHERE statut = 'en_attente'
                    )
                ");
            }

            $teams = $stmt->fetchAll();

            if (count($teams) === 0) {
                echo "<p class='text-center'>Aucune équipe trouvée.</p>";
            } else {
                $tournois = $pdo->query("SELECT id_tournoi, nom FROM tournoi")->fetchAll();

                foreach ($teams as $team):
                    ?>
                    <div class='card bg-dark text-white mb-4'>
                        <div class='card-header fw-bold fs-4'><?= htmlspecialchars($team['nom']) ?></div>
                        <div class='card-body'>
                            <?php
                            $stmtMembers = $pdo->prepare("SELECT * FROM equipe_membre WHERE id_equipe = ?");
                            $stmtMembers->execute([$team['id_equipe']]);
                            $members = $stmtMembers->fetchAll();

                            if ($members): ?>
                                <ul class='list-group list-group-flush'>
                                    <?php foreach ($members as $member): ?>
                                        <li class='list-group-item bg-dark text-white'>
                                            <strong>Pseudo :</strong> <?= htmlspecialchars($member['pseudo']) ?> -
                                            <strong>Poste :</strong> <?= htmlspecialchars($member['poste']) ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else: ?>
                                <p>Aucun membre dans cette équipe.</p>
                            <?php endif; ?>

                            <div class="d-flex flex-wrap gap-2 mt-4">
                                <a href="/join_team" class="btn btn-primary">Rejoindre une équipe</a>
                                <?php if (!empty($tournois)): ?>
                                    <a href="/register_tournament" class="btn btn-success">Inscrire à un tournoi</a>
                                <?php else: ?>
                                    <span class="text-muted align-self-center">Aucun tournoi disponible</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php
                endforeach;
            }
        } catch (PDOException $e) {
            echo "<div class='alert alert-danger'>Erreur lors de la récupération des équipes : " . $e->getMessage() . "</div>";
        }
        ?>
    </div>
</div>
