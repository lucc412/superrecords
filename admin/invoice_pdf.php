<?php   
ob_start();
include("filepdf/fpdf.php");
include("dbclass/commonFunctions_class.php");
class PDF extends FPDF
{
//Load data
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
    $w=array(60,50,40,45);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],10,$header[$i],1,0,'C',true);
    $this->Ln();
}
function TableData()
{
    global $commonUses;
    $cli_code=$_REQUEST['cli_code'];
    $query = "SELECT * FROM inv_qinvoice where inv_ClientCode =".$cli_code;
    $result=@mysql_query($query);
    $row_inv = mysql_fetch_assoc($result);
    $inv_Code=@mysql_result( $result,0,'inv_Code') ;
    
    $this->SetFillColor(255,255,255);
    $this->SetTextColor(0);
    $this->SetDrawColor(182,231,249);
    $this->SetLineWidth(.2);
    $standardRate = array('$250','$730','$835','$325','$50','$100','$300','$100','$300','$0','$0','$0');
    $period = array('one off','one off','one off','one off','per hour','per hour','per year','per month','per year','per year','per year','');
    $details_query = "SELECT * FROM inv_qinvoicedetails where inv_QICode =".$inv_Code." order by inv_Code";
    $details_result=mysql_query($details_query);
    $c=0;
    while($task_data = mysql_fetch_array($details_result))
    {
        if($c==0) { $this->SetFillColor(244,252,255); $this->SetFont('arial','B',7); $this->SetTextColor(148,43,14); $this->Cell(195,4,'Set Up',1,0,'T',true); $this->Ln(); }
        if($c==4) { $this->SetFillColor(244,252,255); $this->SetFont('arial','B',7); $this->SetTextColor(148,43,14); $this->Cell(195,3,'Hourly Rates (tax & accounting)',1,0,'T',true); $this->Ln(); }
        if($c==6) { $this->SetFillColor(244,252,255); $this->SetFont('arial','B',7); $this->SetTextColor(148,43,14); $this->Cell(195,3,'Auditing',1,0,'T',true); $this->Ln(); }
        if($c==7) { $this->SetFillColor(244,252,255); $this->SetFont('arial','B',7); $this->SetTextColor(148,43,14); $this->Cell(195,3,'Fixed Monthly Retainer Fee',1,0,'T',true); $this->Ln(); }
        if($c==9) { $this->SetFillColor(244,252,255); $this->SetFont('arial','B',7); $this->SetTextColor(148,43,14); $this->Cell(195,3,'BACKLOG',1,0,'T',true); $this->Ln(); }
        if($task_data['inv_Rates']=="") { $invRates = $task_data['inv_Rates']; } else { $invRates = '$'.$task_data['inv_Rates']; }
        $taskContent = $commonUses->getTaskDescription(htmlspecialchars($task_data["inv_TaskCode"]));
        $this->SetFillColor(255,255,255);
        $this->SetTextColor(0);
        $this->SetFont('arial','',6);
        $this->Cell(60,3,$taskContent,1,0,'T',true);
        $this->Cell(50,3,$standardRate[$c],1,0,'T',true);
        $this->Cell(40,3,$invRates,1,0,'T',true);
        $this->Cell(45,3,$period[$c],1,0,'T',true);
        $this->Ln();
        $c++;
    }
$query = "SELECT i1.inv_Code,i2.inv_Notes FROM inv_qinvoice AS i1 LEFT OUTER JOIN inv_qinvoicedetails AS i2 ON (i1.inv_Code = i2.inv_QICode) where inv_ClientCode =".$cli_code;
$result=@mysql_query($query);
$row_notes = mysql_fetch_array($result);

    $this->Cell(60,3,'Notes',1,0,'T',true); $this->Cell(135,3,$row_notes['inv_Notes'],1,0,'T',true);
}

}

$pdf=new PDF();
            $formcode = $commonUses->getFormCode("Card File Info");
            //Call CheckAccess function by passing $_SESSION of staff code and form code
            $access_file_level_crd = $commonUses->checkFileAccess($_SESSION['staffcode'],$formcode);
                //Get FormCode
            $formcode = $commonUses->getFormCode("Invoice");
                //Call CheckAccess function by passing $_SESSION of staff code and form code
            $access_file_level_inv = $commonUses->checkFileAccess($_SESSION['staffcode'],$formcode);
	if(($access_file_level_crd['stf_Add']=="Y" || $access_file_level_crd['stf_View']=="Y" || $access_file_level_crd['stf_Edit']=="Y" || $access_file_level_crd['stf_Delete']=="Y"))
	{

$pdf->AddPage();
$pdf->SetFont('Arial','B',12);
$pdf->SetTextColor(4,126,167);
$pdf->Cell(10,10,'Card File Information');
$pdf->Ln();
$pdf->SetFont('Arial','',7);
$pdf->SetTextColor(0);
$cli_code=$_REQUEST['cli_code'];
  $showquery = "SELECT * FROM (SELECT t1.`crd_Code`, t1.`crd_ClientCode`, t1.`crd_LegalName`, t1.`crd_BillingName`, t1.`crd_TradingName`, t1.`crd_EntityType`, lp5.`ety_Description` AS `lp_crd_EntityType`, t1.`crd_ABN`, t1.`crd_HasRelatedEntities`, t1.`crd_PrimaryContact`, lp8.`con_Firstname` AS `lp_crd_PrimaryContact`, t1.`crd_Createdby`, t1.`crd_Createdon`, t1.`crd_Lastmodifiedby`, t1.`crd_Lastmodifiedon` FROM `crd_qcardfile` AS t1 LEFT OUTER JOIN `ety_entitytype` AS lp5 ON (t1.`crd_EntityType` = lp5.`ety_Code`) LEFT OUTER JOIN `con_contact` AS lp8 ON (t1.`crd_PrimaryContact` = lp8.`con_Code`)) subq where crd_ClientCode=".$cli_code;
$showresult=mysql_query($showquery);
$card_data = @mysql_fetch_array($showresult);
    $pdf->SetFillColor(255,255,255);
    $pdf->SetTextColor(0);
    $pdf->SetDrawColor(212,239,249);

$pdf->Cell(30,10,'Legal Name',0,0,'L',true);
$pdf->Cell(30,10,$card_data['crd_LegalName'],0,0,'L',true);
$pdf->Ln();
$pdf->Cell(30,10,'Billing Name',0,0,'L',true);
$pdf->Cell(30,10,$card_data['crd_BillingName'],0,0,'L',true);
$pdf->Ln();
$pdf->Cell(30,10,'Trading Name',0,0,'L',true);
$pdf->Cell(30,10,$card_data['crd_TradingName'],0,0,'L',true);
$pdf->Ln();
//get entity name
$ent_query = "select `ety_Code`, `ety_Description` from `ety_entitytype` where ety_Code=".$card_data['crd_EntityType'];
$store_query = mysql_query($ent_query);
$entityVal = @mysql_fetch_array($store_query);
$pdf->Cell(30,10,'Entity Type',0,0,'L',true);
$pdf->Cell(30,10,$entityVal['ety_Description'],0,0,'L',true);
$pdf->Ln();
$pdf->Cell(30,10,'ABN',0,0,'L',true);
$pdf->Cell(30,10,$card_data['crd_ABN'],0,0,'L',true);
$pdf->Ln();
$pdf->Cell(30,10,'Related Entities',0,0,'L',true);
if($card_data['crd_HasRelatedEntities']=="Y") { $crd_has="Yes"; }
$pdf->Cell(30,10,$crd_has,0,0,'L',true);
$pdf->Ln();
//get client name
$query2="SELECT c1.`name` from crd_qcardfile as q1 left outer join cde_qcardfiledetails as q2 on (q1.crd_Code=q2.cde_CardFileCode) left outer join jos_users as c1 on (q2.cde_ClientCode=c1.cli_Code) where crd_ClientCode=".$cli_code;
$result2=mysql_query($query2);
$pdf->Cell(30,10,'Client List',0,0,'L',true);
$pdf->Ln(10);
while($cliName = mysql_fetch_array($result2)) {
$pdf->Cell(30,10,'',0,0,'L',true);
$pdf->Cell(30,10,$cliName['name'],0,0,'L',true);
$pdf->Ln();
}
//get primary contact
  $sql = "select t1.`con_Code`, t1.`con_Firstname`, t1.`con_Lastname` from `con_contact` as t1 LEFT JOIN cnt_contacttype AS t2 on t1.con_Type=t2.cnt_Code where t2.cnt_Description like 'Client' and t1.con_Company=".$cli_code;
  $res = mysql_query($sql);
  $pcontact = @mysql_fetch_array($res);
  $conName = $pcontact['con_Firstname']." ".$pcontact['con_Lastname'];
$pdf->Cell(30,10,'Primary Contact',0,0,'L',true);
$pdf->Cell(30,10,$conName,0,0,'L',true);
$pdf->Ln();
        }
//Invoice
	if(($access_file_level_inv['stf_Add']=="Y" || $access_file_level_inv['stf_View']=="Y" || $access_file_level_inv['stf_Edit']=="Y" || $access_file_level_inv['stf_Delete']=="Y"))
	{

$pdf->AddPage();
$pdf->SetFont('Arial','B',12);
$pdf->SetTextColor(4,126,167);
$pdf->Cell(10,10,'INVOICE');
$pdf->Ln();
//Column titles
$header=array('Tasks Agreed','Standard Rates(ex.GST)','Agreed Rates(ex.GST)','Period');
$pdf->SetFont('Arial','B',7);
$pdf->FancyTable($header);
//$pdf->SetFont('Arial','',6);
$pdf->TableData();
        }
$pdf->Output('Quotesheet.pdf');

header('Content-type: application/pdf');
// It will be called downloaded.pdf
header('Content-Disposition: attachment; filename="Quotesheet.pdf"');
// The PDF source is in original.pdf
readfile('Quotesheet.pdf');

 
?>

