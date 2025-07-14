<?php

    $root = $_SERVER['DOCUMENT_ROOT'];
    
    include_once $root . "/includes/config/functions.php";

    $isAuthenticated = isAuthenticated();

    if (!$isAuthenticated) {
        echo "<script>window.location.href = 'index.php';</script>";
        exit();
    }

    if(isset($_POST['disconnect'])) {
        session_destroy();
        deleteCookie('user');
        echo "<script>window.location.href = 'index.php';</script>";
        exit();
    }

$deauth_path = $root . "/deauth.php";

echo "<form method='post' action=" . $deauth_path . " id='settings-form'>";
echo    "<input type='submit' name='disconnect' class='btn btn-primary mt-3' id='disconnect-button' value='Disconnect'/>";
echo "</form>";

?>

