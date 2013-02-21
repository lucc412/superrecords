<?php   
ob_start();
include("filepdf/fpdf.php");
include 'dbclass/commonFunctions_class.php';
class PDF extends FPDF
{
//Load data
function Header()
{
    global $commonUses;
    
    $username = $_SESSION['staffcode'];
    $curdate = date('d-M-Y');
    $this->SetFillColor(255,255,255);
    $this->SetTextColor(0);
    $this->SetDrawColor(212,239,249);
    $this->SetFont('Arial','I',7);
    $this->SetTextColor(0);
    $this->Cell(150,1,$commonUses->getFirstLastName($username),0,0,'L',true); $this->Cell(10,1,'Report generated at '.$curdate,0,0,'L',true);
    $this->Ln(10);
}
function FancyTable($header)
{
    //Colors, line width and bold font
    $this->SetFillColor(4,126,167);
    $this->SetTextColor(255,255,255);
    $this->SetDrawColor(212,239,249);
    $this->SetLineWidth(.2);
    $this->SetFont('arial','B');
    //Header
    $w=array(15,10,17,17,12,15,15,16,18,19,16,15,15);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
    $this->Ln();
}
}

$pdf=new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',12);
$pdf->SetTextColor(4,126,167);
$pdf->Cell(10,10,'Worksheet Report');
$pdf->Ln();

//Column titles
$header=array('Client','Category','Team In Charge','Staff In Charge','Priority','M Activity','S Activity','L Reports Sent','Job in Hand','Team In Notes','Ex Due Date','Be Due Date','Status');
$pdf->SetFont('Arial','B',6);
$pdf->FancyTable($header);

$pdf->SetFont('Arial','',5);
$pdf->SetFillColor(255,255,255);
$pdf->SetTextColor(0);
$pdf->SetLineWidth(.2);
$sql=$_SESSION['query'];
$result = mysql_query($sql);
while($row = @mysql_fetch_array($result)){
$pdf->Cell(15,10,htmlspecialchars($row["lp_wrk_CompanyName"]),1,0,'T',true);
$pdf->Cell(10,10,htmlspecialchars($row["cli_Category"]),1,0,'T',true);
$pdf->Cell(17,10,$commonUses->getFirstLastName($row["wrk_TeamInCharge"]),1,0,'T',true);
$pdf->Cell(17,10,$commonUses->getFirstLastName($row["wrk_StaffInCharge"]),1,0,'T',true);
$pdf->Cell(12,10,htmlspecialchars($row["lp_wrk_priority"]),1,0,'T',true);
$pdf->Cell(15,10,htmlspecialchars($row["lp_wrk_MasCode"]).($row["lp_wrk_MasCode"]!=""? "-":"").htmlspecialchars($row["lp_wrk_MasterActivity"]),1,0,'T',true);
$pdf->Cell(15,10,htmlspecialchars($row["lp_wrk_SubCode"]).($row["lp_wrk_SubCode"]!=""? "-":"").htmlspecialchars($row["lp_wrk_SubActivity"]),1,0,'T',true);
$pdf->Cell(16,10,htmlspecialchars($row["wrk_Details"]),1,0,'T',true);
$pdf->Cell(18,10,htmlspecialchars($row["wrk_Notes"]),1,0,'T',true);
$pdf->Cell(19,10,htmlspecialchars($row["wrk_TeamInChargeNotes"]),1,0,'T',true);
$pdf->Cell(16,10,$commonUses->showGridDateFormat($row["wrk_DueDate"]),1,0,'T',true);
$pdf->Cell(15,10,$commonUses->showGridDateFormat($row["wrk_InternalDueDate"]),1,0,'T',true);

$pdf->Cell(15,10,htmlspecialchars($row["lp_wrk_Status"]),1,0,'T',true);
$pdf->Ln();
}
$pdf->Output('worksheet_report.pdf');
header('Content-type: application/pdf');
// It will be called downloaded.pdf
header('Content-Disposition: attachment; filename="worksheet_report.pdf"');
// The PDF source is in original.pdf
readfile('worksheet_report.pdf');
?>

