<!-- filepath: c:\xampp\htdocs\MyPlayground-main\login.php -->
<?php
session_start();
$error = isset($_SESSION['error']) ? $_SESSION['error'] : null;
unset($_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Se connecter</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <style>
        .logo {
            height: 50px;
        }
        .form-container {
            max-width: 50%;
            margin: 0 auto;
        }
        .form-label {
            font-weight: bold;
        }
        .form-control {
            height: 50px;
        }
    </style>
</head>
<body>
<header class="navbar navbar-dark bg-dark py-2">
    <div class="container-fluid d-flex align-items-center">
        <a id="nav-logo" class="navbar-brand d-flex align-items-center" href="#">
            <img src="assets/public/img/logo.png" alt="Logo" class="logo me-2">
            <span class="logo-text" style="font-size: 24px;">My PlayGround</span>
        </a>
    </div>
</header>

<div id="login-page" class="container-fluid d-flex flex-column align-items-center vh-100 mt-5">
    <div class="text-center mb-4">
        <h1 style="font-size: 40px;">Se connecter</h1>
    </div>
    <div class="form-container">
        <!-- Affichage des messages d'erreur -->
        <?php if ($error): ?>
            <div class="alert alert-danger">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="post" action="auth.php" id="auth-form">
            <label for="username" class="form-label">Email*</label>
            <input type="text" class="form-control" name="username" id="username" placeholder="Entrez votre adresse email" required>

            <label for="password" class="form-label mt-3">Mot de passe*</label>
            <input type="password" class="form-control" name="password" id="password" placeholder="Entrez votre mot de passe" required>

            <!-- Google reCAPTCHA -->
            <div class="g-recaptcha mt-3" data-sitekey="6Lfq0ygrAAAAAOOVSLRni4JPsubDCUxMjUshXuJF"></div>

            <button type="submit" class="btn btn-primary mt-4 w-100">Se connecter</button>
        </form>
        <div class="text-center mt-3">
            <p>Pas encore de compte ? <a href="register.php" class="text-primary">Inscrivez-vous ici</a>.</p>
        </div>
    </div>
</div>
</body>
</html>