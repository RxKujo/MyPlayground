<?php
include_once 'includes/config/variables.php';
include_once 'includes/config/config.php';
include_once 'includes/config/functions.php';



echo "<p>Bonjour! Ce serveur fonctionne.</p>";

echo isBanned($pdo, getUser($pdo, 1));


// $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
// $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
// $captcha = filter_input(INPUT_POST, "captcha", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

// echo $username, $password, $captcha;

?>

<?php
include_once "includes/global/footer.php";
?>