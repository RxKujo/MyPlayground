<?php
include_once '../../includes/global/session.php';
notLogguedSecurity("../../index.php");

$user = $_SESSION['user_info'];
include_once $includesAdmin . "header.php";
include_once $assetsShared . 'icons/icons.php';

try {
    $stmt = $pdo->query("
        SELECT m.*, t.nom AS nom_terrain, t.localisation, u.pseudo AS createur_pseudo
        FROM `match` m
        LEFT JOIN reserver r ON r.id_match = m.id_match
        LEFT JOIN terrain t ON r.id_terrain = t.id_terrain
        LEFT JOIN utilisateur u ON m.id_createur = u.id
        ORDER BY m.id_match DESC
    ");
    $matchs = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $matchs = [];
    $error = $e->getMessage();
}
?>

<div class="d-flex">
    <?php include_once "navbar/navbar.php"; ?>

    <div class="container-fluid p-4" style="flex-grow: 1;" id="content">
        <?php
        if (isset($_SESSION['modif_success'])) {
            alertMessage($_SESSION['modif_success'], 0);
            $_SESSION['modif_success'] = null;
        }

        if (!empty($error)) {
            echo "<div class='alert alert-danger'>Erreur : " . htmlspecialchars($error) . "</div>";
        }
        ?>

        <h2>Gestion des matchs</h2>
        <a href="../create_match" class="btn btn-success mb-3">
            <i class="bi bi-plus-circle"></i> Nouveau match
        </a>

        <?php if (count($matchs) === 0): ?>
            <div class="text-muted text-center">Aucun match à afficher.</div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Terrain</th>
                            <th>Localisation</th>
                            <th>Statut</th>
                            <th>Message</th>
                            <th>Créateur</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($matchs as $match): ?>
                            <tr>
                                <td><?= $match['id_match'] ?></td>
                                <td><?= htmlspecialchars($match['nom_terrain'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($match['localisation'] ?? '-') ?></td>
                                <td><span class="badge bg-secondary"><?= htmlspecialchars($match['statut']) ?></span></td>
                                <td><?= htmlspecialchars($match['message']) ?></td>
                                <td>@<?= htmlspecialchars($match['createur_pseudo'] ?? 'Inconnu') ?></td>
                                <td>
                                    <button class="btn btn-sm btn-warning me-1 open-edit-modal"
                                        data-match='<?= json_encode($match, JSON_HEX_APOS | JSON_HEX_QUOT) ?>'>
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <form action="../../processes/delete_match_process.php" method="POST" class="d-inline">
                                        <input type="hidden" name="id_match" value="<?= $match['id_match'] ?>">
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<div id="dynamic-modal-container"></div>

<script src="/assets/admin/js/dynamicMatchModal.js"></script>

<?php include_once $includesGlobal . "footer.php"; ?>
