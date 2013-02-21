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
    $query = "SELECT * FROM tax_taxaccounting where tax_ClientCode =".$cli_code;
    $result=@mysql_query($query);
    $row_inv = mysql_fetch_assoc($result);
    $tax_Code=@mysql_result( $result,0,'tax_Code') ;
    
    $this->SetFillColor(255,255,255);
    $this->SetTextColor(0);
    $this->SetDrawColor(182,231,249);
    $this->SetLineWidth(.2);
$details_query = "SELECT * FROM tax_taxaccountingdetails where tax_TAXCode =".$tax_Code." order by tax_Code";
$details_result=@mysql_query($details_query);
    $c=0;
    while($task_data = mysql_fetch_array($details_result))
    {
        if($c==0) { $this->SetFillColor(244,252,255); $this->SetFont('arial','B',7); $this->SetTextColor(148,43,14); $this->Cell(150,4,'Tax & Accounting',1,0,'T',true); $this->Ln(); }
        $taskContent = $commonUses->getTaskDescription(htmlspecialchars($task_data["tax_TaskCode"]));
        $this->SetFillColor(255,255,255);
        $this->SetTextColor(0);
        $this->SetFont('arial','',6);
        $this->Cell(60,3,$taskContent,1,0,'T',true);
        $this->MultiCell(90,3,$task_data["tax_TaskValue"],'LRB');
       // $this->Ln();
        $c++;
    }
                        $query = "SELECT i1.tax_Code,i2.tax_Notes,i2.tax_IndiaNotes FROM tax_taxaccounting AS i1 LEFT OUTER JOIN tax_taxaccountingdetails AS i2 ON (i1.tax_Code = i2.tax_TAXCode) where tax_ClientCode =".$cli_code;
                        $result=@mysql_query($query);
                        $row_notes = mysql_fetch_array($result);

                        $this->Cell(60,3,'Notes',1,0,'T',true);
                        $this->MultiCell(90,3,$row_notes['tax_Notes'],'LRB');
                       // $this->Ln();
                        $this->Cell(60,3,'India Notes',1,0,'T',true);
                        $this->MultiCell(90,3,$row_notes['tax_IndiaNotes'],'LRB');
}

}

$pdf=new PDF();
                //Get FormCode
            $formcode=$commonUses->getFormCode("Tax & Accounting");
                //Call CheckAccess function by passing $_SESSION of staff code and form code
            $access_file_level_taxaccount=$commonUses->checkFileAccess($_SESSION['staffcode'],$formcode);
//permission
	if(($access_file_level_taxaccount['stf_Add']=="Y" || $access_file_level_taxaccount['stf_View']=="Y" || $access_file_level_taxaccount['stf_Edit']=="Y" || $access_file_level_taxaccount['stf_Delete']=="Y"))
	{

$pdf->AddPage();
$pdf->SetFont('Arial','B',12);
$pdf->SetTextColor(4,126,167);
$pdf->Cell(10,10,'TAX & ACCOUNTING');
$pdf->Ln();
//Column titles
$header=array('Task Description','');
$pdf->SetFont('Arial','B',7);
$pdf->FancyTable($header);
//$pdf->SetFont('Arial','',6);
$pdf->TableData();
        }
$pdf->Output('Tax&Accounting.pdf');

header('Content-type: application/pdf');
// It will be called downloaded.pdf
header('Content-Disposition: attachment; filename="Tax&Accounting.pdf"');
// The PDF source is in original.pdf
readfile('Tax&Accounting.pdf');

 
?>

