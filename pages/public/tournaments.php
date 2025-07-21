<?php
include_once '../../includes/global/session.php';
notLogguedSecurity("/");

$user = $_SESSION['user_info'];

include_once $includesPublic . 'header.php';
include_once $assetsShared . 'icons/icons.php';
include_once 'navbar/header.php';

include_once '../../includes/config/config.php';
$stmt = $pdo->query("SELECT * FROM tournoi WHERE statut = 'terminé'");
$tournoisTermines = $stmt->fetchAll(PDO::FETCH_ASSOC);

$aucunTournoi = empty($tournoisTermines);
$totalParticipants = 0;
$totalCash = 0;
$equipeGagnante = "À venir";

if (!$aucunTournoi) {
    foreach ($tournoisTermines as $tournoi) {
        $totalParticipants += $tournoi['nombre_utilisateurs_max'];
        $totalCash += $tournoi['recompense'] ?? 0;
        if (!empty($tournoi['equipe_gagnante'])) {
            $equipeGagnante = $tournoi['equipe_gagnante'];
        }
    }
}
?>

<div class="d-flex">
    <?php
    if (isset($_SESSION)) {
        $_SESSION['current_page'] = 'tournaments';
    } else {
        header('location: index.php');
    }
    include_once "navbar/navbar.php";
    ?>

    <div class="container-fluid px-0" id="content">
        <div id="carousel" class="carousel slide px-5 py-3" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
            </div>
           
            <button class="carousel-control-prev" type="button" data-bs-target="#carousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

        <div class="bg-body-secondary">
            <h1 class="fs-1 fw-bold text-center py-3">Tournois à venir</h1>
            <p class="fs-5 text-center">Gardez une longueur d’avance en participant à ces tournois passionnants</p>
            
            <div class="input-group mb-3 mx-auto pt-3 pb-4 w-25">
                <input type="text" class="form-control" id="search-tourney-input" placeholder="Rechercher un tournoi">
            </div>

            <div class="d-flex flex-column align-items-center mx-auto mb-5 pb-5">
                <button id="tournament-button" class="btn btn-dark btn-lg">
                    <span class="px-3">Voir tous les tournois</span>
                </button>
            </div>
        </div>

        <div class="d-flex flex-column align-items-center mx-auto mb-4">
            <a href="create_tournament" class="btn btn-primary btn-lg">
                Créer un tournoi
            </a>
        </div>

        <div id="reviews" class="px-5 py-4">

<?php

$sql = "
    SELECT u.nom, u.pseudo, a.commentaire, a.date_avis
    FROM avis a
    JOIN utilisateur u ON a.utilisateur_id = u.id
    ORDER BY a.date_avis DESC
";

$stmt = $pdo->query($sql);
$avis = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="m-5">
    <h1 class="fs-1 fw-bold">Revues des joueurs</h1>
    <p class="fs-5">Découvrez ce que les joueurs disent à propos de vos tournois</p>

    <?php if (empty($avis)): ?>
    <p class="fs-5 fst-italic text-muted">Aucun avis pour le moment.</p>
<?php else: ?>
    <?php foreach ($avis as $avisItem): ?>
        <div class="d-flex align-items-start mb-4 border-bottom pb-3">
            <div class="ms-3">
                <p class="m-0 fw-bold"><?= htmlspecialchars($avisItem['nom']) ?> (<?= htmlspecialchars($avisItem['pseudo']) ?>)</p>
                <p class="mb-1"><?= nl2br(htmlspecialchars($avisItem['commentaire'])) ?></p>
                <small class="text-muted"><?= date('d/m/Y', strtotime($avisItem['date_avis'])) ?></small>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

</div>


        </div>
<style>.carousel-control-prev,
.carousel-control-next {
    display: none;
}
</style>
        <div id="team-join" class="d-flex flex-row">
            <div class="p-5 m-5">
                <h1 class="text-center fs-4 text-body-emphasis">Rejoindre une équipe</h1>
                <p class="text-center fs-4 text-body-emphasis">À la recherche de coéquipiers ? Cliquez ici pour en trouver</p>
            </div>
            
            <div class="d-flex align-items-center m-auto ms-5">
                <a href="partners" id="find-button" class="btn btn-dark btn-lg">
                    Trouver des coéquipiers
                </a>
            </div>
        </div>

        <div class="d-flex flex-column align-items-center mx-auto mb-4">
            <a href="create_match" class="btn btn-primary btn-lg">
                Créer un match
            </a>
        </div>

        <div id="tournament-stats" class="bg-body-secondary py-4">
            <div class="d-flex flex-column align-items-center mx-auto mb-5">
                <h1 class="text-center fs-4 text-body-emphasis">Statistique de Tournoi</h1>
                <p class="text-center fs-4 text-body-emphasis">Regardez les dernières statistiques de vos tournois</p>
            </div>

            <?php if ($aucunTournoi): ?>
                <p class="text-center fs-4 text-body-emphasis">Aucun tournoi terminé pour le moment.</p>
            <?php else: ?>
                <div class="d-flex justify-content-evenly pb-5 flex-wrap gap-3">
<div class="rounded p-3 bg-body text-body shadow-sm" style="width:400px;">
                        <h1 class="fs-6 text-secondary">Participants total</h1>
                        <p class="fs-3 fw-bold"><?= number_format($totalParticipants) ?></p>
                    </div>
                    <div class="border rounded p-3 bg-body text-body shadow-sm" style="width: 400px;">
                        <h1 class="fs-6 text-secondary">Montant à gagner</h1>
                        <p class="fs-3 fw-bold">$<?= number_format($totalCash, 0, ',', ' ') ?></p>
                    </div>
                    <div class="border rounded p-3 bg-body text-body shadow-sm" style="width: 400px;">
                        <h1 class="fs-6 text-secondary">Équipe gagnante</h1>
                        <p class="fs-3 fw-bold"><?= htmlspecialchars($equipeGagnante) ?></p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="../../assets/public/js/carouselLoader.js"></script>

<script>
    document.getElementById('tournament-button').addEventListener('click', function () {
        window.location.href = 'tournaments_list'; 
    });
</script>

<?php include_once $includesGlobal . "footer.php"; ?>
