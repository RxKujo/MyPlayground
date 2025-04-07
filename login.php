<?php

include_once "includes/public/header.php";

session_start();
$isAuthenticated = isset($_SESSION['authenticated']) && $_SESSION['authenticated'];

if ($isAuthenticated) {
    header("Location: index.php");
    exit();
}
?>

<header class="navbar navbar-dark bg-dark py-0 my-0">
    <div class="container-fluid">
        <a id="nav-logo" class="navbar-brand pb-0" href="#" data-page="home">
            <img src="assets/public/img/logo.png" alt="Logo" class="logo d-inline-block align-text-center">
            <span class="logo-text" style="font-size: 28px;">My PlayGround</span>
        </a>
    </div>
</header>

<div id="login-page" class="container-fluid d-flex flex-column align-items-center vh-100 mt-5">
    
    <div>
        <div>
            <h1 style="font-size: 60px;">Se connecter</h1>
        </div>
        <div role="form-container">
            <div class="mb-3">
                <label for="username" class="form-label">Email*</label>
                <input type="text" class="form-control" id="username" placeholder="Entrez votre adresse email" required>

                <label for="password">Password*</label>
                <input type="password" class="form-control" id="password" placeholder="Entrez votre mot de passe" required>

                <button type="submit" class="btn btn-primary mt-3" id="login-button">Se connecter</button>
                <button type="button" class="btn btn-secondary mt-3" id="register-button">S'inscrire</button>
            </div>
        </div>
    </div>
</div>

