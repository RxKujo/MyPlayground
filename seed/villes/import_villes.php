<?php
// Connexion à la BDD
require_once "../includes/config/config.php"; // adapte ce chemin selon ton projet

$csv = fopen("019HexaSmal.csv", "r"); // mets ici le bon chemin vers ton fichier
if (!$csv) {
    die("Erreur d'ouverture du fichier CSV.");
}

// Supprimer les données existantes (optionnel)
$pdo->exec("DELETE FROM temp");

$ligne = 0;
while (($data = fgetcsv($csv, 1000, ";")) !== false) {
    if ($ligne++ === 0) continue; // on saute l'en-tête

    // On sécurise la lecture même s'il manque la colonne ligne_5
    $insee       = $data[0] ?? null;
    $commune     = $data[1] ?? null;
    $code_postal = $data[2] ?? null;
    $libelle     = $data[3] ?? null;
    $ligne5      = $data[4] ?? null;

    $stmt = $pdo->prepare("INSERT INTO temp (code_insee, ville, code_postal, acheminement, ligne_5)
                           VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$insee, $commune, $code_postal, $libelle, $ligne5]);
}

fclose($csv);
echo "Import terminé avec succès.";
