
<?php

include_once "includes/config/config.php";
include_once 'includes/config/functions.php';


echo "<p>Bonjour! Ce serveur fonctionne.</p>";
echo "<p>root: " . $_SERVER['DOCUMENT_ROOT'] . "</p>";
echo "<p>root project: /MyPlayground</p>";

$user = getUser($pdo, 1);

echo var_dump($user['prenom']);


?>