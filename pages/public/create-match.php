<?php
include_once '../../includes/global/session.php';

notLogguedSecurity("../../index.php");

include_once($assetsShared . 'icons/icons.php');
include_once($includesPublic . 'header.php');
include_once "navbar/header.php";

$user = $_SESSION['user_info'];

$error = isset($_SESSION['error']) ? $_SESSION['error'] : null;
unset($_SESSION['error'], $_SESSION['form_data']);
?>

<div class="d-flex">
    <?php include_once "navbar/navbar.php"; ?>

	<div class="container">
		<div class="header-title">
			<h1>Créer un match</h1>
		</div>

		<div class="form-container">
			<form method="POST" action="../../processes/create_match_process.php">

				<div class="mb-3">
					<label class="form-label" for="nom_match">Nom du match</label>
					<input class="form-control" id="nom_match" name="nom_match" type="text" required />
				</div>

				<div class="mb-3">
					<label class="form-label" for="localisation">Localisation</label>
					<input class="form-control" id="localisation" name="localisation" type="text" required />
				</div>

				<div class="mb-3">
					<label class="form-label" for="date_debut">Date et heure de début</label>
					<input class="form-control" id="date_debut" name="date_debut" type="datetime-local" required />
				</div>

				<div class="mb-3">
					<label class="form-label" for="date_fin">Date et heure de fin</label>
					<input class="form-control" id="date_fin" name="date_fin" type="datetime-local" required />
				</div>

				<div class="mb-3">
					<label class="form-label" for="nb_joueurs">Catégorie</label>
					<input class="form-control" id="nb_joueurs" name="nb_joueurs" type="number" min="2" required />
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
						<textarea class="form-control" id="commentaire" name="commentaire" style="height: 100px"></textarea>
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

<?php include_once('../../includes/global/footer.php'); ?>
