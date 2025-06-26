<?php

include_once 'includes/global/session.php';

$error = $_SESSION['register_error'] ?? null;
$success = $_SESSION['register_success'] ?? null;

$formData = $_SESSION['form_data'] ?? [];
unset($_SESSION['error'], $_SESSION['form_data']);

$stmt = $pdo->query("
    SELECT id, question, reponse FROM captcha
    ORDER BY RAND() LIMIT 1
");
$captcha = $stmt->fetch();

$captcha_id = $captcha['id'];
$question = $captcha['question'];
$reponse = $captcha['reponse'];


$_SESSION['captcha_expected'] = $reponse;
$_SESSION['captcha_id'] = $captcha_id;
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Créer un compte</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script type="module" src="assets/public/js/pageScript.js"></script>
  <style>
    .form-container {
      max-width: 600px;
      margin: 30px auto;
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
      font-size: 32px;
      font-weight: bold;
      margin: 0;
    }

    .shape-button {
      display: inline-block;
      border: 2px solid #555;
      border-radius: 6px;
      margin: 5px;
      padding: 8px;
      cursor: pointer;
      user-select: none;
      transition: border-color 0.3s, background-color 0.3s;
    }

    .shape-button:hover,
    .shape-button:focus {
      border-color: #0d6efd;
      outline: none;
    }

    .shape-button.selected {
      background-color: #0d6efd;
      border-color: #0a58ca;
    }

    .captcha-instruction {
      margin-bottom: 10px;
      font-weight: 600;
      font-size: 1.1rem;
    }

    .error-message {
      color: #dc3545;
      font-weight: 600;
      margin-bottom: 15px;
      text-align: center;
    }

    .success-message {
      color: green;
      font-weight: 600;
      margin-bottom: 15px;
      text-align: center;
    }
  </style>
</head>

<body>
  <div id="content" class="container">
    <div class="header-title pt-3">
      <img src="assets/public/img/logo.png" alt="Logo" />
      <h1>Créer un compte</h1>
    </div>

    <?php if ($error): ?>
      <div class="error-message"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <?php if ($success): ?>
      <div class="error-message"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <div class="form-container">
      <form method="post" action="processes/register_process.php" id="register-form" novalidate>
        <label for="name" class="form-label">Nom*</label>
        <div id="name" class="row gx-3 justify-content-start mb-3">
          <div class="col">
            <input type="text" class="form-control" id="prenom" name="prenom"
              value="<?= htmlspecialchars($formData['prenom'] ?? '') ?>" required>
            <span class="form-text">
              Prénom
            </span>
          </div>
          <div class="col">
            <input type="text" class="form-control" id="nom" name="nom"
              value="<?= htmlspecialchars($formData['nom'] ?? '') ?>" required>
            <span class="form-text">
              Nom
            </span>
          </div>
        </div>

        <div class="row gx-3 justify-content-start mb-3">
          <div class="col">
            <label for="email" class="form-label">Adresse e-mail*</label>
            <input type="email" class="form-control" id="email" name="email"
              value="<?= htmlspecialchars($formData['email'] ?? '') ?>" placeholder="nom@exemple.fr" required>
          </div>

          <div class="col">
            <label for="phone" class="form-label">Numéro de téléphone*</label>
            <input type="tel" class="form-control" id="tel" name="tel"
              value="<?= htmlspecialchars($formData['tel'] ?? '') ?>" required>
          </div>
        </div>

        <label for="naissance" class="form-label">Date de naissance*</label>
        <div class="mb-3">
          <input type="date" class="form-control" id="naissance" name="naissance"
            value="<?= htmlspecialchars($formData['naissance'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
          <label for="adresse" class="form-label">Adresse*</label>
          <input type="text" class="form-control" id="adresse" name="adresse"
            value="<?= htmlspecialchars($formData['adresse'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
          <label for="pseudo" class="form-label">Nom d'utilisateur*</label>
          <input type="text" class="form-control" id="pseudo" name="pseudo"
            value="<?= htmlspecialchars($formData['pseudo'] ?? '') ?>" required>
        </div>

        <div class="row mb-3">
          <div class="col">
            <label for="role-container" class="form-label">Role*</label>
            <div id="role-container">
              <div class="formcheck">
                <input class="form-check-input" type="radio" name="role" id="joueur" value="0" checked>
                <label class="form-check-label" for="joueur">Joueur</label>
              </div>
              <div class="formcheck">
                <input class="form-check-input" type="radio" name="role" id="arbitre" value="1">
                <label class="form-check-label" for="arbitre">Arbitre</label>
              </div>
              <div class="formcheck">
                <input class="form-check-input" type="radio" name="role" id="organisateur" value="2">
                <label class="form-check-label" for="organisateur">Organisateur</label>
              </div>
              <div class="formcheck">
                <input class="form-check-input" type="radio" name="role" id="spectateur" value="3">
                <label class="form-check-label" for="spectateur">Spectateur</label>
              </div>
            </div>
          </div>

          <div class="col">
            <label for="position-container" class="form-label">Poste*</label>
            <div id="position-container">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="position" id="meneur" value="0" checked>
                <label class="form-check-label" for="meneur">
                  Meneur de jeu
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="position" id="arriere" value="1">
                <label class="form-check-label" for="arriere">
                  Arrière
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="position" id="ailier" value="2">
                <label class="form-check-label" for="ailier">
                  Ailier
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="position" id="ailierfort" value="3">
                <label class="form-check-label" for="ailierfort">
                  Ailier fort
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="position" id="pivot" value="4">
                <label class="form-check-label" for="pivot">
                  Pivot
                </label>
              </div>
            </div>
          </div>

          <div class="col">
            <label for="level-container" class="form-label">Niveau*</label>
            <div id="level-container">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="niveau" id="debutant" value="0" checked>
                <label class="form-check-label" for="debutant">
                  Débutant
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="niveau" id="intermediaire" value="1">
                <label class="form-check-label" for="intermediaire">
                  Intermédiaire
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="niveau" id="avance" value="2">
                <label class="form-check-label" for="avance">
                  Avancé
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="niveau" id="pro" value="3">
                <label class="form-check-label" for="pro">
                  Pro
                </label>
              </div>
            </div>
          </div>
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Mot de passe*</label>
          <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="mb-3">
          <label for="confirm_password" class="form-label">Confirmez le mot de passe*</label>
          <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
        </div>

        <div class="form-check mb-3">
          <input type="checkbox" class="form-check-input" id="captcha-checkbox" />
          <label class="form-check-label" for="captcha-checkbox">Je ne suis pas un robot</label>
        </div>

        <div id="captcha-selection" style="display:none; margin-bottom: 15px;">
          <div class="captcha-instruction">
            <?= htmlspecialchars($question) ?> : <strong id="captcha-shape"><?= htmlspecialchars($reponse) ?></strong>
          </div>
          <div>
            <?php
            $svgShapes = [
              'cercle' => '<svg width="40" height="40"><circle cx="20" cy="20" r="15" stroke="#555" stroke-width="2" fill="transparent" /></svg>',
              'carre' => '<svg width="40" height="40"><rect x="7" y="7" width="26" height="26" stroke="#555" stroke-width="2" fill="transparent" /></svg>',
              'triangle' => '<svg width="40" height="40"><polygon points="20,6 34,34 6,34" stroke="#555" stroke-width="2" fill="transparent" /></svg>',
              'rectangle' => '<svg width="50" height="30"><rect x="2" y="5" width="46" height="20" stroke="#555" stroke-width="2" fill="transparent" /></svg>',
            ];
            foreach ($svgShapes as $shape => $svg) {
              echo '<div tabindex="0" class="shape-button" data-shape="' . $shape . '" aria-label="Choisir la forme ' . $shape . '">';
              echo $svg;
              echo '</div>';
            }
            ?>
          </div>
        </div>

        <input type="hidden" id="captcha-input" name="captcha" value="" />

        <button type="submit" id="submit-btn" class="btn btn-primary w-100" disabled>Créer un compte</button>
      </form>

      <div class="text-center mt-3">
        <p>Vous avez déjà un compte ? <a href="login.php" class="text-primary">Connectez-vous ici</a>.</p>
      </div>
    </div>
  </div>

  <script>
    const checkbox = document.getElementById('captcha-checkbox');
    const captchaSelection = document.getElementById('captcha-selection');
    const captchaShapeText = "<?= strtolower($reponse) ?>";
    const shapeButtons = document.querySelectorAll('.shape-button');
    const captchaInput = document.getElementById('captcha-input');
    const submitBtn = document.getElementById('submit-btn');

    checkbox.addEventListener('change', () => {
      if (checkbox.checked) {
        captchaSelection.style.display = 'block';
        submitBtn.disabled = true;
      } else {
        captchaSelection.style.display = 'none';
        captchaInput.value = '';
        submitBtn.disabled = true;
        shapeButtons.forEach(btn => btn.classList.remove('selected'));
      }
    });

    shapeButtons.forEach(button => {
      button.addEventListener('click', () => {
        const selectedShape = button.getAttribute('data-shape');
        shapeButtons.forEach(btn => btn.classList.remove('selected'));

        if (selectedShape === captchaShapeText) {
          button.classList.add('selected');
          captchaInput.value = selectedShape;
          submitBtn.disabled = false;
        } else {
          captchaInput.value = '';
          submitBtn.disabled = true;
        }
      });
    });
  </script>
</body>

</html>