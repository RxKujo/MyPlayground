<?php

include_once("../includes/global/session.php");

include_once($root . 'lib/fpdf/fpdf.php');

$user = $_SESSION['user_info'];

$pdf = userPdf($user);
$pdf->Output();

?>