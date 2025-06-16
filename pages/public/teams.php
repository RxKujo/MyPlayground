<?php
include_once '../../includes/global/session.php';
notLogguedSecurity("../../index.php");

include_once '../../includes/config/config.php'; // $pdo
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

        <!-- Alertes de succès ou erreur -->
        <?php
        if (isset($_SESSION['success'])) {
            echo "<div class='alert alert-success text-center'>" . $_SESSION['success'] . "</div>";
            unset($_SESSION['success']);
        }
        if (isset($_SESSION['error'])) {
            echo "<div class='alert alert-danger text-center'>" . $_SESSION['error'] . "</div>";
            unset($_SESSION['error']);
        }
        ?>

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

            // Récupérer tous les tournois une seule fois
            $tournois = $pdo->query("SELECT id_tournoi, nom FROM tournoi")->fetchAll();

            foreach ($teams as $team) {
                echo "<div class='card bg-dark text-white mb-4'>";
                echo "<div class='card-header fw-bold fs-4'>" . htmlspecialchars($team['nom']) . "</div>";
                echo "<div class='card-body'>";

                // Membres
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

                // Bouton Rejoindre
                echo "<a href='#' class='btn btn-outline-light mt-3'>Rejoindre l’équipe</a>";

                // Formulaire d'inscription à un tournoi
                echo "<form method='POST' action='register_tournament' class='mt-3'>";
                echo "<input type='hidden' name='id_equipe' value='" . $team['id_equipe'] . "'>";

                echo "<div class='mb-2'>";
                echo "<label for='id_tournoi_{$team['id_equipe']}'>Tournoi :</label>";
                echo "<select name='id_tournoi' id='id_tournoi_{$team['id_equipe']}' class='form-select' required>";
                foreach ($tournois as $tournoi) {
                    echo "<option value='" . $tournoi['id_tournoi'] . "'>" . htmlspecialchars($tournoi['nom']) . "</option>";
                }
                echo "</select>";
                echo "</div>";

                echo "<button type='submit' class='btn btn-success'>Inscrire cette équipe à un tournoi</button>";
                echo "</form>";

                echo "</div></div>";
            }
        } catch (PDOException $e) {
            echo "<div class='alert alert-danger'>Erreur lors de la récupération des équipes : " . $e->getMessage() . "</div>";
        }
        ?>
    </div>
</div>

<?php include_once '../../includes/global/footer.php'; ?>
