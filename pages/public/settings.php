<?php
    include_once $includesConfig . "functions.php";

    $isAuthenticated = isAuthenticated();

    if (!$isAuthenticated) {
        header("Location: login.php");
        exit();
    }

    if(isset($_POST['disconnect'])) {
        session_destroy();
        deleteCookie('user');
        header("Location: login.php");
        exit();
    }

$settings_path = $root . "/Myplayground/deauth.php";

echo "<form method='post' action=deauth.php id='settings-form'>";
echo    "<input type='submit' name='disconnect' class='btn btn-primary mt-3' id='disconnect-button' value='Disconnect'/>";
echo "</form>";

?>

