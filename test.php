
<?php
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
require_once "vendor/autoload.php";

include_once "includes/global/session.php";


echo "<p>Bonjour! Ce serveur fonctionne.</p>";

print($_SERVER['HTTP_HOST']);

var_dump($_SESSION['user_info']);


$username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$captcha = filter_input(INPUT_POST, "captcha", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

echo $username, $password, $captcha;

?>

<?php
include_once "includes/global/footer.php";
?>