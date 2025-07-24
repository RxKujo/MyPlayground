<?php
require_once "../../includes/config/config.php";

$csv = fopen("cities.csv", "r");
if (!$csv) {
    die("Erreur d'ouverture du fichier CSV.");
}

$pdo->exec("DELETE FROM villes_cp");

$ligne = 0;
while (($data = fgetcsv($csv, 1000, ",")) !== FALSE) {
    if ($ligne++ === 0) continue;

    list($insee, $e, $code_postal, $nom_commune, $latitude, $longitude, $f, $g, $h, $i) = $data;

    $stmt = $pdo->prepare("INSERT INTO villes_cp (ville, code_postal, latitude, longitude, insee) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$nom_commune, $code_postal, $latitude, $longitude, $insee]);
}

fclose($csv);
echo "Import terminé avec succès.";
?>