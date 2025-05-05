<?php

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
    <style>
        .form-container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
        }
        .header-title {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 30px;
        }
        .header-title img {
            height: 50px;
            margin-right: 15px;
        }
        .header-title h1 {
            font-size: 36px;
            font-weight: bold;
            margin: 0;
        }
    </style>
</head>
<body>
<div class="container">

    <div class="header-title">
        <img src="assets/public/img/logo.png" alt="Logo">
        <h1>Se connecter</h1>
    </div>
    <div class="form-container">
     
        <?php if ($error): ?>
            <div class="alert alert-danger text-center">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>
        
        <form method="post" action="auth.php">
            <div class="mb-3">
                <label for="username" class="form-label">Nom d'utilisateur</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Se connecter</button>
        </form>
        <div class="text-center mt-3">
            <p>Vous n'avez pas de compte ? <a href="register.php" class="text-primary">Inscrivez-vous ici</a>.</p>
        </div>
    </div>
</div>
</body>
</html>
