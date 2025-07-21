<?php

include_once '../../includes/global/session.php';
notLogguedSecurity("/");

$user = $_SESSION['user_info'] ?? null;

include_once $includesPublic . 'header.php';
include_once $assetsShared . 'icons/icons.php';
include_once 'navbar/header.php';

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
                    echo '<strong>Date :</strong> ' . htmlspecialchars($tournoi['date_tournoi'] ?? "") . '<br>';
                    echo '<strong>Lieu :</strong> ' . htmlspecialchars($tournoi['lieu'] ?? "") . '</p>';
                    echo '<p class="card-text text-muted">' . nl2br(htmlspecialchars($tournoi['description'] ?? "")) . '</p>';
                    echo '</div>';
                    echo '<div class="card-footer text-end">';
                    echo '<button type="button" class="btn btn-sm btn-dark me-2" data-bs-toggle="modal" data-bs-target="#avertirModal">M\'avertir</button>';
                    if ($user) {
                        echo '<a href="inscription_tournoi/' . $tournoi['id_tournoi'] . '" class="btn btn-sm btn-primary">S\'inscrire</a>';
                    } 
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
                echo '</div>';

                if ($user) {
                    echo '<a href="create_tournament" class="btn btn-success mt-4">Créer un tournoi</a>';
                }
            }
        } catch (PDOException $e) {
            echo "<div class='alert alert-danger'>Erreur : " . $e->getMessage() . "</div>";
        }
        ?>
        <div id="avertirMessage" class="alert alert-success text-center mt-3 d-none">
            Vous serez désormais averti quand les inscriptions seront ouvertes.
        </div>
    </div>
</div>

<div class="modal fade" id="avertirModal" tabindex="-1" aria-labelledby="avertirModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="avertirModalLabel">Être averti</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>
      <div class="modal-body">
        Voulez-vous être averti quand les inscriptions seront lancées&nbsp;?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Non</button>
        <button type="button" class="btn btn-primary" id="btnAvertirOui">Oui</button>
      </div>
    </div>
  </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const btnAvertirOui = document.getElementById('btnAvertirOui');
    const avertirModal = document.getElementById('avertirModal');
    const avertirMessage = document.getElementById('avertirMessage');
    let lastBtnAvertir = null;

    document.querySelectorAll('.btn-avertir').forEach(button => {
        button.addEventListener('click', function () {
            lastBtnAvertir = this;
        });
    });

    if (btnAvertirOui && avertirModal && avertirMessage) {
        btnAvertirOui.addEventListener('click', function () {
            console.log("Bouton OUI cliqué");
            const modal = bootstrap.Modal.getOrCreateInstance(avertirModal);
            modal.hide();
            avertirMessage.classList.remove('d-none');
            setTimeout(() => {
                avertirMessage.classList.add('d-none');
                if (lastBtnAvertir) lastBtnAvertir.focus();
            }, 4000);
        });
    }
});
</script>

<?php include_once $includesGlobal . "footer.php"; ?>