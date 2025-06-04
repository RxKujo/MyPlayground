<?php

include_once '../../includes/global/session.php';

include_once $includesConfig . 'config.php';


include_once $includesPublic . 'header.php';

include_once $assetsShared . 'icons/icons.php';
include_once "navbar/header.php";

$user = $_SESSION['user_info'];

$niveau = isset($_GET['niveau']) && is_array($_GET['niveau']) ? $_GET['niveau'] : [];
$postes = isset($_GET['poste']) && is_array($_GET['poste']) ? $_GET['poste'] : [];

$sql = "SELECT * FROM utilisateur WHERE id != :id";
$params = [':id' => $user['id']];

if (!empty($niveau)) {
    $niveau = array_filter($niveau, function($n) {
        return in_array($n, ['0', '1', '2', '3'], true);
    });

    if (!empty($niveau)) {
        $placeholders = [];
        foreach ($niveau as $index => $val) {
            $key = ":niveau$index";
            $placeholders[] = $key;
            $params[$key] = $val;
        }
        $sql .= " AND niveau IN (" . implode(', ', $placeholders) . ")";
    }
}

if (!empty($postes)) {
    // Filtrer uniquement les valeurs valides 0 à 4
    $postes = array_filter($postes, function($p) {
        return in_array($p, ['0', '1', '2', '3', '4'], true);
    });

    if (!empty($postes)) {
        $placeholders = [];
        foreach ($postes as $index => $val) {
            $key = ":poste$index";
            $placeholders[] = $key;
            $params[$key] = $val;
        }
        $sql .= " AND poste IN (" . implode(', ', $placeholders) . ")";
    }
}

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>
<div class="d-flex">
    <?php
        if (isset($_SESSION)) {
            $_SESSION['current_page'] = 'settings';
        }
        echo $sql;
        include_once "navbar/navbar.php";
    ?>    

    <div class="container-fluid px-0" id="content">                
        <div id="partners-page">
            <div class="bg-black" style="--bs-bg-opacity: .65;" role="partners header">
                <div class="container py-5">
                    <h1 class="fs-1 fw-bold text-center text-white mb-4">Filter Your Teammates</h1>
                    <p class="fs-6 text-center text-white mb-0">Find teammates who match your criteria.</p>

                </div>
            </div>
            
            <div class="container py-4">
                <h2 class="fs-2 fw-bold">Filters</h1>
                <div class="accordion" id="accordion-filter1">
                        <form class="d-flex flex-row gap-3 align-items-baseline">
                            <div class="accordion-item" style="width: 180px;">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                        Level
                                    </button>
                                </h2>

                                <div id="collapseOne" class="accordion-collapse collapse">
                                    <div class="accordion-body">
                                        <fieldset>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="lvl1" id="lvl1">
                                                <label class="form-check-label" for="lvl1">Beginner</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="lvl2" id="lvl2">
                                                <label class="form-check-label" for="lvl2">Intermediate</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="lvl3" id="lvl3">
                                                <label class="form-check-label" for="lvl3">Advanced</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="anylvl" id="anylvl">
                                                <label class="form-check-label" for="anylvl">Any</label>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                                
                            </div>


                            <div class="accordion-item border-top" style="width: 180px; border-top-left-radius: 0.375rem; border-top-right-radius: 0.375rem;">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        Position
                                    </button>    
                                </h2>

                                <div id="collapseTwo" class="accordion-collapse collapse">
                                    <div class="accordion-body">
                                        <fieldset>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="lvl1" id="lvl1">
                                                <label class="form-check-label" for="lvl1">Point Guard</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="lvl2" id="lvl2">
                                                <label class="form-check-label" for="lvl2">Shooting Guard</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="lvl3" id="lvl3">
                                                <label class="form-check-label" for="lvl3">Small Forward</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="lvl3" id="lvl3">
                                                <label class="form-check-label" for="lvl3">Power Forward</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="lvl3" id="lvl3">
                                                <label class="form-check-label" for="lvl3">Center Forward</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="lvl3" id="lvl3">
                                                <label class="form-check-label" for="lvl3">Any</label>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                                
                            </div>
                        </form>
                    </div>
            </div>

            <div class="container py-4">
                <h2 class="fw-bold">Coéquipiers</h2>
                <div class="container row g-4">
                    <?php
                        foreach($results as $mate):
                            $pseudo = $mate['pseudo'];
                            $prenom = $mate['prenom'];
                            $nom = $mate['nom'];
                            $niveau = getUserLevel($mate);
                            $poste = getUserPosition($mate);
                            $localisation = $mate['localisation'];
                    ?>
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title mb-2"><?= htmlspecialchars($prenom . ' ' . $nom) ?></h5>
                                <h6 class="card-subtitle mb-3 text-muted">@<?= htmlspecialchars($pseudo) ?></h6>
                                
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item"><strong>Niveau :</strong> <?= htmlspecialchars($niveau) ?></li>
                                    <li class="list-group-item"><strong>Poste :</strong> <?= htmlspecialchars($poste) ?></li>
                                    <li class="list-group-item"><strong>Localisation :</strong> <?= htmlspecialchars($localisation) ?></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>            
</div>

<?php include_once $includesGlobal . "footer.php"; ?>