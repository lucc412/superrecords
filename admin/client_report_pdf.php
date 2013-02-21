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
    $w=array(50,40,20,35,30,20);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
    $this->Ln();
}
	function LineItems($cmpname,$state,$clitype,$clistage,$salesflname,$leadstatus)
        {
		$data[] = array($cmpname, $state, $clitype, $clistage, $salesflname, $leadstatus);
		$w = array(50, 40, 20, 35, 30, 20);
		// Mark start coords
		$x = $this->GetX();
		$y = $this->GetY();
		$i = 0;

		foreach($data as $row)
		{
			$y1 = $this->GetY();
			$this->MultiCell($w[0], 6, $row[0], 'LRB');
			$y2 = $this->GetY();
			$yH = $y2 - $y1;

			$this->SetXY($x + $w[0], $this->GetY() - $yH);

			$this->Cell($w[1], $yH, $row[1], 'LRB', 0, 'L');
                        $this->Cell($w[2], $yH, $row[2], 'LRB', 0, 'L');
                        $this->Cell($w[3], $yH, $row[3], 'LRB', 0, 'L');
                        $this->Cell($w[4], $yH, $row[4], 'LRB', 0, 'L');
                        $this->Cell($w[5], $yH, $row[5], 'LRB', 0, 'L');
                        $this->Ln();
                }
        }
}

$pdf=new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',12);
$pdf->SetTextColor(4,126,167);
$pdf->Cell(10,10,'Sales Report');
$pdf->Ln();

//Column titles
$header=array('Company Name','State','Client Type','Stage','Sales Person','Status');
$pdf->SetFont('Arial','B',7);
$pdf->FancyTable($header);

$pdf->SetFont('Arial','',6);
$pdf->SetFillColor(255,255,255);
$pdf->SetTextColor(0);
$pdf->SetLineWidth(.2);
$sql=$_SESSION['query'];
$result = mysql_query($sql);
while($row = @mysql_fetch_array($result)){
/*
$pdf->Cell(50,10,$row["name"],1,0,'T',true);
$pdf->Cell(40,10,htmlspecialchars($row['lp_cli_State']),1,0,'T',true);
$pdf->Cell(20,10,htmlspecialchars($row["lp_cli_Type"]),1,0,'T',true);
$pdf->Cell(35,10,htmlspecialchars($row["lp_cli_Stage"]),1,0,'T',true);
$pdf->Cell(30,10,$row['lp_cli_Salesperson_fname']." ".$row['lp_cli_Salesperson_lname'],1,0,'T',true);
$pdf->Cell(20,10,htmlspecialchars($row["cli_Lead_Status"]),1,0,'T',true);
$pdf->Ln();
*/
    $cmpname = $row["name"];
    $state = htmlspecialchars($row['lp_cli_State']);
    $clitype = htmlspecialchars($row["lp_cli_Type"]);
    $clistage = htmlspecialchars($row["lp_cli_Stage"]);
    $salesflname = $row['lp_cli_Salesperson_fname']." ".$row['lp_cli_Salesperson_lname'];
    $leadstatus = htmlspecialchars($row["cli_Lead_Status"]);
    $pdf->LineItems($cmpname, $state, $clitype, $clistage, $salesflname, $leadstatus);
}
$pdf->Output('sales_report.pdf');
header('Content-type: application/pdf');
// It will be called downloaded.pdf
header('Content-Disposition: attachment; filename="sales_report.pdf"');
// The PDF source is in original.pdf
readfile('sales_report.pdf');
?>

