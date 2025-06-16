<?php
include_once '../../includes/global/session.php';
notLogguedSecurity("../../index.php");

$user = $_SESSION['user_info'];

include_once $includesPublic . 'header.php';
include_once $assetsShared . 'icons/icons.php';
include_once 'navbar/header.php';

include_once '../../includes/config/config.php'; // ta connexion $pdo
?>

<div class="d-flex">
    <?php
        $_SESSION['current_page'] = 'tournaments';
        include_once 'navbar/navbar.php';
    ?>

    <div class="container-fluid px-5 py-4" id="content">
        <h1 class="fs-1 fw-bold text-center mb-4">Tous les tournois</h1>

        <?php
        try {
            $sql = "SELECT id_tournoi, nom, date_tournoi, lieu, description FROM tournoi ORDER BY date_tournoi DESC";
            $stmt = $pdo->query($sql);
            $tournois = $stmt->fetchAll();

            if (count($tournois) === 0) {
                echo "<p class='text-center fs-4'>Aucun tournoi n'a encore été créé.</p>";
            } else {
                echo '<div class="row">';
                foreach ($tournois as $tournoi) {
                    echo '<div class="col-md-6 col-lg-4 mb-4">';
                    echo '<div class="card shadow h-100">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title fw-bold">' . htmlspecialchars($tournoi['nom']) . '</h5>';
                    echo '<p class="card-text">';
                    echo '<strong>Date :</strong> ' . htmlspecialchars($tournoi['date_tournoi']) . '<br>';
                    echo '<strong>Lieu :</strong> ' . htmlspecialchars($tournoi['lieu']) . '</p>';
                    echo '<p class="card-text text-muted">' . nl2br(htmlspecialchars($tournoi['description'])) . '</p>';
                    echo '</div>';
                    echo '<div class="card-footer text-end">';
                    echo '<a href="tournament_details.php?id=' . $tournoi['id_tournoi'] . '" class="btn btn-sm btn-dark">Voir les détails</a>';
                    echo '</div></div></div>';
                }
                echo '</div>';
            }
        } catch (PDOException $e) {
            echo "<div class='alert alert-danger'>Erreur : " . $e->getMessage() . "</div>";
        }
        ?>
    </div>
</div>

<?php include_once $includesGlobal . "footer.php"; ?>
