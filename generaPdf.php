<?php



require(dirname(__FILE__).'/fpdf/fpdf.php');
header('Content-type: application/pdf');
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(40,10,utf8_decode('¡Hola, Mundo!'));
$pdf->Output();
?>
