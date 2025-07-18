<?php
include_once '../../includes/global/session.php';

$formData = $_SESSION['form_data'] ?? [];
unset($_SESSION['form_data']);

notLogguedSecurity("/");

include_once($assetsShared . 'icons/icons.php');
include_once($includesPublic . 'header.php');
include_once "navbar/header.php";

$user = $_SESSION['user_info'];

$error = isset($_SESSION['error']) ? $_SESSION['error'] : null;
unset($_SESSION['error'], $_SESSION['form_data']);

$creation_error = isset($_SESSION['match_creation_error']) ? $_SESSION['match_creation_error'] : null;
?>

<div class="d-flex">
    <?php include_once "navbar/navbar.php"; ?>

	<div class="container">
			<?php 
                if (!is_null($creation_error)) {
                    alertMessage($creation_error, 1);
                    $_SESSION['match_creation_error'] = null;
                }
            ?>
		<div class="header-title">
			<h1>Créer un match</h1>
		</div>

		<div class="form-container">
			<form method="POST" action="../../processes/create_match_process.php">

				<div class="mb-3">
					<label class="form-label" for="nom_match">Nom du match</label>
					<input class="form-control" id="nom_match" name="nom_match" type="text" required 
					value="<?= htmlspecialchars($formData['nom_match'] ?? '') ?>" />
				</div>

				<div class="mb-3">
					<label class="form-label" for="localisation">Localisation</label>
					<input class="form-control" id="localisation" name="localisation" type="text" required 
					value="<?= htmlspecialchars($formData['localisation'] ?? '') ?>"/>
				</div>

				<div class="mb-3">
					<label class="form-label" for="date" >Date</label>
					<input class="form-control" id="date" name="date" type="date" required/>
				</div>

					<div class="mb-3">
					<label class="form-label" for="debut">Heure de début</label>
					<input class="form-control" id="debut" name="debut" type="time" required />
				</div>

				<div class="mb-3">
					<label class="form-label" for="fin">Heure de fin</label>
					<input class="form-control" id="fin" name="fin" type="time" required />
				</div>

				<div class="mb-3">
					<label class="form-label" for="categorie">Catégorie</label>
					<select class="form-select" id="categorie" name="categorie" aria-label="">
						<option value="0" selected>1v1</option>
						<option value="1">2v2</option>
						<option value="2">3v3</option>
						<option value="3">4v4</option>
						<option value="4">5v5</option>
					</select>
				</div>

				<div class="mb-3">
					<label class="form-label" for="niveau_min">Niveau minimum requis</label>
					<select class="form-select" id="niveau_min" name="niveau_min">
						<option value="0">Débutant</option>
						<option value="1">Intermédiaire</option>
						<option value="2">Avancé</option>
						<option value="3">Pro</option>
					</select>
				</div>
				<div class="mb-3">
					<label for="commentaire">Message ou commentaire</label>
					<div class="form-floating">
						<textarea class="form-control" id="commentaire" name="commentaire" style="height: 100px"><?= htmlspecialchars($formData['commentaire'] ?? '') ?></textarea>
						<label for="commentaire">Indications supplémentaires</label>
					</div>
				</div>

				<div class="mb-3">
					<button type="submit" class="btn btn-primary w-100">Créer le match</button>
				</div>
			</form>
		</div>
	</div>
</div>

<?php if ($error): ?>
<div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-danger">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="errorModalLabel">Erreur</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>
      <div class="modal-body">
        <?= htmlspecialchars($error) ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>

<script>
window.addEventListener('DOMContentLoaded', () => {
  const modal = new bootstrap.Modal(document.getElementById('errorModal'));
  modal.show();
});
</script>
<?php endif; ?>

<?php include_once($includesGlobal . 'footer.php'); ?>
