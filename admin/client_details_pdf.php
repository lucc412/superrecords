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
}
$pdf=new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',12);
$pdf->SetTextColor(4,126,167);
$pdf->Cell(10,10,'Client Details');
$pdf->Ln();
$pdf->SetFont('Arial','',7);
$pdf->SetTextColor(0);
$cli_code=$_REQUEST['cli_code'];
$query2="SELECT cli_Type,cli_Assignedto,cli_AssignAustralia,cli_TeaminCharge,cli_SeniorInCharge,cli_TeamMember,cli_BillingPerson,name,cli_PostalAddress,cli_Build,cli_Address,cli_City,cli_State,cli_Postcode,cli_Country,cli_Phone,cli_Mobile,cli_Fax,email,cli_Website,cli_DateReceived,cli_DayReceived,cli_Category,cli_Industry,cli_Turnover,cli_ServiceRequired,cli_Status,cli_Stage,cli_Source,cli_MOC,cli_Salesperson,cli_Lastdate,cli_Notes,cli_FutureContactDate,date_contract_signed FROM jos_users WHERE cli_Code=".$cli_code;
$result2=mysql_query($query2);
$content = mysql_fetch_array($result2);
//get client type
                                                    $stae_query = "SELECT c1.`cli_Type`, s1.`cty_Description` FROM `jos_users` AS c1 LEFT OUTER JOIN `cty_clienttype` AS s1 ON (c1.`cli_Type` = s1.`cty_Code`) where `cli_Type`=".$content['cli_Type'];
                                                    $cli_state = mysql_query($stae_query);
                                                    $clitype = @mysql_fetch_array($cli_state);
//get service required
                                                    $ser_query = "SELECT cli_ClientCode,cli_ServiceRequiredCode FROM `cli_allservicerequired` where `cli_ClientCode`=".$_GET['cli_code'];
                                                    $cli_serclicode = mysql_query($ser_query);
                                                   while($service_required = mysql_fetch_array($cli_serclicode))
                                                   {
                                                        $svr_query = "SELECT c1.`cli_ServiceRequiredCode`, s1.`svr_Description` FROM `cli_allservicerequired` AS c1 LEFT OUTER JOIN `cli_servicerequired` AS s1 ON (c1.`cli_ServiceRequiredCode` = s1.`svr_Code`) where `cli_ServiceRequiredCode`=".$service_required['cli_ServiceRequiredCode'];
                                                        $cli_service = mysql_query($svr_query);
                                                        $service_name = @mysql_fetch_array($cli_service);
                                                        $servicename .= $service_name["svr_Description"].",";
                                                    }
                                                        $servicerequire = substr($servicename,0,-1);
//get state
                                                    $stae_query = "SELECT c1.`cli_State`, s1.`cst_Description` FROM `jos_users` AS c1 LEFT OUTER JOIN `cli_state` AS s1 ON (c1.`cli_State` = s1.`cst_Code`) where `cli_State`=".$content['cli_State'];
                                                    $cli_state = mysql_query($stae_query);
                                                    $state = @mysql_fetch_array($cli_state);
//get industry
                                                    $ind_query = "SELECT c1.`cli_Industry`, i1.`ind_Description` FROM `jos_users` AS c1 LEFT OUTER JOIN `cli_industry` AS i1 ON (c1.`cli_Industry` = i1.`ind_Code`) where `cli_Industry`=".$content['cli_Industry'];
                                                    $cli_industry = mysql_query($ind_query);
                                                    $industry = @mysql_fetch_array($cli_industry);
//get stage
                                                    $stae_query = "SELECT c1.`cli_Stage`, s1.`cst_Description` FROM `jos_users` AS c1 LEFT OUTER JOIN `cst_clientstatus` AS s1 ON (c1.`cli_Stage` = s1.`cst_Code`) where `cli_Stage`=".$content['cli_Stage'];
                                                    $cli_state = mysql_query($stae_query);
                                                    $stage = @mysql_fetch_array($cli_state);
//get status
                                                    $stae_query = "SELECT c1.`cli_Status`, s1.`cls_Description` FROM `jos_users` AS c1 LEFT OUTER JOIN `cls_clientleadstatus` AS s1 ON (c1.`cli_Status` = s1.`cls_Code`) where `cli_Status`=".$content['cli_Status'];
                                                    $cli_state = mysql_query($stae_query);
                                                    $status = @mysql_fetch_array($cli_state);
//get source
                                                    $stae_query = "SELECT c1.`cli_Source`, s1.`src_Description` FROM `jos_users` AS c1 LEFT OUTER JOIN `src_source` AS s1 ON (c1.`cli_Source` = s1.`src_Code`) where `cli_Source`=".$content['cli_Source'];
                                                    $cli_state = mysql_query($stae_query);
                                                    $source = @mysql_fetch_array($cli_state);
//get method of contact
                                                    $stae_query = "SELECT c1.`cli_MOC`, s1.`moc_Description` FROM `jos_users` AS c1 LEFT OUTER JOIN `moc_methodofcontact` AS s1 ON (c1.`cli_MOC` = s1.`moc_Code`) where `cli_MOC`=".$content['cli_MOC'];
                                                    $cli_state = mysql_query($stae_query);
                                                    $moc = @mysql_fetch_array($cli_state);

    $pdf->SetFillColor(255,255,255);
    $pdf->SetTextColor(0);
    $pdf->SetDrawColor(212,239,249);

$pdf->Cell(36,10,'Type',0,0,'L',true);
$pdf->Cell(36,10,$clitype['cty_Description'],0,0,'L',true);
$pdf->Ln();
$pdf->Cell(36,10,'Assign Billing Person',0,0,'L',true);
$pdf->Cell(36,10,$commonUses->getUsername($content['cli_BillingPerson'],0,0,'L',true));
$pdf->Ln();
$pdf->Cell(36,10,'Assign Australian Manager',0,0,'L',true);
$pdf->Cell(36,10,$commonUses->getUsername($content['cli_AssignAustralia'],0,0,'L',true));
$pdf->Ln();
$pdf->Cell(36,10,'Assigned to India Manager',0,0,'L',true);
$pdf->Cell(36,10,$commonUses->getUsername($content['cli_Assignedto'],0,0,'L',true));
$pdf->Ln();
$pdf->Cell(36,10,'Assign Team In Charge',0,0,'L',true);
$pdf->Cell(36,10,$commonUses->getUsername($content['cli_TeaminCharge'],0,0,'L',true));
$pdf->Ln();
$pdf->Cell(36,10,'Assign Team Member',0,0,'L',true);
$pdf->Cell(36,10,$commonUses->getUsername($content['cli_TeamMember'],0,0,'L',true));
$pdf->Ln();
$pdf->Cell(36,10,'Senior In Charge',0,0,'L',true);
$pdf->Cell(36,10,$commonUses->getUsername($content['cli_SeniorInCharge'],0,0,'L',true));
$pdf->Ln();
$pdf->Cell(36,10,'Company Name',0,0,'L',true);
$pdf->Cell(36,10,$content['name'],0,0,'L',true);
$pdf->Ln();
$pdf->Cell(36,10,'Category',0,0,'L',true);
$pdf->Cell(36,10,$content['cli_Category'],0,0,'L',true);
$pdf->Ln();
$pdf->Cell(36,10,'Unit/Build Number',0,0,'L',true);
$pdf->Cell(36,10,$content['cli_Build'],0,0,'L',true);
$pdf->Ln();
$pdf->Cell(36,10,'Street Name',0,0,'L',true);
$pdf->Cell(36,10,$content['cli_Address'],0,0,'L',true);
$pdf->Ln();
$pdf->Cell(36,10,'Suburb',0,0,'L',true);
$pdf->Cell(36,10,$content['cli_City'],0,0,'L',true);
$pdf->Ln();
$pdf->Cell(36,10,'State',0,0,'L',true);
$pdf->Cell(36,10,$state['cst_Description'],0,0,'L',true);
$pdf->Ln();
$pdf->Cell(36,10,'Post Code',0,0,'L',true);
$pdf->Cell(36,10,$content['cli_Postcode'],0,0,'L',true);
$pdf->Ln();
$pdf->Cell(36,10,'Country',0,0,'L',true);
$pdf->Cell(36,10,$content['cli_Country'],0,0,'L',true);
$pdf->Ln();
$pdf->Cell(36,10,'Postal Address',0,0,'L',true);
$pdf->Cell(36,10,$content['cli_PostalAddress'],0,0,'L',true);
$pdf->Ln();
$pdf->Cell(36,10,'Phone',0,0,'L',true);
$pdf->Cell(36,10,$content['cli_Phone'],0,0,'L',true);
$pdf->Ln();
$pdf->Cell(36,10,'Mobile',0,0,'L',true);
$pdf->Cell(36,10,$content['cli_Mobile'],0,0,'L',true);
$pdf->Ln();
$pdf->Cell(36,10,'Fax',0,0,'L',true);
$pdf->Cell(36,10,$content['cli_Fax'],0,0,'L',true);
$pdf->Ln();
$pdf->Cell(36,10,'Email',0,0,'L',true);
$pdf->Cell(36,10,$content['email'],0,0,'L',true);
$pdf->Ln();
$pdf->Cell(36,10,'Website',0,0,'L',true);
$pdf->Cell(36,10,$content['cli_Website'],0,0,'L',true);
$pdf->Ln();
$pdf->Cell(36,10,'Date Received',0,0,'L',true);
$pdf->Cell(36,10,$commonUses->showGridDateFormat($content['cli_DateReceived'],0,0,'L',true));
$pdf->Ln();
$pdf->Cell(36,10,'Day Received',0,0,'L',true);
$pdf->Cell(36,10,$content['cli_DayReceived'],0,0,'L',true);
$pdf->Ln();
$pdf->Cell(36,10,'Industry',0,0,'L',true);
$pdf->Cell(36,10,$industry['ind_Description'],0,0,'L',true);
$pdf->Ln();
$pdf->Cell(36,10,'Turnover',0,0,'L',true);
$pdf->Cell(36,10,$content['cli_Turnover'],0,0,'L',true);
$pdf->Ln();
$pdf->Cell(36,10,'Service Required',0,0,'L',true);
$pdf->Cell(36,10,$servicerequire,0,0,'L',true);
$pdf->Ln();
$pdf->Cell(36,10,'Stage',0,0,'L',true);
$pdf->Cell(36,10,$stage['cst_Description'],0,0,'L',true);
$pdf->Ln();
$pdf->Cell(36,10,'Lead Status',0,0,'L',true);
$pdf->Cell(36,10,$status['cls_Description'],0,0,'L',true);
$pdf->Ln();
$pdf->Cell(36,10,'Source',0,0,'L',true);
$pdf->Cell(36,10,$source['src_Description'],0,0,'L',true);
$pdf->Ln();
$pdf->Cell(36,10,'Method of Contact',0,0,'L',true);
$pdf->Cell(36,10,$moc['moc_Description'],0,0,'L',true);
$pdf->Ln();
$pdf->Cell(36,10,'Sales Person',0,0,'L',true);
$pdf->Cell(36,10,$commonUses->getUsername($content['cli_Salesperson'],0,0,'L',true));
$pdf->Ln();
$pdf->Cell(36,10,'Contract Signed date',0,0,'L',true);
$pdf->Cell(36,10,$commonUses->showGridDateFormat($content['date_contract_signed'],0,0,'L',true));
$pdf->Ln();
$pdf->Cell(36,10,'Last Date of Contact',0,0,'L',true);
$pdf->Cell(36,10,$commonUses->showGridDateFormat($content['cli_Lastdate'],0,0,'L',true));
$pdf->Ln();
$pdf->Cell(36,10,'Future Contact date',0,0,'L',true);
$pdf->Cell(36,10,$commonUses->showGridDateFormat($content['cli_FutureContactDate'],0,0,'L',true));
$pdf->Ln();
$pdf->Cell(36,10,'Notes',0,0,'L',true);
$pdf->Cell(36,10,$content['cli_Notes'],0,0,'L',true);
$pdf->Ln();

$pdf->Output('ClientDetails.pdf');

header('Content-type: application/pdf');
// It will be called downloaded.pdf
header('Content-Disposition: attachment; filename="ClientDetails.pdf"');
// The PDF source is in original.pdf
readfile('ClientDetails.pdf');

 
?>

