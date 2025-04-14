<?php
    session_start();
    $isAuthenticated = isset($_SESSION['authenticated']) && $_SESSION['authenticated'];
    if (!$isAuthenticated) {
        header("Location: login.php");
        exit();
    }

    if(isset($_POST['disconnect'])) {
        session_destroy();
        header("Location: login.php");
        exit();
    }

include_once $_SERVER['DOCUMENT_ROOT'] . "/MyPlayground/data.php";
$settings_path = $root . "/Myplayground/deauth.php";

echo "<form method='post' action=deauth.php id='settings-form'>";
echo    "<input type='submit' name='disconnect' class='btn btn-primary mt-3' id='disconnect-button' value='Disconnect'/>";
echo "</form>";

?>

