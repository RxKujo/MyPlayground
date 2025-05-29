<?php

session_start();

if (!isset($_SESSION['user_info']) || !isset($_SESSION['user_id'])) {
    header('location: ../index.php');
    exit();
}


include_once('../includes/config/variables.php');

include_once($root . 'lib/fpdf/fpdf.php');

$user = $_SESSION['user_info'];
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

foreach ($user as $key => $value) {
    // Format field names
    $label = ucfirst(str_replace('_', ' ', $key));
    $pdf->MultiCell(0, 10, "$label: $value");
}

$pdf->Output();

?>