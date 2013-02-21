<?php   
ob_start();
include("filepdf/fpdf.php");
include 'dbclass/commonFunctions_class.php';
class PDF extends FPDF
{
//Load data
//Colored table
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
    $w=array(6,15,25,25,20,20,15,15,15,17,25);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
    $this->Ln();
}
}

$pdf=new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',12);
$pdf->SetTextColor(4,126,167);
$pdf->Cell(10,10,'Custom Sales Report');
$pdf->Ln();

//Column titles
//$header=array('SNo','Client Type','State','Phone','India Manager','Australia Manager','Company Name','Postal Address','City','Post Code','Country','Mobile','Fax','Email','Website','Received Day','Received Date','Industry','Turn Over','Service Required','Stage','Lead Status','Source','Method of Contact','Sales Person','Client Notes','Physical Field','MYOB Serial No','Discontinued Date','Discontinued Reason','Last Reports Sent');
$header=array('SNo','Client Type','Company Name','Australia Manager','India Manager','Sales Person','State','Stage','Status','Phone','Notes');
$pdf->SetFont('Arial','B',7);
$pdf->FancyTable($header);

$pdf->SetFont('Arial','',6);
$pdf->SetFillColor(255,255,255);
$pdf->SetTextColor(0);
$pdf->SetLineWidth(.2);
$sql=$_SESSION['query'];
$result = mysql_query($sql);
$c=1;
while($row = @mysql_fetch_array($result)){
$pdf->Cell(6,10,$c,1,0,'T',true);
$pdf->Cell(15,10,$row["cty_Description"],1,0,'T',true);
$pdf->Cell(25,10,$row["name"],1,0,'T',true);
$pdf->Cell(25,10,$commonUses->getFirstLastName($row["cli_AssignAustralia"]),1,0,'T',true);
$pdf->Cell(20,10,$commonUses->getFirstLastName($row["cli_Assignedto"]),1,0,'T',true);
$pdf->Cell(20,10,$commonUses->getFirstLastName($row["cli_Salesperson"]),1,0,'T',true);
$pdf->Cell(15,10,$row["State"],1,0,'T',true);
$pdf->Cell(15,10,$row["Stage"],1,0,'T',true);
$pdf->Cell(15,10,$row["cls_Description"],1,0,'T',true);
$pdf->Cell(17,10,$row["cli_Phone"],1,0,'T',true);
$pdf->Cell(25,10,$row["cli_Notes"],1,0,'T',true);
$pdf->Ln();
$c++;
}
$pdf->Output('custom_sales_report.pdf');
header('Content-type: application/pdf');
// It will be called downloaded.pdf
header('Content-Disposition: attachment; filename="custom_sales_report.pdf"');
// The PDF source is in original.pdf
readfile('custom_sales_report.pdf');
?>

