<?php
require_once "../includes/config/config.php";

// Chargement du fichier cities.csv (coordonnées)
$cities = [];
$cities_csv = fopen("cities.csv", "r");
if (!$cities_csv) die("Erreur d'ouverture cities.csv.");

$ligne = 0;
while (($data = fgetcsv($cities_csv, 1000, ",")) !== FALSE) {
    if ($ligne++ === 0) continue;

    // Exemple : insee_code = 0, city_code = 1, zip_code = 2, ..., latitude = 4, longitude = 5
    $insee_code = str_pad($data[0], 5, "0", STR_PAD_LEFT);
    $latitude = $data[4] !== "" ? $data[4] : null;
    $longitude = $data[5] !== "" ? $data[5] : null;

    $cities[$insee_code] = [
        "latitude" => $latitude,
        "longitude" => $longitude
    ];
}
fclose($cities_csv);

// Chargement du fichier 019HexaSmal.csv (bons noms + code postal)
$hexa_csv = fopen("019HexaSmal.csv", "r");
if (!$hexa_csv) die("Erreur d'ouverture 019HexaSmal.csv.");

$pdo->exec("DELETE FROM villes_cp");

$ligne = 0;
while (($data = fgetcsv($hexa_csv, 1000, ";")) !== FALSE) {
    if ($ligne++ === 0) continue;

    $code_insee = str_pad($data[0], 5, "0", STR_PAD_LEFT);
    $ville = $data[1];
    $code_postal = $data[2];

    if (!isset($cities[$code_insee])) continue; // Skip si pas de coordonnées

    $latitude = $cities[$code_insee]['latitude'];
    $longitude = $cities[$code_insee]['longitude'];

    $stmt = $pdo->prepare("INSERT INTO villes_cp (ville, code_postal, code_insee, latitude, longitude) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$ville, $code_postal, $code_insee, $latitude, $longitude]);
}

fclose($hexa_csv);
echo "Import terminé avec succès.";
?>
