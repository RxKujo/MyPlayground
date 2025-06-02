<?php

    include_once($includesConfig . 'auths.php');

    try {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_BASE . ";charset=utf8";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];
        $pdo = new PDO($dsn, DB_USER, DB_PASSWORD, $options);

    } catch(Exception $e) {
        http_response_code(500);
        die("Erreur de connexion à la base de données" . $e->getMessage());
    }
?>