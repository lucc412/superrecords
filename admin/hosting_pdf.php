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
//get client name
$cli_code=$_REQUEST['cli_code'];
$cli_query = "SELECT name FROM jos_users WHERE cli_Code=".$cli_code;
$st_query = mysql_query($cli_query);
$clientName = mysql_fetch_array($st_query);
$company = $clientName['name'];
$curdate = date('d-M-Y');
    $this->SetFillColor(255,255,255);
    $this->SetTextColor(0);
    $this->SetDrawColor(212,239,249);
$this->SetFont('Arial','I',7);
$this->SetTextColor(0);
$this->Cell(150,1,$company,0,0,'L',true); $this->Cell(10,1,'Report generated at '.$curdate,0,0,'L',true);
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
    $w=array(60,90);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],10,$header[$i],1,0,'C',true);
    $this->Ln();
}
function TableData()
{
   global $commonUses;
    
        $cli_code=$_REQUEST['cli_code'];
        $query = "SELECT * FROM mhg_qmyobhosting where mhg_ClientCode =".$cli_code;
        $result=@mysql_query($query);
        $row_mhg = mysql_fetch_assoc($result);
        $mhg_Code=@mysql_result( $result,0,'mhg_Code') ;
    
        $this->SetFillColor(255,255,255);
        $this->SetTextColor(0);
        $this->SetDrawColor(182,231,249);
        $this->SetLineWidth(.2);
        $details_query = "SELECT * FROM mhg_qmyobhostingdetails where mhg_MYOBHCode =".$mhg_Code." order by mhg_Code";
        $details_result=@mysql_query($details_query);
        $c=0;
        while($task_data = mysql_fetch_array($details_result))
        {
            if($c==0) { $this->SetFillColor(244,252,255); $this->SetFont('arial','B',7); $this->SetTextColor(148,43,14); $this->Cell(150,4,'MYOB Hosting Services',1,0,'T',true); $this->Ln(); }
            if($c==6) { $this->SetFillColor(244,252,255); $this->SetFont('arial','B',7); $this->SetTextColor(148,43,14); $this->Cell(150,4,'Befree ADMIN to complete',1,0,'T',true); $this->Ln(); }
            if($task_data['mhg_TaskValue']=="Y") { $TaskVal = "Yes"; } else { $TaskVal = $task_data['mhg_TaskValue']; }
            $taskContent = $commonUses->getTaskDescription(htmlspecialchars($task_data["mhg_TaskCode"]));
            if($taskContent=="<b>Email details</b>") { $taskContent = "Email details"; }
            if($taskContent=="<b>Printer details</b>") { $taskContent = "Printer details"; }
            if($taskContent=="<b>Data File Details</b>") { $taskContent = "Data File details"; }
            $this->SetFillColor(255,255,255);
            $this->SetTextColor(0);
            $this->SetFont('arial','',6);
            $this->Cell(60,3,$taskContent,1,0,'T',true);
            $this->MultiCell(90,3,$TaskVal,'LRB');
           // $this->Ln();
            $c++;
        }
            $query = "SELECT i1.mhg_Code,i2.mhg_Notes,i2.mhg_IndiaNotes FROM mhg_qmyobhosting AS i1 LEFT OUTER JOIN mhg_qmyobhostingdetails AS i2 ON (i1.mhg_Code = i2.mhg_MYOBHCode) where mhg_ClientCode =".$cli_code;
            $result=@mysql_query($query);
            $row_notes = mysql_fetch_array($result);

            $this->Cell(60,3,'Notes',1,0,'T',true);
            $this->MultiCell(90,3,$row_notes['mhg_Notes'],'LRB');
           // $this->Ln();
            $this->Cell(60,3,'India Notes',1,0,'T',true);
            $this->MultiCell(90,3,$row_notes['mhg_IndiaNotes'],'LRB');
}

}

$pdf=new PDF();
                //Get FormCode
            $formcode=$commonUses->getFormCode("Hosting");
                //Call CheckAccess function by passing $_SESSION of staff code and form code
            $access_file_level_host=$commonUses->checkFileAccess($_SESSION['staffcode'],$formcode);
                //permission
	if(($access_file_level_host['stf_Add']=="Y" || $access_file_level_host['stf_View']=="Y" || $access_file_level_host['stf_Edit']=="Y" || $access_file_level_host['stf_Delete']=="Y"))
	{
            $pdf->AddPage();
            $pdf->SetFont('Arial','B',12);
            $pdf->SetTextColor(4,126,167);
            $pdf->Cell(10,10,'Hosting');
            $pdf->Ln();
            //Column titles
            $header=array('Task List','');
            $pdf->SetFont('Arial','B',7);
            $pdf->FancyTable($header);
            //$pdf->SetFont('Arial','',6);
            $pdf->TableData();
        }
$pdf->Output('Hosting.pdf');

header('Content-type: application/pdf');
// It will be called downloaded.pdf
header('Content-Disposition: attachment; filename="Hosting.pdf"');
// The PDF source is in original.pdf
readfile('Hosting.pdf');

 
?>

