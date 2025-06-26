<?php
include_once '../../includes/global/session.php';
notLogguedSecurity("../../index.php");

$user = $_SESSION['user_info'];

include_once $includesPublic . 'header.php';
include_once $assetsShared . 'icons/icons.php';
include_once "navbar/header.php";
?>
<?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success text-center">Match supprimé avec succès.</div>
<?php elseif (isset($_GET['error'])): ?>
    <div class="alert alert-danger text-center"><?= htmlspecialchars($_GET['error']) ?></div>
<?php endif; ?>

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
                $stmt = $pdo->query("SELECT m.id_match, m.message, m.statut, m.id_createur AS createur, e1.nom AS equipe1, e2.nom AS equipe2, t.nom AS nom_terrain, t.localisation, r.date_reservation, r.heure_debut, r.heure_fin, e1.id_equipe AS id_equipe1, e2.id_equipe AS id_equipe2, r.id_reservation AS id_reservation, t.id_terrain AS id_terrain FROM `match` m LEFT JOIN equipe e1 ON m.id_equipe1 = e1.id_equipe LEFT JOIN equipe e2 ON m.id_equipe2 = e2.id_equipe LEFT JOIN reserver r ON r.id_match = m.id_match LEFT JOIN terrain t ON r.id_terrain = t.id_terrain WHERE m.statut = 'en_attente' ORDER BY m.id_match DESC");
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
                        <div class="d-flex justify-content-center mb-4" id="match-<?= $match['id_match'] ?>">
                            <div class="card w-75 shadow-sm">
                                <div class="card-body">
                                    <?php if ($match['createur'] == $user['id']): ?>
                                        <button type="button" class="btn btn-danger btn-sm float-end" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $match['id_match'] ?>">
                                            <i class="bi bi-trash"></i> Supprimer
                                        </button>
                                        <div class="modal fade" id="deleteModal<?= $match['id_match'] ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?= $match['id_match'] ?>" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="deleteModalLabel<?= $match['id_match'] ?>">Supprimer le match</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Êtes-vous sûr de vouloir supprimer le match '<?= htmlspecialchars($match['nom_terrain'] ?? 'Sans nom') ?>' ?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                        <form action="../../processes/delete_match_process.php" method="POST">
                                                            <input type="hidden" name="id_match" value="<?= $match['id_match'] ?>">
                                                            <button type="submit" class="btn btn-danger">Supprimer</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <h5 class="card-title fw-bold"><?= htmlspecialchars($match['nom_terrain'] ?? 'Match sans nom') ?></h5>
                                    <p class="card-text">
                                        Jouez avec <strong>?</strong> joueurs.<br>
                                        <strong>Lieu :</strong> <?= htmlspecialchars($match['localisation'] ?? 'Non défini') ?><br>
                                        <strong>Début :</strong> <?= htmlspecialchars($match['date_reservation'] ?? '-') ?> à <?= htmlspecialchars($match['heure_debut'] ?? '-') ?><br>
                                        <strong>Fin :</strong> <?= htmlspecialchars($match['heure_fin'] ?? '-') ?>
                                    </p>
                                    <span class="badge bg-secondary me-1">Statut : <?= htmlspecialchars($match['statut']) ?></span>
                                    <div class="mt-3 text-muted">
                                        <i class="bi bi-person-circle"></i> Créateur : @<?= getUser($pdo, $match['createur'])['pseudo'] ?? 'Inconnu' ?>

                                        <?php
                                        $stmt2 = $pdo->prepare("SELECT id_equipe FROM appartenir WHERE id_joueur = :id_joueur AND id_equipe IN (:id_match1, :id_match2)");
                                        $stmt2->execute([
                                            ":id_joueur" => $user['id'], 
                                            ":id_match1" => $match['id_equipe1'], 
                                            ":id_match2" => $match['id_equipe2']
                                        ]);
                                        $joinedTeam = $stmt2->fetchColumn();

                                        if (!$joinedTeam): ?>
                                            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#joinModal<?= $match['id_match'] ?>">Rejoindre</button>

                                            <div class="modal fade" id="joinModal<?= $match['id_match'] ?>" tabindex="-1" aria-labelledby="joinModalLabel<?= $match['id_match'] ?>" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content text-dark">
                                                        <form method="POST" action="../../processes/join_match_process.php">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Rejoindre un match</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Choisis l’équipe que tu veux rejoindre :</p>
                                                                <input type="hidden" name="id_match" value="<?= $match['id_match'] ?>">
                                                                <button name="equipe" value="<?= $match['id_equipe1'] ?>" class="btn btn-outline-primary w-100 mb-2">
                                                                    Équipe 1 : <?= htmlspecialchars($match['equipe1'] ?? 'Nom inconnu') ?>
                                                                </button>
                                                                <button name="equipe" value="<?= $match['id_equipe2'] ?>" class="btn btn-outline-primary w-100">
                                                                    Équipe 2 : <?= htmlspecialchars($match['equipe2'] ?? 'Nom inconnu') ?>
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <form method="POST" action="../../processes/leave_match_process.php" class="d-inline">
                                                <input type="hidden" name="id_equipe" value="<?= $joinedTeam ?>">
                                                <button type="submit" class="btn btn-warning">Quitter l'équipe</button>
                                            </form>
                                        <?php endif; ?>
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