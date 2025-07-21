<?php
include_once '../../includes/global/session.php';
notLogguedSecurity("/");

$user = $_SESSION['user_info'];
$pfpSrc = showPfp($pdo, $user);

include_once $includesPublic . "header.php";
include_once $assetsShared . 'icons/icons.php';
include_once "navbar/header.php";
?>

<div class="d-flex">
    <?php include_once "navbar/navbar.php"; ?>

    <div class="container-fluid px-0" id="content">

        <div class="d-flex align-items-center justify-content-between welcome-section px-5 py-4 flex-wrap gap-4">
            <div class="d-flex align-items-center gap-4">
                <img class="profile-img" src="<?= $pfpSrc ?>" alt="Photo de profil"/>
                <div>
                    <h3 class="text-white mb-1">Bienvenue, <?= $user["prenom"] ?>!</h3>
                    <div class="d-flex flex-wrap gap-2">
                        <span class="badge bg-dark-subtle text-black">Jouez près de chez vous</span>
                        <span class="badge bg-dark-subtle text-black">NOUVEAUX tournois</span>
                    </div>
                </div>
            </div>
            <div class="d-flex flex-column align-items-end">
                <a href="partners" class="btn btn-outline-light mb-2">Trouver des coéquipiers</a>
                <a href="tournaments" class="btn btn-dark">Rejoindre un tournoi</a>
            </div>
        </div>

        <div id="carouselActus" class="carousel slide mb-5" data-bs-ride="carousel">
            <div class="carousel-inner">
                <?php
                $slides = [
                    ["img" => "../../assets/public/img/actus1.png", "title" => "Tournois à venir", "link" => "tournaments", "btn" => "Voir les tournois"],
                    ["img" => "../../assets/public/img/team.png", "title" => "Trouve ta team", "link" => "partners", "btn" => "Trouver des coéquipiers"],
                    ["img" => "../../assets/public/img/terrain.jpg", "title" => "Matchs organisés", "link" => "matches", "btn" => "Voir les matchs"],
                    ["img" => "../../assets/public/img/profil.jpg", "title" => "Profil", "link" => "profile", "btn" => "Voir ton profil"],
                ];

                foreach ($slides as $index => $slide) {
                    $active = $index === 0 ? 'active' : '';
                    echo <<<HTML
                        <div class="carousel-item $active position-relative">
                            <img src="{$slide['img']}" class="d-block w-100" style="height: 400px; object-fit: cover;">
                            <div class="position-absolute top-0 start-0 w-100 h-100" style="background: rgba(0, 0, 0, 0.5); z-index: 1;"></div>
                            <div class="carousel-caption d-flex flex-column justify-content-center align-items-center" style="z-index: 2;">
                                <h2 class="text-white mb-3">{$slide['title']}</h2>
                                <a href="{$slide['link']}" class="btn btn-outline-light btn-lg">{$slide['btn']}</a>
                            </div>
                        </div>
                    HTML;
                }
                ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselActus" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselActus" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
            </button>
        </div> 
        <?php if (!is_null($user['niveau'])): ?>
            <div class="mt-5 px-5">
                <div class="text-center mb-4">
                    <h3 class="fs-2 fw-bold">Coéquipiers recommandés</h3>
                </div>
                <div class="row mb-4">
                    <?php
                    $partners = getUsersFromLevel($pdo, $user['niveau'], 4);
                    foreach ($partners as $partner) {
                        echo displayCardUser($partner);
                    }
                    ?>
                </div>
            </div>
        <?php endif; ?>

    </div>
</div>

<?php include_once $includesGlobal . "footer.php"; ?>
