<?php
//test
// $utilisateur['id'] ;
session_start();
$error = isset($_SESSION['error']) ? $_SESSION['error'] : null;
$formData = isset($_SESSION['form_data']) ? $_SESSION['form_data'] : [];
unset($_SESSION['error'], $_SESSION['form_data']);

?>
<div class="container">	
	<div class="header-title">
		<h1>Modifier votre profil</h1>
	</div>
	<div class="form-container">

		<form method="post" action="profile.php">
			<input class="form-control" name="id" type="hidden" value="" />
			
			<div class="mb-3">
				<label class="form-label" for="nom">Nom</label>
				<input class="form-control" id="nom" name="nom" type="text" value="" />
			</div>
			<div class="mb-3">
				<label class="form-label" for="prenom">Prenom</label>
				<input class="form-control" id="prenom" name="prenom" type="text" value="" />
			</div>
			
			<div class="mb-3">
				<label class="form-label" for="pseudo">Pseudonyme</label>
				<input class="form-control" id="pseudo" name="pseudo" type="text" value="" />
			</div>
			
			<div class="mb-3">
				<label class="form-label" for="niveau">Niveau</label>
				<option selected>Selectione un niveau</option>
				<select class="form-select" id="niveau" aria-label="">
					<option value="" disabled <?= empty($formData['niveau']) ? 'selected' : '' ?>>Choisissez un niveau</option>
					<option value="0">Débutant</option>
					<option value="1">Intermédiaire</option>
					<option value="2">Avancé</option>
					<option value="3">Pro</option>
				</select>
			</div>
			
			<div class="mb-3">
				<label class="form-label" for="tel">Téléphone</label>
				<input class="form-control" id="tel" name="tel" type="tel" value="" />
			</div>
			
			<div class="mb-3">
				<label class="form-label" for="Email">Email</label>
				<input class="form-control" id="email" name="email" type="email" value="" />
			</div>
			
			<div class="mb-3">
				<label class="form-label" for="role">Role</label>
				<option selected>Selectioner un role</option>
				<select class="form-select" id="role" aria-label="">
					<option value="" disabled <?= empty($formData['role']) ? 'selected' : '' ?>>Choisissez un role</option>
					<option value="0">Joueur</option>
					<option value="1">Arbitre</option>
					<option value="2">Organisateur</option>
					<option value="3">Spectateur</option>
				</select>
			</div>
			
			<div class="mb-3">
				<label class="form-label" for="adresse">Adresse</label>
				<input class="form-control" id="adresse" name="adresse" type="text" value="" />
			</div>
			
			<div class="form-floating mb-3	">
				<option selected>Selectioner un poste</option>
				<select class="form-select" id="poste" aria-label="">
					<option value="" disabled <?= empty($formData['position']) ? 'selected' : '' ?>>Choisissez un poste</option>
					<option value="0">Meneur</option>
					<option value="1">Arrière</option>
					<option value="2">Ailier</option>
					<option value="3">Ailier fort</option>
					<option value="4">Pivot</option>
				</select>
				
			</div>
			
			<div class="mb-3">
				<label for="commentaire">Commentaire</label>
				<div class="form-floating">
					<textarea class="form-control" id="commentaire" name="commentaire" style="height: 100px"></textarea>
					<label for="commentaire">Commente ici</label>
				</div>
			</div>
			<div class="mb-3">
				<button type="valider" class="btn btn-primary w-100">Valider</button>
			</div>
		</form>
	</div>
</div>