<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("location: ../index.php");
    exit();
}


header("Location: ../matches");
exit();
?>