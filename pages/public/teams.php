

<?php

include_once '../../includes/global/session.php';
notLogguedSecurity("../../index.php");

include_once '../../includes/config/config.php'; // ici tu as $pdo

include_once '../../includes/public/header.php';
include_once '../../assets/shared/icons/icons.php';
include_once 'navbar/header.php';
?>

<div class="d-flex">
    <?php
    $_SESSION['current_page'] = 'teams';
    include_once "navbar/navbar.php";
    ?>

    <div class="container-fluid px-5 py-4" id="content">
        <h1 class="text-center fw-bold mb-4">Toutes les équipes</h1>
        <p class="text-center fs-5 mb-3">Voici la liste des équipes créées avec leurs membres.</p>

        <!-- Barre de recherche -->
        <form method="GET" action="" class="mb-4">
            <input type="text" name="search" placeholder="Rechercher une équipe..." class="form-control" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
        </form>

        <?php
        try {
            $search = $_GET['search'] ?? '';

            if ($search) {
                $stmt = $pdo->prepare("SELECT * FROM equipe WHERE nom LIKE ?");
                $stmt->execute(["%$search%"]);
            } else {
                $stmt = $pdo->query("SELECT * FROM equipe");
            }

            $teams = $stmt->fetchAll();

            if (count($teams) === 0) {
                echo "<p class='text-center'>Aucune équipe trouvée.</p>";
            }

            foreach ($teams as $team) {
                echo "<div class='card bg-dark text-white mb-4'>";
                echo "<div class='card-header fw-bold fs-4'>" . htmlspecialchars($team['nom']) . "</div>";
                echo "<div class='card-body'>";

                $stmtMembers = $pdo->prepare("SELECT * FROM equipe_membre WHERE id_equipe = ?");
                $stmtMembers->execute([$team['id_equipe']]);
                $members = $stmtMembers->fetchAll();

                if ($members) {
                    echo "<ul class='list-group list-group-flush'>";
                    foreach ($members as $member) {
                        echo "<li class='list-group-item bg-dark text-white'>";
                        echo "<strong>Pseudo :</strong> " . htmlspecialchars($member['pseudo']) . " - ";
                        echo "<strong>Poste :</strong> " . htmlspecialchars($member['poste']);
                        echo "</li>";
                    }
                    echo "</ul>";
                } else {
                    echo "<p>Aucun membre dans cette équipe.</p>";
                }

                echo "<a href='#' class='btn btn-outline-light mt-3'>Rejoindre l’équipe</a>";
                echo "</div></div>";
            }
        } catch (PDOException $e) {
            echo "<div class='alert alert-danger'>Erreur lors de la récupération des équipes : " . $e->getMessage() . "</div>";
        }
        ?>
    </div>
</div>

<?php include_once '../../includes/global/footer.php'; ?>
