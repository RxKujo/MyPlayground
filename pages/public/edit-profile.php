<?php

include_once '../../includes/global/session.php';

$error = isset($_SESSION['error']) ? $_SESSION['error'] : null;
unset($_SESSION['error'], $_SESSION['form_data']);

notLogguedSecurity("/");

include_once($assetsShared . 'icons/icons.php');

include_once($includesPublic . 'header.php');
include_once "navbar/header.php";

$user = $_SESSION['user_info'];

$niveau = getUserLevel($user);
$poste = getUserPosition($user);
$role = getUserRole($user);

?>
<div class="d-flex">
    <?php
        include_once "navbar/navbar.php";
    ?>

	<div class="container">	
		<div class="header-title">
			<h1>Modifier votre profil</h1>
		</div>
		<div class="form-container">

			<form method="POST" action="../../processes/edit_profile_process.php">
				<input class="form-control" name="id" type="hidden" value="<?php $user['id'] ?>" />
				
				<div class="mb-3">
					<label class="form-label" for="nom">Nom</label>
					<input class="form-control" id="nom" name="nom" type="text" value="<?= $user['nom'] ?>"/>
				</div>
				<div class="mb-3">
					<label class="form-label" for="prenom">Prenom</label>
					<input class="form-control" id="prenom" name="prenom" type="text" value="<?= $user['prenom'] ?>"/>
				</div>
				
				<div class="mb-3">
					<label class="form-label" for="pseudo">Pseudonyme</label>
					<input class="form-control" id="pseudo" name="pseudo" type="text" value="<?= $user['pseudo'] ?>"/>
				</div>
				
				<div class="mb-3">
					<label class="form-label" for="tel">Téléphone</label>
					<input class="form-control" id="tel" name="tel" type="tel" value="<?= $user['tel'] ?>"/>
				</div>
				
				<div class="mb-3">
					<label class="form-label" for="email">Email</label>
					<input class="form-control" id="email" name="email" type="email" value="<?= $user['email'] ?>"/>
				</div>

				<div class="mb-3 position-relative">
					<label class="form-label" for="ville_input">Ville</label>
					<input 
						type="text" 
						class="form-control" 
						id="ville_input" 
						name="ville_text" 
						autocomplete="off" 
						value="<?= htmlspecialchars(($user['ville_nom'] ?? '') . (!empty($user['code_postal']) ? ' (' . $user['code_postal'] . ')' : '')) ?>"
					/>
					<input type="hidden" id="ville_id" name="ville_id" value="<?= htmlspecialchars($user['ville_id'] ?? '') ?>">

					<div id="ville_suggestions" class="list-group position-absolute w-100" style="z-index: 9999;"></div>
				</div>

				
				<div class="mb-3">
					<label class="form-label" for="niveau">Niveau</label>
					<select class="form-select" id="niveau" name="niveau" aria-label="">
						<option value="<?= $user['niveau'] ?>" selected><?= $niveau ?></option>
						<option value="0">Débutant</option>
						<option value="1">Intermédiaire</option>
						<option value="2">Avancé</option>
						<option value="3">Pro</option>
					</select>
				</div>
				
				
				<div class="mb-3">
					<label class="form-label" for="role">Role</label>
					<select class="form-select" id="role" name="role" aria-label="">
						<option value="<?= $user['role'] ?>" selected><?= $role ?></option>
						<option value="0">Joueur</option>
						<option value="1">Arbitre</option>
						<option value="2">Organisateur</option>
						<option value="3">Spectateur</option>
					</select>
				</div>
				
				<div class="mb-3">
					<label class="form-label" for="poste">Poste</label>
					<select class="form-select" id="poste" name="poste">
						<option value="<?= $user['poste'] ?>" selected=""><?= $poste ?></option>
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
						<textarea class="form-control" id="commentaire" name="commentaire" style="height: 100px"><?= htmlspecialchars($user['description'] ?? '') ?></textarea>
						<label for="commentaire">Commente ici</label>
					</div>
				</div>
				<div class="mb-3">
					<button type="submit" class="btn btn-primary w-100">Valider</button>
				</div>
			</form>
		</div>
	</div>
</div>
<script src="../../assets/shared/js/cityManager.js"></script>

<?php
include_once('../../includes/global/footer.php');
?>