<?php

include("dbclass/commonFunctions_class.php");
require_once 'Classes/PHPExcel.php';

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set properties
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
							 ->setLastModifiedBy("Maarten Balliauw")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Test result file");
             $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(10);
             $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(10);
             $objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
             $objPHPExcel->getActiveSheet()->getPageSetup()->setVerticalCentered(true);
             //font color
                $objPHPExcel->getActiveSheet()->getStyle('C5:D5')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
                //font alignment
                $objPHPExcel->getActiveSheet()->getStyle('C5:D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                //Borders
                $objPHPExcel->getActiveSheet()->getStyle('C5:D5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                $objPHPExcel->getActiveSheet()->getStyle('C5:D5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                $objPHPExcel->getActiveSheet()->getStyle('C5:D5')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                $objPHPExcel->getActiveSheet()->getStyle('C5:D5')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                //background color
                $objPHPExcel->getActiveSheet()->getStyle('C5:D5')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                $objPHPExcel->getActiveSheet()->getStyle('C5:D5')->getFill()->getStartColor()->setARGB('0a58720a5872');
                //font
                $objPHPExcel->getDefaultStyle()->getFont()->setName('Arial');
                $objPHPExcel->getDefaultStyle()->getFont()->setSize(10);
                $objPHPExcel ->getActiveSheet()->getStyle('C5')->getFont()->setBold(true);
                $objPHPExcel ->getActiveSheet()->getStyle('C5')->getFont()->setSize(12);
                //cell width
               // $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(12);
               $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
               $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(50);
               //outline
              // $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setOutlineLevel(5);
              //rows hight
              $objPHPExcel->getActiveSheet()->getRowDimension('5')->setRowHeight(20);
              
            $formcode = $commonUses->getFormCode("Card File Info");
            //Call CheckAccess function by passing $_SESSION of staff code and form code
            $access_file_level_crd = $commonUses->checkFileAccess($_SESSION['staffcode'],$formcode);
                //Get FormCode
            $formcode = $commonUses->getFormCode("Invoice");
                //Call CheckAccess function by passing $_SESSION of staff code and form code
            $access_file_level_inv = $commonUses->checkFileAccess($_SESSION['staffcode'],$formcode);

//card file info
//header
$cli_code=$_REQUEST['cli_code'];
$cli_query = "SELECT name FROM jos_users WHERE cli_Code=".$cli_code;
$st_query = mysql_query($cli_query);
$clientName = mysql_fetch_array($st_query);
$company = $clientName['name'];
	if(($access_file_level_crd['stf_Add']=="Y" || $access_file_level_crd['stf_View']=="Y" || $access_file_level_crd['stf_Edit']=="Y" || $access_file_level_crd['stf_Delete']=="Y"))
	{
$showquery = "SELECT * FROM (SELECT t1.`crd_Code`, t1.`crd_ClientCode`, t1.`crd_LegalName`, t1.`crd_BillingName`, t1.`crd_TradingName`, t1.`crd_EntityType`, lp5.`ety_Description` AS `lp_crd_EntityType`, t1.`crd_ABN`, t1.`crd_HasRelatedEntities`, t1.`crd_PrimaryContact`, lp8.`con_Firstname` AS `lp_crd_PrimaryContact`, t1.`crd_Createdby`, t1.`crd_Createdon`, t1.`crd_Lastmodifiedby`, t1.`crd_Lastmodifiedon` FROM `crd_qcardfile` AS t1 LEFT OUTER JOIN `ety_entitytype` AS lp5 ON (t1.`crd_EntityType` = lp5.`ety_Code`) LEFT OUTER JOIN `con_contact` AS lp8 ON (t1.`crd_PrimaryContact` = lp8.`con_Code`)) subq where crd_ClientCode=".$cli_code;
$showresult=mysql_query($showquery);
$card_data = @mysql_fetch_array($showresult);
$primary_contact = $row_qcard["con_Firstname"]." "." ".$row_qcard["con_Lastname"];
if($card_data['crd_HasRelatedEntities']=="Y") $relatedentity="Yes"; else $relatedentity="No";
if($card_data['crd_HasRelatedEntities']=="") $relatedentity="";
//get client name
$query2="SELECT c1.`name` from crd_qcardfile as q1 left outer join cde_qcardfiledetails as q2 on (q1.crd_Code=q2.cde_CardFileCode) left outer join jos_users as c1 on (q2.cde_ClientCode=c1.cli_Code) where crd_ClientCode=".$cli_code;
$result2=mysql_query($query2);
$company_names = "";
while(list($cliName) = mysql_fetch_array($result2))
{
    $company_names .= $cliName." , ";
}
// get primary contact
  $sql = "select t1.`con_Code`, t1.`con_Firstname`, t1.`con_Lastname` from `con_contact` as t1 LEFT JOIN cnt_contacttype AS t2 on t1.con_Type=t2.cnt_Code where t2.cnt_Description like 'Client' and t1.con_Company=".$cli_code;
  $res = mysql_query($sql);
  $pcontact = @mysql_fetch_array($res);
  $conName = $pcontact['con_Firstname']." ".$pcontact['con_Lastname'];

$objPHPExcel->getActiveSheet()->setTitle('Card File Info');
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1',$company)
            ->setCellValue('G1',"Report Generated at".date('d-M-y'))
            ->setCellValue('C5','Description')
            ->setCellValue('D5','')
            ->setCellValue('C6', "Legal Name")
            ->setCellValue('D6', $card_data['crd_LegalName'])
            ->setCellValue('C7', "Billing Name")
            ->setCellValue('D7', $card_data['crd_BillingName'])
            ->setCellValue('C8', "Trading Name",$header1)
            ->setCellValue('D8', $card_data['crd_TradingName'])
            ->setCellValue('C9', "Entity Type",$header1)
            ->setCellValue('D9', $card_data['lp_crd_EntityType'])
            ->setCellValue('C10', "ABN")
            ->setCellValue('D10', $card_data['crd_ABN'])
            ->setCellValue('C11', "Related Entities")
            ->setCellValue('D11', $relatedentity)
            ->setCellValue('C12', "Client List")
            ->setCellValue('D12', substr($company_names,0,-3))
            ->setCellValue('C13', "Primary Contact")
            ->setCellValue('D13', $conName);
        }
//Invoice details
	if(($access_file_level_inv['stf_Add']=="Y" || $access_file_level_inv['stf_View']=="Y" || $access_file_level_inv['stf_Edit']=="Y" || $access_file_level_inv['stf_Delete']=="Y"))
	{
             $invoice  = $objPHPExcel->createSheet();
             $invoice ->setTitle('Invoice');
             $invoice ->getColumnDimension('C')->setAutoSize(true);
             $invoice ->getColumnDimension('D')->setAutoSize(true);
             $invoice ->getColumnDimension('E')->setAutoSize(true);
             $invoice ->getColumnDimension('F')->setAutoSize(true);
             $invoice ->getRowDimension('5')->setRowHeight(20);
             $invoice ->getDefaultStyle()->getFont()->setName('Arial');
             $invoice ->getDefaultStyle()->getFont()->setSize(10);
             $invoice ->getStyle('C5:F5')->getFont()->setBold(true);
             $invoice ->getStyle('C5:F5')->getFont()->setSize(11);
             $invoice ->getStyle('C5:F5')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
             $invoice ->getStyle('C5:F5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
             $invoice ->getStyle('C5:F5')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
             $invoice ->getStyle('C5:F5')->getFill()->getStartColor()->setARGB('0a58720a5872');
             $invoice ->getStyle('C5:F5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
             $invoice ->getStyle('C5:F5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
             $invoice ->getStyle('C5:F5')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
             $invoice ->getStyle('C5:F5')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

                      $invoice ->setCellValue('A1',$company)
                        ->setCellValue('G1',"Report Generated at".date('d-M-y'))
                        ->setCellValue('C5','Tasks Agreed')
                        ->setCellValue('D5','Standard Rates (ex.GST)')
                        ->setCellValue('E5','Agreed Rates (ex.GST)')
                        ->setCellValue('F5','Period');
           //get task query
                $cli_code=$_REQUEST['cli_code'];
                $query = "SELECT * FROM inv_qinvoice where inv_ClientCode =".$cli_code;
                $result=@mysql_query($query);
                $row_inv = mysql_fetch_assoc($result);
                $inv_Code=@mysql_result( $result,0,'inv_Code') ;
                $details_query = "SELECT * FROM inv_qinvoicedetails where inv_QICode =".$inv_Code." order by inv_Code";
                $details_result=mysql_query($details_query);
                $standardRate = array('$250','$730','$835','$325','$50','$100','$300','$100','$300','$0','$0','$0');
                $period = array('one off','one off','one off','one off','per hour','per hour','per year','per month','per year','per year','per year','');
                $c=0;
                $row=6;
                while($task_data = mysql_fetch_array($details_result))
                {
                        $flag = false;
                    if($c==0) { $invoice ->getStyle('C6')->getFont()->setBold(true); $invoice->getStyle('C6')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE); $invoice->setCellValue("C".$row,'Set Up'); $flag = true; }
                    if($c==4) { $invoice ->getStyle('C11')->getFont()->setBold(true); $invoice->getStyle('C11')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE); $invoice->setCellValue("C".$row,'Hourly Rates (tax & accounting)'); $flag = true; }
                    if($c==6) { $invoice ->getStyle('C14')->getFont()->setBold(true); $invoice->getStyle('C14')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE); $invoice->setCellValue("C".$row,'Auditing'); $flag = true; }
                    if($c==7) { $invoice ->getStyle('C16')->getFont()->setBold(true); $invoice->getStyle('C16')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE); $invoice->setCellValue("C".$row,'Fixed Monthly Retainer Fee '); $flag = true; }
                    if($c==9) { $invoice ->getStyle('C19')->getFont()->setBold(true); $invoice->getStyle('C19')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE); $invoice->setCellValue("C".$row,'BACKLOG'); $flag = true; }
                    if($task_data['inv_Rates']=="") { $invRates = $task_data['inv_Rates']; } else { $invRates = '$'.$task_data['inv_Rates']; }
                    $taskContent = $commonUses->getTaskDescription(htmlspecialchars($task_data["inv_TaskCode"]));
                    if($flag)
                    {
                        $r = $row+1;
                        $row = $row+2;
                    }
                    else
                    {
                        $r = $row;
                        $row++;
                    }
                    $invoice->setCellValue("C".$r, $taskContent);
                    $invoice->setCellValue("D".$r, $standardRate[$c]);
                    $invoice->setCellValue("E".$r, $invRates);
                    $invoice->setCellValue("F".$r, $period[$c]);
            $c++;
                }
            $query = "SELECT i1.inv_Code,i2.inv_Notes,i2.inv_IndiaNotes FROM inv_qinvoice AS i1 LEFT OUTER JOIN inv_qinvoicedetails AS i2 ON (i1.inv_Code = i2.inv_QICode) where inv_ClientCode =".$cli_code;
            $result=@mysql_query($query);
            $row_notes = mysql_fetch_array($result);
            $invoice->setCellValue('C24', "Notes");
            $invoice->setCellValue('D24', $row_notes['inv_Notes']);
            $invoice->setCellValue('C25', "India Notes");
            $invoice->setCellValue('D25', $row_notes['inv_IndiaNotes']);
        }

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
$filename  = "quotesheet_".strtotime("now").".xls";
$path = "excel_file/".$filename;
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save($path);
echo '<script>window.open ("excel_open.php?filename='.$filename.'","mywindow","menubar=1,resizable=1,width=350,height=250"); </script>';


?>