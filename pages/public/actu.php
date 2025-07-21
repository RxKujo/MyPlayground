<?php

include_once '../../includes/global/session.php';
notLogguedSecurity("/");


$assetsShared = '../../assets/shared/';  
$includesPublic = '../../includes/public/';
$includesGlobal = '../../includes/global/';
include_once $includesPublic . 'header.php';
include_once "navbar/header.php";



include_once $assetsShared . 'icons/icons.php';
$_SESSION['current_page'] = 'actu';

function getJson($url) {
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 5,
    ]);
    $r = curl_exec($ch);
    curl_close($ch);
    return json_decode($r, true);
}

$data = getJson("https://www.balldontlie.io/api/v1/games?per_page=8&order=desc");
$games = $data['data'] ?? [];
?>

<div class="d-flex">
    <?php include_once "navbar/navbar.php"; ?>

    <div class="container-fluid px-5 py-4" id="content">
        <h1 class="text-center fw-bold mb-4">Actu NBA</h1>
        <?php if (empty($games)): ?>
            <div class="alert alert-warning text-center">La saison NBA n'a pas encore débuté abonnez-vous à la newsletter pour être informés</div>
        <?php else: ?>
            <div class="row row-cols-1 row-cols-md-2 g-4">
                <?php foreach ($games as $g): ?>
                    <div class="col">
                        <div class="card bg-secondary text-white">
                            <div class="card-body">
                                <h5><?= htmlspecialchars($g['home_team']['full_name']) ?> vs <?= htmlspecialchars($g['visitor_team']['full_name']) ?></h5>
                                <p><strong>Score :</strong> <?= intval($g['home_team_score']) ?>–<?= intval($g['visitor_team_score']) ?><br>
                                <strong>Date :</strong> <?= date('d M Y', strtotime($g['date'])) ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <div class="mt-4 text-center"><a href="/home" class="btn btn-outline-light">← Retour</a></div>
    </div>
</div>

<?php include_once $includesGlobal . "footer.php"; ?>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>