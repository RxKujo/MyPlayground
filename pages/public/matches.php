<?php
include_once '../../includes/global/session.php';

notLogguedSecurity("../../index.php");

$root = $_SERVER['DOCUMENT_ROOT'];
$user = $_SESSION['user_info'];

include_once '../../includes/public/header.php';
include_once '../../assets/shared/icons/icons.php';
include_once "navbar/header.php";
include_once '../../includes/config/config.php';
?>

<div class="d-flex">
    <?php include_once "navbar/navbar.php"; ?>

    <div class="container-fluid px-0" id="content">
        <section class="text-white py-5" style="background-color: #3a3a3a;">
            <div class="text-center">
                <h2 class="fw-bold">Créer ou Rejoindre un Match</h2>
                <p class="mb-4">Connectez-vous avec d'autres personnes et profitez d'un match fait pour vous !</p>
                <div class="d-flex justify-content-center gap-3">
                    <a href="#" class="btn btn-outline-light px-4">Rejoindre un Match</a>
                    <a href="create_match" class="btn btn-light text-dark px-4">Créer un Match</a>
                </div>
            </div>
        </section>

        <section class="py-5">
            <div class="text-center mb-4">
                <h3 class="fw-bold">Matchs Disponibles à Rejoindre</h3>
                <p>Parcourez les matchs auxquels vous pouvez participer.</p>
            </div>

            <?php
            try {
                $stmt = $pdo->query("
                    SELECT m.*, u.pseudo AS createur, e1.nom AS equipe1, e2.nom AS equipe2
                    FROM `match` m
                    LEFT JOIN utilisateur u ON m.id_equipe1 IS NOT NULL OR m.id_equipe2 IS NOT NULL
                    LEFT JOIN equipe e1 ON m.id_equipe1 = e1.id_equipe
                    LEFT JOIN equipe e2 ON m.id_equipe2 = e2.id_equipe
                    WHERE m.statut = 'en_attente'
                    ORDER BY m.id_match DESC
                ");
                $matchs = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                echo "<div class='alert alert-danger'>Erreur lors du chargement des matchs : " . $e->getMessage() . "</div>";
                $matchs = [];
            }
            ?>

            <div class="container">
                <?php if (count($matchs) === 0): ?>
                    <div class="text-center text-muted">Aucun match disponible pour le moment.</div>
                <?php else: ?>
                    <?php foreach ($matchs as $match): ?>
                        <div class="d-flex justify-content-center mb-4">
                            <div class="card w-75 shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title fw-bold"><?= htmlspecialchars($match['message'] ?? 'Match sans nom') ?></h5>
                                    <p class="card-text">
                                        Jouez avec <strong><?= htmlspecialchars($match['nb_joueurs'] ?? '?') ?></strong> joueurs.<br>
                                        <strong>Lieu :</strong> <?= htmlspecialchars($match['localisation']) ?> <br>
                                        <strong>Début :</strong> <?= htmlspecialchars($match['date_debut']) ?><br>
                                        <strong>Fin :</strong> <?= htmlspecialchars($match['date_fin']) ?>
                                    </p>
                                    <span class="badge bg-secondary me-1">Statut : <?= htmlspecialchars($match['statut']) ?></span>
                                    <div class="mt-3 text-muted">
                                        <i class="bi bi-person-circle"></i> Créateur : <?= htmlspecialchars($match['createur'] ?? 'Inconnu') ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </section>
    </div>
</div>

<?php include_once $includesGlobal . "footer.php"; ?>
