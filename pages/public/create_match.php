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
					<label class="form-label" for="categorie">Catégorie</label>
					<select class="form-select" id="categorie" name="categorie" aria-label="">
						<option value="" selected></option>
						<option value="0">1v1</option>
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

				<div class="container text-center">
					<div class="row">
						<div class="col">
							<div>
								<p>Equipe 1</p>
								<ul>

								</ul>
							</div>
							<div class="mb-3">
								<button type="submit" class="btn btn-primary w-40">Rejoindre</button>
							</div>
						</div>
							

						
						<div class="col">
							<div>
								<p>Equipe 2</p>
								<ul>

								</ul>
							</div>
							<div class="mb-3">
								<button type="submit" class="btn btn-primary w-40">Rejoindre</button>
							</div>
						</div>			
					</div>
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
