<?php   
ob_start();
include("filepdf/fpdf.php");
include("dbclass/commonFunctions_class.php");

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
    $w=array(15,20,28,20,20,15,20,15,10,15,20);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
    $this->Ln();
}
function WordWrap(&$text, $maxwidth)
{
    $text = trim($text);
    if ($text==='')
        return 0;
    $space = $this->GetStringWidth(' ');
    $lines = explode("\n", $text);
    $text = '';
    $count = 0;

    foreach ($lines as $line)
    {
        $words = preg_split('/ +/', $line);
        $width = 0;

        foreach ($words as $word)
        {
            $wordwidth = $this->GetStringWidth($word);
            if ($width + $wordwidth <= $maxwidth)
            {
                $width += $wordwidth + $space;
                $text .= $word.' ';
            }
            else
            {
                $width = $wordwidth + $space;
                $text = rtrim($text)."\n".$word.' ';
                $count++;
            }
        }
        $text = rtrim($text)."\n";
        $count++;
    }
    $text = rtrim($text);
    return $count;
}
}

$pdf=new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',12);
$pdf->SetTextColor(4,126,167);
$pdf->Cell(10,10,'Timesheet Report');
$pdf->Ln();

//Column titles
$header=array('Date','User Name','Client','Master Activity','Sub Activity','Arrival Time','Departure Time','Status','Units','Net Units','Details');
$pdf->SetFont('Arial','B',7);
$pdf->FancyTable($header);

$pdf->SetFont('Arial','',6);
$pdf->SetFillColor(255,255,255);
$pdf->SetTextColor(0);
$pdf->SetLineWidth(.2);
$sql=$_SESSION['query'];
$result = mysql_query($sql);
while($row = @mysql_fetch_array($result)){
$pdf->Cell(15,10,$commonUses->showGridDateFormat($row["tis_Date"]),1,0,'T',true);
$pdf->Cell(20,10,$commonUses->getFirstLastName($row["tis_StaffCode"]),1,0,'T',true);
$pdf->Cell(28,10,$row["lp_tis_CompanyName"],1,0,'T',true);
$pdf->Cell(20,10,htmlspecialchars($row["lp_tis_MasCode"]).($row["lp_tis_MasCode"]!=""? "-":"").htmlspecialchars($row["lp_tis_MasterActivity"]),1,0,'T',true);
$pdf->Cell(20,10,htmlspecialchars($row["lp_tis_SubCode"]).($row["lp_tis_SubCode"]!=""? "-":"").htmlspecialchars($row["lp_tis_SubActivity"]),1,0,'T',true);
$pdf->Cell(15,10,htmlspecialchars($row["tis_ArrivalTime"]),1,0,'T',true);
$pdf->Cell(20,10,htmlspecialchars($row["tis_DepartureTime"]),1,0,'T',true);
$pdf->Cell(15,10,$commonUses->getTimesheetStatus(htmlspecialchars($row["tis_Status"])),1,0,'T',true);
$pdf->Cell(10,10,htmlspecialchars($row["lp_tis_Units"]),1,0,'T',true);
if($_SESSION['usertype']=="Administrator")
{
    $pdf->Cell(15,10,htmlspecialchars($row["lp_tis_NetUnits"]),1,0,'T',true);
}
$pdf->Cell(20,10,htmlspecialchars($row["Details"]),1,0,'T',true);
$pdf->Ln();
}
$pdf->Output('timesheet_report.pdf');

header('Content-type: application/pdf');
// It will be called downloaded.pdf
header('Content-Disposition: attachment; filename="timesheet_report.pdf"');
// The PDF source is in original.pdf
readfile('timesheet_report.pdf');
 
 
?>

