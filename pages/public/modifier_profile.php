<?php
include_once '../includes/test.php';

if (($_SERVER)['REQUEST_METHOD']== 'GET') {

    
}
?>
<form method="post" action="admin_edit.php">
	<input name="id" type="hidden" value="<?= $utilisateur['id'] ;?>" />

	<p>
		<label for="nom">Nom</label>
		<input id="nom" name="nom" type="text" value="<?= $utilisateur['nom'] ;?>" />
	</p>
	<p>
		<label for="prenom">Prenom</label>
		<input id="prenom" name="prenom" type="text" value="<?= $utilisateur['prenom'] ;?>" />
	</p>
	
	<p>
		<label for="speudo">Speudo</label>
		<input id="speudo" name="speudo" type="text" value="<?= $utilisateur['speudo'] ;?>" />
	</p>
	
	<p>
		<label for="poste">Poste</label>
		<input id="poste" name="poste" type="text" value="<?= $utilisateur['poste'] ;?>" />
	</p>

    <p>
		<label for="niveau">Niveau</label>
		<input id="niveau" name="niveau" type="text" value="<?= $utilisateur['niveau'] ;?>" />
	</p>

    <p>
		<label for="tel">Téléphone</label>
		<input id="tel" name="tel" type="tel" value="<?= $utilisateur['tel'] ;?>" />
	</p>

    <p>
		<label for="Email">Email</label>
		<input id="email" name="email" type="email" value="<?= $utilisateur['email'] ;?>" />
	</p>

    <p>
		<label for="poste">poste</label>
		<input id="poste" name="poste" type="date" value="<?= $utilisateur['role'] ;?>" />
	</p>

    <p>
		<label for="poste">poste</label>
		<input id="poste" name="poste" type="date" value="<?= $utilisateur['adresse'] ;?>" />
	</p>

    <p>
		<label for="poste">poste</label>
		<input id="poste" name="poste" type="date" value="<?= $utilisateur['date_poste'] ;?>" />
	</p>
	
	<p>
		<label for="commentaire">Commentaire</label>
		<textarea id="commentaire" name="commentaire"><?= $utilisateur['description'] ;?></textarea>
	</p>

	<button type="submit">Valider</button>
</form>