<?php
include_once '../../includes/global/session.php';
notLogguedSecurity("../../index.php");

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
                <div class="carousel-item active">
                    <img src="../../assets/public/img/actus1.png" class="d-block w-100" style="height: 400px; object-fit: cover;">
                    <div class="carousel-caption d-flex flex-column justify-content-center align-items-center">
                        <h2 class="text-white mb-3">Tournois à venir</h2>
                        <a href="tournaments" class="btn btn-outline-light btn-lg">Voir les tournois</a>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="../../assets/public/img/team.png" class="d-block w-100" style="height: 400px; object-fit: cover;">
                    <div class="carousel-caption d-flex flex-column justify-content-center align-items-center">
                        <h2 class="text-white mb-3">Trouve ta team</h2>
                        <a href="partners" class="btn btn-outline-light btn-lg">Trouver des coéquipiers</a>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="../../assets/public/img/terrain.jpg" class="d-block w-100" style="height: 400px; object-fit: cover;">
                    <div class="carousel-caption d-flex flex-column justify-content-center align-items-center">
                        <h2 class="text-white mb-3">Matchs organisés</h2>
                        <a href="matches" class="btn btn-outline-light btn-lg">Voir les matchs</a>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselActus" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselActus" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
            </button>
        </div>

        <form id="search-filters" class="mx-5 my-4" method="GET" action="partners">
            <div class="mb-4 text-center">
                <h3 class="fs-2 fw-bold">Chercher des coéquipiers</h3>
                <p>Sélectionnez le niveau et le poste de votre partenaire idéal</p>
            </div>

            <div class="mb-4">
                <h4>Niveau</h4>
                <div class="d-flex flex-wrap gap-2">
                    <?php
                    $niveaux = ['Débutant', 'Intermédiaire', 'Avancé', 'Pro'];
                    foreach ($niveaux as $key => $label) {
                        echo <<<HTML
                            <div>
                                <input id="niveau-$key" name="niveau[]" type="checkbox" class="btn-check" value="$key">
                                <label class="btn btn-outline-secondary" for="niveau-$key">$label</label>
                            </div>
                        HTML;
                    }
                    ?>
                </div>
            </div>

            <div class="mb-4">
                <h4>Poste</h4>
                <div class="d-flex flex-wrap gap-2">
                    <?php
                    $postes = [
                        'mj' => 'Meneur de jeu',
                        'ar' => 'Arrière',
                        'ai' => 'Ailier',
                        'af' => 'Ailier fort',
                        'p'  => 'Pivot',
                        'all' => 'Tous'
                    ];
                    $i = 0;
                    foreach ($postes as $id => $label) {
                        echo <<<HTML
                            <div>
                                <input id="poste-$id" name="poste[]" type="checkbox" class="btn-check" value="$i">
                                <label class="btn btn-outline-secondary" for="poste-$id">$label</label>
                            </div>
                        HTML;
                        $i++;
                    }
                    ?>
                </div>
            </div>

            <div class="d-flex justify-content-center gap-4 mt-5">
                <button type="reset" class="btn btn-dark px-4 py-2">Clear</button>
                <button type="submit" class="btn btn-outline-dark px-4 py-2">Search</button>
            </div>
        </form>

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
                <div class="d-flex justify-content-center gap-3">
                    <a href="profile" class="btn btn-dark">Voir le profil</a>
                    <a class="btn btn-outline-dark">Inviter</a>
                </div>
            </div>
        <?php endif; ?>

    </div>
</div>

<?php include_once $includesGlobal . "footer.php"; ?>
