<?php

session_start();

include_once 'includes/config/variables.php';
include_once $assetsShared . 'icons/icons.php';
include_once $includesConfig . 'functions.php';

$login_error = $_SESSION['login_error'] ?? null;
$register_success = $_SESSION['register-success'] ?? null;
$captcha_error = $_SESSION['captcha_error'] ?? null;

$shapes = ['cercle', 'carré', 'triangle', 'rectangle'];
$random_shape = $shapes[array_rand($shapes)];

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Se connecter</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
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
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header-title">
        <img src="assets/public/img/logo.png" alt="Logo" />
        <h1>Se connecter</h1>
    </div>

    <?php
    if (!is_null($login_error)) {
        alertMessage($login_error, 1);
        $_SESSION['login_error'] = null;
    }
    if (!is_null($register_success)) {
        alertMessage($register_success, 0);
        $_SESSION['register-success'] = null;
    }
    if (!is_null($captcha_error)) {
        echo '<div class="error-message">' . htmlspecialchars($captcha_error) . '</div>';
        $_SESSION['captcha_error'] = null;
    }
    ?>

    <div class="form-container">

        <form method="post" action="auth.php" id="login-form">
            <div class="mb-3">
                <label for="username" class="form-label">Nom d'utilisateur</label>
                <input type="text" class="form-control" id="username" name="username" required autocomplete="username" />
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" class="form-control" id="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="form-check mb-3">
                <input type="checkbox" class="form-check-input" id="captcha-checkbox" />
                <label class="form-check-label" for="captcha-checkbox">Je ne suis pas un robot</label>
            </div>

            <div id="captcha-selection" style="display:none; margin-bottom: 15px;">
                <div class="captcha-instruction">
                    Cliquez sur la forme : <strong id="captcha-shape"><?php echo ucfirst($random_shape); ?></strong>
                </div>
                <div>
                    <?php
                    $svgShapes = [
                        'cercle' => '<svg width="40" height="40"><circle cx="20" cy="20" r="15" stroke="#555" stroke-width="2" fill="transparent" /></svg>',
                        'carré' => '<svg width="40" height="40"><rect x="7" y="7" width="26" height="26" stroke="#555" stroke-width="2" fill="transparent" /></svg>',
                        'triangle' => '<svg width="40" height="40"><polygon points="20,6 34,34 6,34" stroke="#555" stroke-width="2" fill="transparent" /></svg>',
                        'rectangle' => '<svg width="50" height="30"><rect x="2" y="5" width="46" height="20" stroke="#555" stroke-width="2" fill="transparent" /></svg>',
                    ];

                    foreach ($shapes as $shape) {
                        $shapeLower = strtolower($shape);
                        echo '<div tabindex="0" class="shape-button" data-shape="' . $shapeLower . '" aria-label="Choisir la forme ' . $shape . '">';
                        echo $svgShapes[$shapeLower];
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>

            <input type="hidden" id="captcha-input" name="captcha" value="" />
            <input type="hidden" name="expected_captcha" value="<?php echo htmlspecialchars($random_shape); ?>" />

            <button type="submit" id="submit-btn" class="btn btn-primary w-100" disabled>Se connecter</button>
        </form>

        <div class="text-center mt-3">
            <p>Vous n'avez pas de compte ? <a href="register.php" class="text-primary">Inscrivez-vous ici</a>.</p>
        </div>
    </div>
</div>

<script>
    const checkbox = document.getElementById('captcha-checkbox');
    const captchaSelection = document.getElementById('captcha-selection');
    const captchaShapeText = document.getElementById('captcha-shape').textContent.toLowerCase();
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
