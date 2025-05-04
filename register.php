
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
        .form-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
        }
        .form-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
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
        <h1>Créer un compte</h1>
    </div>
    <div class="form-container">
    
        <?php if ($error): ?>
            <div class="alert alert-danger text-center">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>
        
        <form method="post" action="register_process.php">
            <div class="mb-3">
                <label for="firstname" class="form-label">Prénom*</label>
                <input type="text" class="form-control" id="firstname" name="firstname" 
                       value="<?= htmlspecialchars($formData['firstname'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label for="lastname" class="form-label">Nom*</label>
                <input type="text" class="form-control" id="lastname" name="lastname" 
                       value="<?= htmlspecialchars($formData['lastname'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Adresse e-mail*</label>
                <input type="email" class="form-control" id="email" name="email" 
                       value="<?= htmlspecialchars($formData['email'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Numéro de téléphone*</label>
                <input type="tel" class="form-control" id="phone" name="phone" 
                       value="<?= htmlspecialchars($formData['phone'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Adresse*</label>
                <input type="text" class="form-control" id="address" name="address" 
                       value="<?= htmlspecialchars($formData['address'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Nom d'utilisateur*</label>
                <input type="text" class="form-control" id="username" name="username" 
                       value="<?= htmlspecialchars($formData['username'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label for="position" class="form-label">Poste*</label>
                <select class="form-select" id="position" name="position" required>
                    <option value="" disabled <?= empty($formData['position']) ? 'selected' : '' ?>>Choisissez un poste</option>
                    <option value="meneur" <?= (isset($formData['position']) && $formData['position'] === 'meneur') ? 'selected' : '' ?>>Meneur</option>
                    <option value="arrière" <?= (isset($formData['position']) && $formData['position'] === 'arrière') ? 'selected' : '' ?>>Arrière</option>
                    <option value="ailier" <?= (isset($formData['position']) && $formData['position'] === 'ailier') ? 'selected' : '' ?>>Ailier</option>
                    <option value="ailier fort" <?= (isset($formData['position']) && $formData['position'] === 'ailier fort') ? 'selected' : '' ?>>Ailier fort</option>
                    <option value="pivot" <?= (isset($formData['position']) && $formData['position'] === 'pivot') ? 'selected' : '' ?>>Pivot</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe*</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirmez le mot de passe*</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
            </div>
           
            <div class="g-recaptcha mb-3" data-sitekey="6Lfq0ygrAAAAAOOVSLRni4JPsubDCUxMjUshXuJF"></div>
            <button type="submit" class="btn btn-primary w-100">Créer un compte</button>
        </form>
        <div class="text-center mt-3">
            <p>Déjà un compte ? <a href="login.php" class="text-primary">Connectez-vous ici</a>.</p>
        </div>
    </div>
</div>
</body>
</html>
