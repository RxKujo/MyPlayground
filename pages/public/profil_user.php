<?php

include_once '../../includes/global/session.php';
notLogguedSecurity("../../index.php");

include_once $includesPublic . 'header.php';
include_once $assetsShared . 'icons/icons.php';
include_once "navbar/header.php";

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: partners");
    exit();
}

$userId = (int)$_GET['id'];

$sql = "SELECT pseudo, nom, prenom, date_naissance, email, tel, poste, niveau, description FROM utilisateur WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "<div class='container mt-5'><div class='alert alert-danger'>Utilisateur introuvable.</div></div>";
    include_once $includesGlobal . "footer.php";
    exit();
}

function badgeNiveau($n) {
    return match((int)$n) {
        0 => '<span class="badge bg-primary">Débutant</span>',
        1 => '<span class="badge bg-warning text-dark">Intermédiaire</span>',
        2 => '<span class="badge bg-success">Avancé</span>',
        default => '<span class="badge bg-secondary">Inconnu</span>'
    };
}

function badgePoste($p) {
    return match((int)$p) {
        0 => '<span class="badge bg-info text-dark">Meneur de jeu</span>',
        1 => '<span class="badge bg-info text-dark">Arrière</span>',
        2 => '<span class="badge bg-info text-dark">Ailier</span>',
        3 => '<span class="badge bg-info text-dark">Ailier fort</span>',
        4 => '<span class="badge bg-info text-dark">Pivot</span>',
        default => '<span class="badge bg-secondary">Inconnu</span>'
    };
}

$pfpSrc = showPfp($pdo, ['id' => $userId]);

$currentUser = $_SESSION['user_info'];
$isOwner = ($currentUser['id'] === $userId);

?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="mb-3">
                <a href="partners" class="btn btn-secondary">&larr; Retour</a>
            </div>
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <img src="<?= htmlspecialchars($pfpSrc) ?>" alt="Photo de profil" width="150" height="150" class="rounded-circle">
                        <h2 class="mt-3"><?= htmlspecialchars($user['pseudo']) ?></h2>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Nom :</strong> <?= htmlspecialchars($user['prenom'] . ' ' . $user['nom']) ?></li>
                        <li class="list-group-item"><strong>Date de naissance :</strong> <?= htmlspecialchars($user['date_naissance']) ?></li>
                        <li class="list-group-item"><strong>Email :</strong> <?= htmlspecialchars($user['email']) ?></li>
                        <li class="list-group-item"><strong>Téléphone :</strong> <?= htmlspecialchars($user['tel']) ?></li>
                        <li class="list-group-item"><strong>Poste :</strong> <?= badgePoste($user['poste']) ?></li>
                        <li class="list-group-item"><strong>Niveau :</strong> <?= badgeNiveau($user['niveau']) ?></li>
                        <li class="list-group-item"><strong>Description :</strong><br><?= nl2br(htmlspecialchars($user['description'] ?? '')) ?></li>
                    </ul>

                    <?php if (!$isOwner): ?>
                        <div class="text-center mt-3">
                            <a href="messages" class="btn btn-primary">Parler</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>  
</div>

<?php include_once $includesGlobal . "footer.php"; ?>
