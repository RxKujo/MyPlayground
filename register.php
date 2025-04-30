<!-- filepath: c:\xampp\htdocs\MyPlayground-main\register.php -->
<?php
session_start();
$error = isset($_SESSION['error']) ? $_SESSION['error'] : null;
$formData = isset($_SESSION['form_data']) ? $_SESSION['form_data'] : [];
unset($_SESSION['error'], $_SESSION['form_data']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un compte</title>
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

<div id="register-page" class="container-fluid d-flex flex-column align-items-center vh-100 mt-5">
    <div class="text-center mb-4">
        <h1 style="font-size: 40px;">Créer un compte</h1>
    </div>
    <div class="form-container">
        <!-- Affichage des messages d'erreur -->
        <?php if ($error): ?>
            <div class="alert alert-danger">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="post" action="register_process.php" id="register-form">
            <label for="firstname" class="form-label">Prénom*</label>
            <input type="text" class="form-control" name="firstname" id="firstname" placeholder="Entrez votre prénom" value="<?= htmlspecialchars($formData['firstname'] ?? '') ?>" required>

            <label for="lastname" class="form-label mt-3">Nom*</label>
            <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Entrez votre nom" value="<?= htmlspecialchars($formData['lastname'] ?? '') ?>" required>

            <label for="email" class="form-label mt-3">Adresse e-mail*</label>
            <input type="email" class="form-control" name="email" id="email" placeholder="Entrez votre adresse e-mail" value="<?= htmlspecialchars($formData['email'] ?? '') ?>" required>

            <label for="password" class="form-label mt-3">Mot de passe*</label>
            <input type="password" class="form-control" name="password" id="password" placeholder="Entrez votre mot de passe" required>

            <label for="confirm_password" class="form-label mt-3">Confirmez le mot de passe*</label>
            <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirmez votre mot de passe" required>

            <!-- Google reCAPTCHA -->
            <div class="g-recaptcha mt-3" data-sitekey="6Lfq0ygrAAAAAOOVSLRni4JPsubDCUxMjUshXuJF"></div>

            <button type="submit" class="btn btn-primary mt-4 w-100">Créer un compte</button>
        </form>
        <div class="text-center mt-3">
            <p>Déjà un compte ? <a href="login.php" class="text-primary">Connectez-vous ici</a>.</p>
        </div>
    </div>
</div>
</body>
</html>