<?php

if (!isAdmin($_SESSION['user_info'])) {
    http_response_code(401);
    exit();
}

?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <link href="../../assets/admin/css/style.css" rel="stylesheet">
	    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
        <title>My Playground - Page Administrateur</title>
        
        <script type="module" src="/assets/admin/js/switchScript.js"></script>
    </head>

    <body>