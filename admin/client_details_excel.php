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
              
//Client details
//header
$cli_code=$_REQUEST['cli_code'];
$cli_query = "SELECT name FROM jos_users WHERE cli_Code=".$cli_code;
$st_query = mysql_query($cli_query);
$clientName = mysql_fetch_array($st_query);
$company = $clientName['name'];
// header end
//get client name
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

$objPHPExcel->getActiveSheet()->setTitle('ClientDetails');
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1',$company)
            ->setCellValue('G1',"Report Generated at".date('d-M-y'))
            ->setCellValue('C5','Client Details')
            ->setCellValue('D5','')
            ->setCellValue('C6', "Type")
            ->setCellValue('D6', $clitype['cty_Description'])
            ->setCellValue('C7', "Assign Billing Person")
            ->setCellValue('D7', $commonUses->getUsername($content['cli_BillingPerson']))
            ->setCellValue('C8', "Assign Australian Manager")
            ->setCellValue('D8', $commonUses->getUsername($content['cli_AssignAustralia']))
            ->setCellValue('C9', "Assigned To India Manager")
            ->setCellValue('D9', $commonUses->getUsername($content['cli_Assignedto']))
            ->setCellValue('C10', "Assign Team In Charge")
            ->setCellValue('D10', $commonUses->getUsername($content['cli_TeaminCharge']))
            ->setCellValue('C11', "Assign Team Member")
            ->setCellValue('D11', $commonUses->getUsername($content['cli_TeamMember']))
            ->setCellValue('C11', "Senior In Charge")
            ->setCellValue('D11', $commonUses->getUsername($content['cli_SeniorInCharge']))
            ->setCellValue('C12', "Company Name")
            ->setCellValue('D12', $content['name'])
            ->setCellValue('C13', "Category")
            ->setCellValue('D13', $content['cli_Category'])
            ->setCellValue('C14', "Unit/Build Number")
            ->setCellValue('D14', $content['cli_Build'])
            ->setCellValue('C15', "Street Name")
            ->setCellValue('D15', $content['cli_Address'])
            ->setCellValue('C16', "Suburb")
            ->setCellValue('D16', $content['cli_City'])
            ->setCellValue('C17', "State")
            ->setCellValue('D17', $state['cst_Description'])
            ->setCellValue('C18', "Post Code")
            ->setCellValue('D18', $content['cli_Postcode'])
            ->setCellValue('C19', "Country")
            ->setCellValue('D19', $content['cli_Country'])
            ->setCellValue('C20', "Postal Address")
            ->setCellValue('D20', $content['cli_PostalAddress'])
            ->setCellValue('C21', "Phone")
            ->setCellValue('D21', $content['cli_Phone'])
            ->setCellValue('C22', "Mobile")
            ->setCellValue('D22', $content['cli_Mobile'])
            ->setCellValue('C23', "Fax")
            ->setCellValue('D23', $content['cli_Fax'])
            ->setCellValue('C24', "Email")
            ->setCellValue('D24', $content['email'])
            ->setCellValue('C25', "Website")
            ->setCellValue('D25', $content['cli_Website'])
            ->setCellValue('C26', "Date Received")
            ->setCellValue('D26', $commonUses->showGridDateFormat($content['cli_DateReceived']))
            ->setCellValue('C27', "Day Received")
            ->setCellValue('D27', $content['cli_DayReceived'])
            ->setCellValue('C28', "Industry")
            ->setCellValue('D28', $industry['ind_Description'])
            ->setCellValue('C29', "Turnover")
            ->setCellValue('D29', $content['cli_Turnover'])
            ->setCellValue('C30', "Service Required")
            ->setCellValue('D30', $servicerequire)
            ->setCellValue('C31', "Stage")
            ->setCellValue('D31', $stage['cst_Description'])
            ->setCellValue('C32', "Lead Status")
            ->setCellValue('D32', $status['cls_Description'])
            ->setCellValue('C33', "Source")
            ->setCellValue('D33', $source['src_Description'])
            ->setCellValue('C34', "Method of Contact")
            ->setCellValue('D34', $moc['moc_Description'])
            ->setCellValue('C35', "Sales Person")
            ->setCellValue('D35', $commonUses->getUsername($content['cli_Salesperson']))
            ->setCellValue('C36', "Contract Signed date")
            ->setCellValue('D36', $commonUses->showGridDateFormat($content['date_contract_signed']))
            ->setCellValue('C37', "Last date of Contact")
            ->setCellValue('D37', $commonUses->showGridDateFormat($content['cli_Lastdate']))
            ->setCellValue('C38', "Future Contact date")
            ->setCellValue('D38', $commonUses->showGridDateFormat($content['cli_FutureContactDate']))
            ->setCellValue('C39', "Notes")
            ->setCellValue('D39', $content['cli_Notes']);

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
$filename  = "clientDetails_".strtotime("now").".xls";
$path = "excel_file/".$filename;
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save($path);
echo '<script>window.open ("excel_open.php?filename='.$filename.'","mywindow","menubar=1,resizable=1,width=350,height=250"); </script>';


?>