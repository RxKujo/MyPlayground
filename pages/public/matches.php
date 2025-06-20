<?php
include_once '../../includes/global/session.php';
notLogguedSecurity("../../index.php");

$user = $_SESSION['user_info'];

include_once $includesPublic . 'header.php';
include_once $assetsShared . 'icons/icons.php';
include_once "navbar/header.php";
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
                    SELECT 
                        m.id_match,
                        m.message,
                        m.statut,
                        m.id_createur AS createur,
                        e1.nom AS equipe1,
                        e2.nom AS equipe2,
                        t.nom AS nom_terrain,
                        t.localisation,
                        r.date_reservation,
                        r.heure_debut,
                        r.heure_fin,

                        e1.id_equipe AS id_equipe1,
                        e2.id_equipe AS id_equipe2,
                        r.id_equipe AS id_reservation,
                        t.id_terrain AS id_terrain 

                    FROM match m 
                    LEFT JOIN equipe e1 ON m.id_equipe1 = e1.id_equipe
                    LEFT JOIN equipe e2 ON m.id_equipe2 = e2.id_equipe
                    LEFT JOIN reserver r ON r.id_match = m.id_match 
                    LEFT JOIN terrain t ON r.id_terrain = t.id_terrain
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

                                    <button type="button" class="btn-close" aria-label="Close" data-bs-toggle="modal" data-bs-target="#<?= $match['id_match'] ?>Modal"></button>
                                    <div class="modal fade" id="<?= $match['id_match'] ?>Modal" tabindex="-1" aria-labelledby="<?= $match['id_match'] ?>ModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <form action="../../processes/delete_match_process.php" method="POST">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="<?= $match['id_match'] ?>ModalLabel">Supprimer le match</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Etes-vous sûr de vouloir supprimer le match '<?= $match['nom_terrain'] ?>' ?
                                                    </div>
                                                    
                                                    <input type="" name="id_match" class="form-control" value="<?= $match['id_match'] ?>"/>
                                                    <input type="" name="id_equipe1" class="form-control" value="<?= $match['id_equipe1'] ?>"/>
                                                    <input type="" name="id_equipe2" class="form-control" value="<?= $match['id_equipe2'] ?>"/>
                                                    <input type="" name="id_reservation" class="form-control" value="<?= $match['id_reservation'] ?>"/>
                                                    <input type="" name="id_terrain" class="form-control" value="<?= $match['id_terrain'] ?>"/>

                                                    
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                                        <button type="submit" class="btn btn-primary">Je suis sûr</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    
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
