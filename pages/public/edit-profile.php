<?php
//test
// $utilisateur['id'] ;
session_start();
$error = isset($_SESSION['error']) ? $_SESSION['error'] : null;
$formData = isset($_SESSION['form_data']) ? $_SESSION['form_data'] : [];
unset($_SESSION['error'], $_SESSION['form_data']);


include_once('../../includes/public/header.php');
include_once('../../includes/config/config.php');
include_once('../../includes/config/functions.php');

include_once "navbar/header.html";

$user = getUser($pdo, $_SESSION['user_id']);

if (!$user || is_null($user)) {
	header("location: ../../index.php");
	exit();
}

switch ($user['niveau']) {
    case 0:
        $niveau = 'Débutant';
        break;
    case 1:
        $niveau = 'Intérmediaire';
        break;
    case 2:
        $niveau = 'Avancé';
        break;
    case 3:
        $niveau = 'Pro';
        break;
	default:
		$niveau = 'Inconnu';
		break;
}

switch ($user['poste']) {
    case 0:
        $position = 'Meneur de jeu';
        break;
    case 1:
        $position = 'Arrière';
        break;
    case 2:
        $position = 'Ailier';
        break;
    case 3:
        $position = 'Ailier fort';
        break;
    case 4:
        $position = 'Pivot';
        break;
	default:
		$position = 'Inconnu';
		break;
}

switch ($user['role']) {
    case 0:
        $role = 'Joueur';
        break;
    case 1:
        $role = 'Arbitre';
        break;
    case 2:
        $role = 'Organisateur';
        break;
    case 3:
        $role = 'Spectateur';
		break;
	default:
		$role = 'Inconnu';
		break;
}

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
				<input class="form-control" name="id" type="hidden" value="" />
				
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

				<div class="mb-3">
					<label class="form-label" for="localisation">Adresse</label>
					<input class="form-control" id="localisation" name="localisation" type="text" value="<?= $user['localisation'] ?>"/>
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
						<option value="<?= $user['poste'] ?>" selected=""><?= $position ?></option>
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
					<button type="submit" class="btn btn-primary w-100">Valider</button>
				</div>
			</form>
		</div>
	</div>
</div>

<?php
include_once('../../includes/global/footer.php');
?>