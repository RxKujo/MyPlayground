<?php

session_start();

if (!isset($_SESSION['user_info']) || !isset($_SESSION['user_id'])) {
    header('location: ../index.php');
    exit();
}


include_once('../includes/config/variables.php');
include_once($includesConfig . 'functions.php');
include_once($root . 'lib/fpdf/fpdf.php');

$user = $_SESSION['user_info'];

$pdf = userPdf($user);
$pdf->Output();

?>