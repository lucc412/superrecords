<?php   
ob_start();
include("filepdf/fpdf.php");
include("dbclass/commonFunctions_class.php");
require('filepdf/mc_table.php');

$pdf=new PDF_MC_Table('L','mm','A4');
$pdf->AddPage();
$pdf->SetFont('arial','B',12);
$pdf->SetTextColor(4,126,167);
$pdf->Cell(30,10,'Email Options');
$pdf->Ln();
$curdate = date('d-M-Y');
$pdf->SetFont('arial','B',8);
$pdf->Cell(80,1,'Report generated at '.$curdate);
$pdf->Ln(10);

        $pdf->SetFillColor(4,126,167);
        $pdf->SetTextColor(255,255,255);
        $pdf->SetDrawColor(170,219,249);
        $pdf->SetLineWidth(.2);
        $pdf->SetFont('arial','B',11);
        
        $pdf->Cell(10,10,'No',1,0,'C',true);
        $pdf->Cell(40,10,'Name',1,0,'C',true);
        $pdf->SetFont('arial','B',8);
        $pdf->Cell(60,10,'Event when email will be sent automatically',1,0,'C',true);
        $pdf->SetFont('arial','B',11);
        $pdf->Cell(40,10,'Email Address',1,0,'C',true);
        $pdf->Cell(50,10,'Email Address/Description',1,0,'C',true);
        $pdf->Cell(80,10,'Content of the Email',1,0,'C',true);
        $pdf->Ln();
        
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(0,0,0);
//Table with 20 rows and 4 columns
$pdf->SetWidths(array(10,40,60,40,50,80));
$pdf->Data();

  $pdf->Output('Email_options.pdf');

header('Content-type: application/pdf');
// It will be called downloaded.pdf
header('Content-Disposition: attachment; filename="Email_options.pdf"');
// The PDF source is in original.pdf
readfile('Email_options.pdf');

 
?>

