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
//get file access rights
             $formcode=$commonUses->getFormCode("Set up Syd");
                //Call CheckAccess function by passing $_SESSION of staff code and form code
            $access_file_level_syd=$commonUses->checkFileAccess($_SESSION['staffcode'],$formcode);

                //Get FormCode
            $formcode=$commonUses->getFormCode("Permanent Information");
                //Call CheckAccess function by passing $_SESSION of staff code and form code
            $access_file_level_perminfo=$commonUses->checkFileAccess($_SESSION['staffcode'],$formcode);
                //Get FormCode
            $formcode=$commonUses->getFormCode("Current Status");
                //Call CheckAccess function by passing $_SESSION of staff code and form code
            $access_file_level_curst=$commonUses->checkFileAccess($_SESSION['staffcode'],$formcode);
            //Get FormCode
            $formcode=$commonUses->getFormCode("Estimated hours");
            $commonUses->checkFileAccess($_SESSION['staffcode'],$estimateformcode);
                //Call CheckAccess function by passing $_SESSION of staff code and form code
            $access_file_level_estimate=$commonUses->checkFileAccess($_SESSION['staffcode'],$formcode);
            $formcode=$commonUses->getFormCode("Back Log Jobsheet");
                //Call CheckAccess function by passing $_SESSION of staff code and form code
            $access_file_level_blj=$commonUses->checkFileAccess($_SESSION['staffcode'],$formcode);

                //Get FormCode
            $formcode=$commonUses->getFormCode("General Info");
                //Call CheckAccess function by passing $_SESSION of staff code and form code
            $access_file_level_gen=$commonUses->checkFileAccess($_SESSION['staffcode'],$formcode);

                //Get FormCode
            $formcode=$commonUses->getFormCode("Bank");
                //Call CheckAccess function by passing $_SESSION of staff code and form code
            $access_file_level_ban=$commonUses->checkFileAccess($_SESSION['staffcode'],$formcode);

                //Get FormCode
            $formcode=$commonUses->getFormCode("AP");
                //Call CheckAccess function by passing $_SESSION of staff code and form code
            $access_file_level_ape=$commonUses->checkFileAccess($_SESSION['staffcode'],$formcode);

                //Get FormCode
            $formcode=$commonUses->getFormCode("Investments");
                //Call CheckAccess function by passing $_SESSION of staff code and form code
            $access_file_level_are=$commonUses->checkFileAccess($_SESSION['staffcode'],$formcode);

                //Get FormCode
            $formcode=$commonUses->getFormCode("Payroll");
                //Call CheckAccess function by passing $_SESSION of staff code and form code
            $access_file_level_pay=$commonUses->checkFileAccess($_SESSION['staffcode'],$formcode);
            //Get FormCode
            $formcode=$commonUses->getFormCode("BAS");
                //Call CheckAccess function by passing $_SESSION of staff code and form code
            $access_file_level_bas=$commonUses->checkFileAccess($_SESSION['staffcode'],$formcode);

                //Get FormCode
            $formcode=$commonUses->getFormCode("Tax Returns");
                //Call CheckAccess function by passing $_SESSION of staff code and form code
            $access_file_level_tax=$commonUses->checkFileAccess($_SESSION['staffcode'],$formcode);
            //Get FormCode
            $formcode=$commonUses->getFormCode("Special tasks");
                //Call CheckAccess function by passing $_SESSION of staff code and form code
            $access_file_level_specialtasks=$commonUses->checkFileAccess($_SESSION['staffcode'],$formcode);
            //Get FormCode
            $formcode=$commonUses->getFormCode("Task List");
                //Call CheckAccess function by passing $_SESSION of staff code and form code
            $access_file_level_duedate=$commonUses->checkFileAccess($_SESSION['staffcode'],$formcode);
//Get company name for header
$cli_code=$_REQUEST['cli_code'];
$cli_query = "SELECT name FROM jos_users WHERE cli_Code=".$cli_code;
$st_query = mysql_query($cli_query);
$clientName = mysql_fetch_array($st_query);
$company = $clientName['name'];

//Setup syd details
	if(($access_file_level_syd['stf_Add']=="Y" || $access_file_level_syd['stf_View']=="Y" || $access_file_level_syd['stf_Edit']=="Y" || $access_file_level_syd['stf_Delete']=="Y"))
	{
                     $setupsyd  = $objPHPExcel->getActiveSheet()->setTitle('Set up Syd');
                     $setupsyd ->getColumnDimension('C')->setAutoSize(true);
                     $setupsyd ->getColumnDimension('D')->setWidth(50);
                     $setupsyd ->getColumnDimension('E')->setAutoSize(true);
                     $setupsyd ->getRowDimension('5')->setRowHeight(20);
                     $setupsyd ->getDefaultStyle()->getFont()->setName('Arial');
                     $setupsyd ->getDefaultStyle()->getFont()->setSize(10);
                     $setupsyd ->getStyle('C5:E5')->getFont()->setBold(true);
                     $setupsyd ->getStyle('C5:E5')->getFont()->setSize(11);
                     $setupsyd ->getStyle('C5:E5')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
                     $setupsyd ->getStyle('C5:E5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                     $setupsyd ->getStyle('C5:E5')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                     $setupsyd ->getStyle('C5:E5')->getFill()->getStartColor()->setARGB('0a58720a5872');
                     $setupsyd ->getStyle('C5:E5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                     $setupsyd ->getStyle('C5:E5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                     $setupsyd ->getStyle('C5:E5')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                     $setupsyd ->getStyle('C5:E5')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

                      $setupsyd ->setCellValue('A1',$company)
                                ->setCellValue('G1',"Report Generated at".date('d-M-y'))
                                ->setCellValue('C5','Task Description')
                                ->setCellValue('D5','')
                                ->setCellValue('E5','Remarks');
           //get task query
                $cli_code=$_REQUEST['cli_code'];
                $query = "SELECT * FROM  set_psetup where set_ClientCode =".$cli_code;
                $result=@mysql_query($query);
                $row_set = mysql_fetch_assoc($result);
                $set_Code=@mysql_result( $result,0,'set_Code') ;
                $details_query = "SELECT * FROM  set_psetupdetails where set_PSCode =".$set_Code." order by set_Code";
                $details_result=@mysql_query($details_query);
                $c=0;
                $row=6;
                while($task_data = mysql_fetch_array($details_result))
                {
                        $flag = false;
                    if($c==0) { $setupsyd ->getStyle('C6')->getFont()->setBold(true); $setupsyd->getStyle('C6')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE); $setupsyd->setCellValue("C".$row,'Client'); $flag = true; }
                    if($c==5) { $setupsyd ->getStyle('C12')->getFont()->setBold(true); $setupsyd->getStyle('C12')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE); $setupsyd->setCellValue("C".$row,'Super Records'); $flag = true; }
                    $taskContent = $commonUses->getTaskDescription(htmlspecialchars($task_data["set_TaskCode"]));
                    if($task_data['set_TaskValue']=="Y") { $TaskVal = "Yes"; } else { $TaskVal = $task_data['set_TaskValue']; }
                    if($taskContent=='BGL Login Details') { 
                        $loginval = explode('~',$task_data['set_TaskValue']);
                        $TaskVal = 'Username: '.$loginval[0].", Password: ".$loginval[1];
                    }
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
                    $setupsyd->setCellValue("C".$r, $taskContent);
                    $setupsyd->setCellValue("D".$r, $TaskVal);
                    $setupsyd->setCellValue("E".$r, $task_data['set_Remarks']);
            $c++;
                }
            $query = "SELECT i1.set_Code,i2.set_Notes,i2.set_IndiaNotes FROM set_psetup AS i1 LEFT OUTER JOIN set_psetupdetails AS i2 ON (i1.set_Code = i2.set_PSCode) where set_ClientCode =".$cli_code;
            $result=@mysql_query($query);
            $row_notes = mysql_fetch_array($result);
            $setupsyd->setCellValue('C17', "Notes");
            $setupsyd->setCellValue('D17', $row_notes['set_Notes']);
            $setupsyd->setCellValue('C18', "India Notes");
            $setupsyd->setCellValue('D18', $row_notes['set_IndiaNotes']);
        }

//perm info
	if(($access_file_level_perminfo['stf_Add']=="Y" || $access_file_level_perminfo['stf_View']=="Y" || $access_file_level_perminfo['stf_Edit']=="Y" || $access_file_level_perminfo['stf_Delete']=="Y"))
	{
                     $perminfo  = $objPHPExcel->createSheet();
                     $perminfo ->setTitle('Perm Info');
                     $perminfo ->getColumnDimension('C')->setAutoSize(true);
                     $perminfo ->getColumnDimension('D')->setWidth(50);
                     $perminfo ->getRowDimension('5')->setRowHeight(20);
                     $perminfo ->getDefaultStyle()->getFont()->setName('Arial');
                     $perminfo ->getDefaultStyle()->getFont()->setSize(10);
                     $perminfo ->getStyle('C5:D5')->getFont()->setBold(true);
                     $perminfo ->getStyle('C5:D5')->getFont()->setSize(11);

                     $perminfo ->getStyle('C5:D5')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
                     $perminfo ->getStyle('C5:D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                     $perminfo ->getStyle('C5:D5')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                     $perminfo ->getStyle('C5:D5')->getFill()->getStartColor()->setARGB('0a58720a5872');
                     $perminfo ->getStyle('C5:D5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                     $perminfo ->getStyle('C5:D5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                     $perminfo ->getStyle('C5:D5')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                     $perminfo ->getStyle('C5:D5')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

                      $perminfo ->setCellValue('A1',$company)
                                ->setCellValue('G1',"Report Generated at".date('d-M-y'))
                                ->setCellValue('C5','Task Description')
                                ->setCellValue('D5','');
           //get task query
                $cli_code=$_REQUEST['cli_code'];
                $query = "SELECT * FROM inf_pinfo where inf_ClientCode =".$cli_code;
                $result=@mysql_query($query);
                $row_inf = mysql_fetch_assoc($result);
                $inf_Code=@mysql_result( $result,0,'inf_Code') ;
                    $details_query = "SELECT * FROM inf_pinfodetails where inf_PInfoCode =".$inf_Code." order by inf_Code";
                    $details_result=mysql_query($details_query);
                $c=0;
                $row=6;
                while($task_data = mysql_fetch_array($details_result))
                {
                        $flag = false;
                    if($c==0) { $perminfo ->getStyle('C6')->getFont()->setBold(true); $perminfo->getStyle('C6')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE); $perminfo->setCellValue("C".$row,'Client Details'); $flag = true; }
                    if($c==7) { $perminfo ->getStyle('C14')->getFont()->setBold(true); $perminfo->getStyle('C14')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE); $perminfo->setCellValue("C".$row,'INCOME'); $flag = true; }
                    if($c==9) { $perminfo ->getStyle('C17')->getFont()->setBold(true); $perminfo->getStyle('C17')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE); $perminfo->setCellValue("C".$row,'EXPENSES'); $flag = true; }
                    if($c==11) { $perminfo ->getStyle('C20')->getFont()->setBold(true); $perminfo->getStyle('C20')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE); $perminfo->setCellValue("C".$row,'Software / Version / Licensing'); $flag = true; }
                    //if($c==16) { $perminfo ->getStyle('C26')->getFont()->setBold(true); $perminfo->getStyle('C26')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE); $perminfo->setCellValue("C".$row,'Software / Version / Licensing'); $flag = true; }
                    //if($c==24) { $perminfo ->getStyle('C35')->getFont()->setBold(true); $perminfo->getStyle('C35')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE); $perminfo->setCellValue("C".$row,'Access to the clients file'); $flag = true; }
                    if($task_data['inf_TaskValue']=="Y") { $TaskVal = "Yes"; } else { $TaskVal = $task_data['inf_TaskValue']; }
                    $taskContent = $commonUses->getTaskDescription(htmlspecialchars($task_data["inf_TaskCode"]));
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
                    $perminfo->setCellValue("C".$r, $taskContent);
                    $perminfo->setCellValue("D".$r, $TaskVal);
            $c++;
                }
            $query = "SELECT i1.inf_Code,i2.inf_Notes,i2.inf_IndiaNotes FROM inf_pinfo AS i1 LEFT OUTER JOIN inf_pinfodetails AS i2 ON (i1.inf_Code = i2.inf_PInfoCode) where inf_ClientCode =".$cli_code;
            $result=@mysql_query($query);
            $row_notes = mysql_fetch_array($result);
            $perminfo->setCellValue('C25', "Notes");
            $perminfo->setCellValue('D25', $row_notes['inf_Notes']);
            $perminfo->setCellValue('C26', "India Notes");
            $perminfo->setCellValue('D26', $row_notes['inf_IndiaNotes']);

        }
//current status
	if(($access_file_level_curst['stf_Add']=="Y" || $access_file_level_curst['stf_View']=="Y" || $access_file_level_curst['stf_Edit']=="Y" || $access_file_level_curst['stf_Delete']=="Y" ))
	{
                     $currentstatus  = $objPHPExcel->createSheet();
                     $currentstatus ->setTitle('Current status');
                     $currentstatus ->getColumnDimension('C')->setAutoSize(true);
                     $currentstatus ->getColumnDimension('D')->setWidth(50);
                     $currentstatus ->getRowDimension('5')->setRowHeight(20);
                     $currentstatus ->getDefaultStyle()->getFont()->setName('Arial');
                     $currentstatus ->getDefaultStyle()->getFont()->setSize(10);
                     $currentstatus ->getStyle('C5:D5')->getFont()->setBold(true);
                     $currentstatus ->getStyle('C5:D5')->getFont()->setSize(11);
                     $currentstatus ->getStyle('C5:D5')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
                     $currentstatus ->getStyle('C5:D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                     $currentstatus ->getStyle('C5:D5')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                     $currentstatus ->getStyle('C5:D5')->getFill()->getStartColor()->setARGB('0a58720a5872');
                     $currentstatus ->getStyle('C5:D5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                     $currentstatus ->getStyle('C5:D5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                     $currentstatus ->getStyle('C5:D5')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                     $currentstatus ->getStyle('C5:D5')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

                      $currentstatus ->setCellValue('A1',$company)
                                ->setCellValue('G1',"Report Generated at".date('d-M-y'))
                                ->setCellValue('C5','Task Description')
                                ->setCellValue('D5','');
           //get task query
                $cli_code=$_REQUEST['cli_code'];
                $query = "SELECT * FROM cst_pcurrentstatus where cst_ClientCode =".$cli_code;
                $result=@mysql_query($query);
                $row_cst = mysql_fetch_assoc($result);
                $cst_Code=@mysql_result( $result,0,'cst_Code') ;
                $details_query = "SELECT * FROM cst_pcurrentstatusdetails where cst_PCSCode =".$cst_Code." order by cst_Code";
                $details_result=@mysql_query($details_query);
                $c=0;
                $row=6;
                while($task_data = mysql_fetch_array($details_result))
                {
                        $flag = false;
                    if($c==0) { $currentstatus ->getStyle('C6')->getFont()->setBold(true); $currentstatus->getStyle('C6')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE); $currentstatus->setCellValue("C".$row,'Current Status'); $flag = true; }
                    $taskContent = $commonUses->getTaskDescription(htmlspecialchars($task_data["cst_TaskCode"]));
                    if($task_data['cst_TaskValue']=="Y") { $TaskVal = "Yes"; } else { $TaskVal = $task_data['cst_TaskValue']; }
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
                    $currentstatus->setCellValue("C".$r, $taskContent);
                    $currentstatus->setCellValue("D".$r, $TaskVal);
            $c++;
                }
            $query = "SELECT i1.cst_Code,i2.cst_Notes,i2.cst_IndiaNotes FROM cst_pcurrentstatus AS i1 LEFT OUTER JOIN cst_pcurrentstatusdetails AS i2 ON (i1.cst_Code = i2.cst_PCSCode) where cst_ClientCode =".$cli_code;
            $result=@mysql_query($query);
            $row_notes = mysql_fetch_array($result);
            $currentstatus->setCellValue('C13', "Notes");
            $currentstatus->setCellValue('D13', $row_notes['cst_Notes']);
            $currentstatus->setCellValue('C14', "India Notes");
            $currentstatus->setCellValue('D14', $row_notes['cst_IndiaNotes']);
        }
//backlog jobsheet
	if(($access_file_level_blj['stf_Add']=="Y" || $access_file_level_blj['stf_View']=="Y" || $access_file_level_blj['stf_Edit']=="Y" || $access_file_level_blj['stf_Delete']=="Y" ))
	{
                     $backlog  = $objPHPExcel->createSheet();
                     $backlog  ->setTitle('Backlog Jobsheet');
                     $backlog  ->getColumnDimension('C')->setAutoSize(true);
                     $backlog  ->getColumnDimension('D')->setWidth(50);
                     $backlog  ->getRowDimension('5')->setRowHeight(20);
                     $backlog  ->getRowDimension('20')->setRowHeight(20);
                     $backlog  ->getDefaultStyle()->getFont()->setName('Arial');
                     $backlog  ->getDefaultStyle()->getFont()->setSize(10);
                     $backlog ->getStyle('C5:D5')->getFont()->setBold(true);
                     $backlog ->getStyle('C5:D5')->getFont()->setSize(11);
                     $backlog ->getStyle('C20:D20')->getFont()->setBold(true);
                     $backlog ->getStyle('C20:D20')->getFont()->setSize(11);

                     $backlog  ->getStyle('C5:D5')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
                     $backlog  ->getStyle('C20:D20')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
                     $backlog  ->getStyle('C5:D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                     $backlog  ->getStyle('C20:D20')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                     $backlog  ->getStyle('C5:D5')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                     $backlog  ->getStyle('C5:D5')->getFill()->getStartColor()->setARGB('0a58720a5872');
                     $backlog  ->getStyle('C20:D20')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                     $backlog  ->getStyle('C20:D20')->getFill()->getStartColor()->setARGB('0a58720a5872');
                     $backlog  ->getStyle('C5:D5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                     $backlog  ->getStyle('C5:D5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                     $backlog  ->getStyle('C5:D5')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                     $backlog  ->getStyle('C5:D5')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                     $backlog  ->getStyle('C20:D20')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                     $backlog  ->getStyle('C20:D20')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                     $backlog  ->getStyle('C20:D20')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                     $backlog  ->getStyle('C20:D20')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

                      $backlog  ->setCellValue('A1',$company)
                                ->setCellValue('G1',"Report Generated at".date('d-M-y'))
                                ->setCellValue('C5','Task Description')
                                ->setCellValue('D5','');
           //get task query
                $cli_code=$_REQUEST['cli_code'];
                $query = "SELECT * FROM  blj_pbacklog where blj_ClientCode =".$cli_code;
                $result=@mysql_query($query);
                $row_backlog = mysql_fetch_assoc($result);
                $blj_Code=@mysql_result( $result,0,'blj_Code') ;
                $details_query = "SELECT * FROM blj_pbacklogdetails where blj_PBLCode =".$blj_Code." order by blj_Code";
                $details_result=@mysql_query($details_query);
                $c=0;
                $row=6;
                while($task_data = mysql_fetch_array($details_result))
                {
                        $flag = false;
                    if($c==0) { $backlog ->getStyle('C6')->getFont()->setBold(true); $backlog->getStyle('C6')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE); $backlog  ->setCellValue("C".$row,'Backlog jobsheet'); $flag = true; }
                    if($c==2) { $backlog ->getStyle('C9')->getFont()->setBold(true); $backlog->getStyle('C9')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE); $backlog  ->setCellValue("C".$row,'Types of job to be done'); $flag = true; }
                    //if($c==17) { $backlog ->getStyle('C25')->getFont()->setBold(true); $backlog->getStyle('C25')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE); $backlog  ->setCellValue("C".$row,'Software'); $flag = true; }
                    $taskContent = $commonUses->getTaskDescription(htmlspecialchars($task_data["blj_TaskCode"]));
                    $task_explode = explode("~",$task_data['blj_TaskValue']);
                    $task_Val1 = $task_explode[0];
                    $task_Val2 = $task_explode[1];
                    if($task_data['blj_TaskValue']=="Y") { $TaskVal = "Yes"; } else { $TaskVal = $task_Val1; if(count($task_explode)>1) { if($task_Val1=="Y") { $otherVal = "Yes"; } $TaskVal = $otherVal.".  Other: ".$task_Val2; } else { $TaskVal = $task_Val1; }}
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
                    $backlog  ->setCellValue("C".$r, $taskContent);
                    $backlog  ->setCellValue("D".$r, $TaskVal);
            $c++;
                }
//Source documents

                              $backlog ->setCellValue('C20','Source Documents needed')
                                       ->setCellValue('D20','Method of delivery(attached / to come');
           //get task query
                $cli_code=$_REQUEST['cli_code'];
                $query = "SELECT * FROM  blj_pbacklog where blj_ClientCode =".$cli_code;
                $result=@mysql_query($query);
                $row_backlog = mysql_fetch_assoc($result);
                $blj_Code=@mysql_result( $result,0,'blj_Code') ;
                    $details_query = "SELECT * FROM bjs_sourcedocumentdetails where bjs_PBLCode =".$blj_Code." order by bjs_Code asc limit 10";
                    $details_result=@mysql_query($details_query);
                $r=21;
                while($task_data = mysql_fetch_array($details_result))
                {
                    $sourceDoc = $task_data['bjs_SourceDocument'];
                    if($sourceDoc=="NULL") { $sourceDoc=""; }
                    $backlog  ->setCellValue("C".$r, $sourceDoc);
                    $backlog  ->setCellValue("D".$r, $task_data['bjs_MethodofDelivery']);
                    $r++;
                }

            $query = "SELECT i1.blj_Code,i2.blj_Notes,i2.blj_IndiaNotes FROM blj_pbacklog AS i1 LEFT OUTER JOIN blj_pbacklogdetails AS i2 ON (i1.blj_Code = i2.blj_PBLCode) where blj_ClientCode =".$cli_code;
            $result=@mysql_query($query);
            $row_notes = mysql_fetch_array($result);
            $backlog  ->setCellValue('C32', "Notes");
            $backlog  ->setCellValue('D32', $row_notes['blj_Notes']);
            $backlog  ->setCellValue('C33', "India Notes");
            $backlog  ->setCellValue('D33', $row_notes['blj_IndiaNotes']);
        }
//Bank
	if(($access_file_level_ban['stf_Add']=="Y" || $access_file_level_ban['stf_View']=="Y" || $access_file_level_ban['stf_Edit']=="Y" || $access_file_level_ban['stf_Delete']=="Y" ))
	{
                     $bank  = $objPHPExcel->createSheet();
                     $bank  ->setTitle('Bank');
                     $bank  ->getColumnDimension('C')->setAutoSize(true);
                     $bank  ->getColumnDimension('D')->setWidth(50);
                     $bank  ->getRowDimension('5')->setRowHeight(20);
                     $bank  ->getDefaultStyle()->getFont()->setName('Arial');
                     $bank  ->getDefaultStyle()->getFont()->setSize(10);
                     $bank ->getStyle('C5:D5')->getFont()->setBold(true);
                     $bank ->getStyle('C5:D5')->getFont()->setSize(11);
                     $bank  ->getStyle('C5:D5')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
                     $bank  ->getStyle('C5:D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                     $bank  ->getStyle('C5:D5')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                     $bank  ->getStyle('C5:D5')->getFill()->getStartColor()->setARGB('0a58720a5872');
                     $bank  ->getStyle('C5:D5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                     $bank  ->getStyle('C5:D5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                     $bank  ->getStyle('C5:D5')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                     $bank  ->getStyle('C5:D5')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

                      $bank  ->setCellValue('A1',$company)
                                ->setCellValue('G1',"Report Generated at".date('d-M-y'))
                                ->setCellValue('C5','Task Description')
                                ->setCellValue('D5','');
           //get task query
                $cli_code=$_REQUEST['cli_code'];
                $query = "SELECT * FROM  ban_pbank where ban_ClientCode =".$cli_code;
                $result=@mysql_query($query);
                $row_ban = mysql_fetch_assoc($result);
                $ban_Code=@mysql_result( $result,0,'ban_Code') ;
                $details_query = "SELECT * FROM ban_pbankdetails where ban_PBCode =".$ban_Code." order by ban_Code";
                $details_result=@mysql_query($details_query);
                $c=0;
                $row=6;
                while($task_data = mysql_fetch_array($details_result))
                {
                        $flag = false;
                    if($c==0) { $bank ->getStyle('C6')->getFont()->setBold(true); $bank->getStyle('C6')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE); $bank  ->setCellValue("C".$row,'Transactions and Bank'); $flag = true; }
                    $taskContent = $commonUses->getTaskDescription(htmlspecialchars($task_data["ban_TaskCode"]));
                    if($task_data['ban_TaskValue']=="Y") { $TaskVal = "Yes"; } else { $TaskVal = $task_data['ban_TaskValue']; }
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
                    $bank  ->setCellValue("C".$r, $taskContent);
                    $bank  ->setCellValue("D".$r, $TaskVal);
            $c++;
                }
            $query = "SELECT i1.ban_Code,i2.ban_Notes,i2.ban_IndiaNotes FROM ban_pbank AS i1 LEFT OUTER JOIN ban_pbankdetails AS i2 ON (i1.ban_Code = i2.ban_PBCode) where ban_ClientCode =".$cli_code;
            $result=@mysql_query($query);
            $row_notes = mysql_fetch_array($result);
            $bank  ->setCellValue('C15', "Notes");
            $bank  ->setCellValue('D15', $row_notes['ban_Notes']);
            $bank  ->setCellValue('C16', "India Notes");
            $bank  ->setCellValue('D16', $row_notes['ban_IndiaNotes']);
        }
//Investments
	if(($access_file_level_are['stf_Add']=="Y" || $access_file_level_are['stf_View']=="Y" || $access_file_level_are['stf_Edit']=="Y" || $access_file_level_are['stf_Delete']=="Y" ))
	{
                 $AR  = $objPHPExcel->createSheet();
                     $AR  ->setTitle('Investments');
                     $AR  ->getColumnDimension('C')->setAutoSize(true);
                     $AR  ->getColumnDimension('D')->setWidth(50);
                     $AR  ->getRowDimension('5')->setRowHeight(20);
                     $AR  ->getDefaultStyle()->getFont()->setName('Arial');
                     $AR  ->getDefaultStyle()->getFont()->setSize(10);
                     $AR ->getStyle('C5:D5')->getFont()->setBold(true);
                     $AR ->getStyle('C5:D5')->getFont()->setSize(11);
                     $AR  ->getStyle('C5:D5')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
                     $AR  ->getStyle('C5:D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                     $AR  ->getStyle('C5:D5')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                     $AR  ->getStyle('C5:D5')->getFill()->getStartColor()->setARGB('0a58720a5872');
                     $AR  ->getStyle('C5:D5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                     $AR  ->getStyle('C5:D5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                     $AR  ->getStyle('C5:D5')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                     $AR  ->getStyle('C5:D5')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

                      $AR  ->setCellValue('A1',$company)
                                ->setCellValue('G1',"Report Generated at".date('d-M-y'))
                                ->setCellValue('C5','Task Description')
                                ->setCellValue('D5','');
           //get task query
                $cli_code=$_REQUEST['cli_code'];
                $query = "SELECT * FROM  are_paccountsreceivable where are_ClientCode =".$cli_code;
                $result=@mysql_query($query);
                $row_are = mysql_fetch_assoc($result);
                $are_Code=@mysql_result( $result,0,'are_Code') ;
                 $details_query = "SELECT * FROM `are_paccountsreceivable details` where are_PARCode =".$are_Code." order by are_Code";
		$details_result=@mysql_query($details_query);
                $c=0;
                $row=6;
                while($task_data = mysql_fetch_array($details_result))
                {
                        $flag = false;
                    if($c==0) { $AR ->getStyle('C6')->getFont()->setBold(true); $AR->getStyle('C6')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE); $AR  ->setCellValue("C".$row,'Investments - Listed Shares'); $flag = true; }
                    if($c==6) { $AR ->getStyle('C13')->getFont()->setBold(true); $AR->getStyle('C13')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE); $AR  ->setCellValue("C".$row,'Investments - Unlisted Shares'); $flag = true; }
                    if($c==11) { $AR ->getStyle('C19')->getFont()->setBold(true); $AR->getStyle('C19')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE); $AR  ->setCellValue("C".$row,'Investments - Listed unit trusts'); $flag = true; }
                    if($c==17) { $AR ->getStyle('C26')->getFont()->setBold(true); $AR->getStyle('C26')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE); $AR  ->setCellValue("C".$row,'Investments - Unlisted unit trusts'); $flag = true; }
                    if($c==22) { $AR ->getStyle('C32')->getFont()->setBold(true); $AR->getStyle('C32')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE); $AR  ->setCellValue("C".$row,'Investments - Managed Investments'); $flag = true; }
                    if($c==28) { $AR ->getStyle('C39')->getFont()->setBold(true); $AR->getStyle('C39')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE); $AR  ->setCellValue("C".$row,'Investments - Properties'); $flag = true; }
                    if($c==36) { $AR ->getStyle('C48')->getFont()->setBold(true); $AR->getStyle('C48')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE); $AR  ->setCellValue("C".$row,'Investments - Others'); $flag = true; }
                    $taskContent = $commonUses->getTaskDescription(htmlspecialchars($task_data["are_TaskCode"]));
                    if($task_data['are_TaskValue']=="Y") { $TaskVal = "Yes"; } else { $TaskVal = $task_data['are_TaskValue']; }
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
                    $AR  ->setCellValue("C".$r, $taskContent);
                    $AR  ->setCellValue("D".$r, $TaskVal);
            $c++;
                }
            $query = "SELECT i1.are_Code,i2.are_Notes,i2.are_IndiaNotes FROM are_paccountsreceivable AS i1 LEFT OUTER JOIN `are_paccountsreceivable details` AS i2 ON (i1.are_Code = i2.are_PARCode) where are_ClientCode =".$cli_code;
            $result=@mysql_query($query);
            $row_notes = mysql_fetch_array($result);
            $AR  ->setCellValue('C55', "Notes");
            $AR  ->setCellValue('D55', $row_notes['are_Notes']);
            $AR  ->setCellValue('C56', "India Notes");
            $AR  ->setCellValue('D56', $row_notes['are_IndiaNotes']);
        }
// Tax Returns
	if(($access_file_level_tax['stf_Add']=="Y" || $access_file_level_tax['stf_View']=="Y" || $access_file_level_tax['stf_Edit']=="Y" || $access_file_level_tax['stf_Delete']=="Y" ))
	{
                     $taxreturn  = $objPHPExcel->createSheet();
                     $taxreturn  ->setTitle('Tax Return');
                     $taxreturn  ->getColumnDimension('C')->setAutoSize(true);
                     $taxreturn  ->getColumnDimension('D')->setWidth(50);
                     $taxreturn  ->getRowDimension('5')->setRowHeight(20);
                     $taxreturn  ->getDefaultStyle()->getFont()->setName('Arial');
                     $taxreturn  ->getDefaultStyle()->getFont()->setSize(10);
                     $taxreturn ->getStyle('C5:D5')->getFont()->setBold(true);
                     $taxreturn ->getStyle('C5:D5')->getFont()->setSize(11);
                     $taxreturn  ->getStyle('C5:D5')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
                     $taxreturn  ->getStyle('C5:D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                     $taxreturn  ->getStyle('C5:D5')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                     $taxreturn  ->getStyle('C5:D5')->getFill()->getStartColor()->setARGB('0a58720a5872');
                     $taxreturn  ->getStyle('C5:D5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                     $taxreturn  ->getStyle('C5:D5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                     $taxreturn  ->getStyle('C5:D5')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                     $taxreturn  ->getStyle('C5:D5')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

                      $taxreturn  ->setCellValue('A1',$company)
                                ->setCellValue('G1',"Report Generated at".date('d-M-y'))
                                ->setCellValue('C5','Task Description')
                                ->setCellValue('D5','');
           //get task query
                $cli_code=$_REQUEST['cli_code'];
                $query = "SELECT * FROM  tar_ptaxreturns where tar_ClientCode =".$cli_code;
                $result=@mysql_query($query);
                $row_tar = mysql_fetch_assoc($result);
                $tar_Code=@mysql_result( $result,0,'tar_Code') ;
                $details_query = "SELECT * FROM `tar_ptaxreturnsdetails` where tar_PTRCode =".$tar_Code." order by tar_Code";
                $details_result=@mysql_query($details_query);
                $c=0;
                $row=6;
                while($task_data = mysql_fetch_array($details_result))
                {
                        $flag = false;
                    if($c==0) { $taxreturn ->getStyle('C6')->getFont()->setBold(true); $taxreturn->getStyle('C6')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE); $taxreturn  ->setCellValue("C".$row,'Tax Returns'); $flag = true; }
                    $taskContent = $commonUses->getTaskDescription(htmlspecialchars($task_data["tar_TaskCode"]));
                    if($task_data['tar_TaskValue']=="Y") { $TaskVal = "Yes"; } else { $TaskVal = $task_data['tar_TaskValue']; }
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
                    $taxreturn  ->setCellValue("C".$r, $taskContent);
                    $taxreturn  ->setCellValue("D".$r, $TaskVal);
            $c++;
                }
            $query = "SELECT i1.tar_Code,i2.tar_Notes,i2.tar_IndiaNotes FROM tar_ptaxreturns AS i1 LEFT OUTER JOIN tar_ptaxreturnsdetails AS i2 ON (i1.tar_Code = i2.tar_PTRCode) where tar_ClientCode =".$cli_code;
            $result=@mysql_query($query);
            $row_notes = mysql_fetch_array($result);
            $taxreturn  ->setCellValue('C12', "Notes");
            $taxreturn  ->setCellValue('D12', $row_notes['tar_Notes']);
            $taxreturn  ->setCellValue('C13', "India Notes");
            $taxreturn  ->setCellValue('D13', $row_notes['tar_IndiaNotes']);
        }
//BAS
	if(($access_file_level_bas['stf_Add']=="Y" || $access_file_level_bas['stf_View']=="Y" || $access_file_level_bas['stf_Edit']=="Y" || $access_file_level_bas['stf_Delete']=="Y" ))
	{
                     $BAS  = $objPHPExcel->createSheet();
                     $BAS  ->setTitle('BAS');
                     $BAS  ->getColumnDimension('C')->setAutoSize(true);
                     $BAS  ->getColumnDimension('D')->setWidth(50);
                     $BAS  ->getRowDimension('5')->setRowHeight(20);
                     $BAS  ->getDefaultStyle()->getFont()->setName('Arial');
                     $BAS  ->getDefaultStyle()->getFont()->setSize(10);
                     $BAS ->getStyle('C5:D5')->getFont()->setBold(true);
                     $BAS ->getStyle('C5:D5')->getFont()->setSize(11);
                     $BAS  ->getStyle('C5:D5')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
                     $BAS  ->getStyle('C5:D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                     $BAS  ->getStyle('C5:D5')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                     $BAS  ->getStyle('C5:D5')->getFill()->getStartColor()->setARGB('0a58720a5872');
                     $BAS  ->getStyle('C5:D5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                     $BAS  ->getStyle('C5:D5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                     $BAS  ->getStyle('C5:D5')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                     $BAS  ->getStyle('C5:D5')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

                      $BAS  ->setCellValue('A1',$company)
                                ->setCellValue('G1',"Report Generated at".date('d-M-y'))
                                ->setCellValue('C5','Task Description')
                                ->setCellValue('D5','');
           //get task query
                $cli_code=$_REQUEST['cli_code'];
                $query = "SELECT * FROM bas_bankaccount where bas_ClientCode =".$cli_code;
                $result=@mysql_query($query);
                $row_cst = mysql_fetch_assoc($result);
                $bas_Code=@mysql_result( $result,0,'bas_Code') ;
                $details_query = "SELECT * FROM bas_bankaccountdetails where bas_BASCode =".$bas_Code." order by bas_Code";
                $details_result=@mysql_query($details_query);
                $c=0;
                $row=6;
                while($task_data = mysql_fetch_array($details_result))
                {
                        $flag = false;
                    if($c==0) { $BAS ->getStyle('C6')->getFont()->setBold(true); $BAS->getStyle('C6')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE); $BAS  ->setCellValue("C".$row,'GST / IAS'); $flag = true; }
                    $taskContent = $commonUses->getTaskDescription(htmlspecialchars($task_data["bas_TaskCode"]));
                    if($task_data['bas_TaskValue']=="Y") { $TaskVal = "Yes"; } else { $TaskVal = $task_data['bas_TaskValue']; }
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
                    $BAS  ->setCellValue("C".$r, $taskContent);
                    $BAS  ->setCellValue("D".$r, $TaskVal);
            $c++;
                }
            $query = "SELECT i1.bas_Code,i2.bas_Notes,i2.bas_IndiaNotes FROM bas_bankaccount AS i1 LEFT OUTER JOIN bas_bankaccountdetails AS i2 ON (i1.bas_Code = i2.bas_BASCode) where bas_ClientCode =".$cli_code;
            $result=@mysql_query($query);
            $row_notes = mysql_fetch_array($result);
            $BAS  ->setCellValue('C14', "Notes");
            $BAS  ->setCellValue('D14', $row_notes['bas_Notes']);
            $BAS  ->setCellValue('C15', "India Notes");
            $BAS  ->setCellValue('D15', $row_notes['bas_IndiaNotes']);
        }
// Special Tasks
	if(($access_file_level_specialtasks['stf_Add']=="Y" || $access_file_level_specialtasks['stf_View']=="Y" || $access_file_level_specialtasks['stf_Edit']=="Y" || $access_file_level_specialtasks['stf_Delete']=="Y" ))
	{
                     $sptasks  = $objPHPExcel->createSheet();
                     $sptasks  ->setTitle('Special Tasks');
                     $sptasks  ->getColumnDimension('C')->setAutoSize(true);
                     $sptasks  ->getColumnDimension('D')->setWidth(50);
                     $sptasks  ->getRowDimension('5')->setRowHeight(20);
                     $sptasks  ->getDefaultStyle()->getFont()->setName('Arial');
                     $sptasks  ->getDefaultStyle()->getFont()->setSize(10);
                     $sptasks ->getStyle('C5:D5')->getFont()->setBold(true);
                     $sptasks ->getStyle('C5:D5')->getFont()->setSize(11);
                     $sptasks  ->getStyle('C5:D5')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
                     $sptasks  ->getStyle('C5:D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                     $sptasks  ->getStyle('C5:D5')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                     $sptasks  ->getStyle('C5:D5')->getFill()->getStartColor()->setARGB('0a58720a5872');
                     $sptasks  ->getStyle('C5:D5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                     $sptasks  ->getStyle('C5:D5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                     $sptasks  ->getStyle('C5:D5')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                     $sptasks  ->getStyle('C5:D5')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

                      $sptasks  ->setCellValue('A1',$company)
                                ->setCellValue('G1',"Report Generated at".date('d-M-y'))
                                ->setCellValue('C5','Task Description')
                                ->setCellValue('D5','');
           //get task query
                $cli_code=$_REQUEST['cli_code'];
                $query = "SELECT * FROM spt_specialtasks where spt_ClientCode =".$cli_code;
                $result=@mysql_query($query);
                $row_cst = mysql_fetch_assoc($result);
                $spt_Code=@mysql_result( $result,0,'spt_Code') ;
                $details_query = "SELECT * FROM spt_specialtasksdetails where spt_SPLCode =".$spt_Code." order by spt_Code";
                $details_result=@mysql_query($details_query);
                $c=0;
                $row=6;
                while($task_data = mysql_fetch_array($details_result))
                {
                        $flag = false;
                    if($c==0) { $sptasks ->getStyle('C6')->getFont()->setBold(true); $sptasks->getStyle('C6')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE); $sptasks  ->setCellValue("C".$row,'Special Tasks'); $flag = true; }
                    $taskContent = $commonUses->getTaskDescription(htmlspecialchars($task_data["spt_TaskCode"]));
                    if($task_data['spt_TaskValue']=="Y") { $TaskVal = "Yes"; } else { $TaskVal = $task_data['spt_TaskValue']; }
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
                    $sptasks  ->setCellValue("C".$r, $taskContent);
                    $sptasks  ->setCellValue("D".$r, $TaskVal);
            $c++;
                }
            $query = "SELECT i1.spt_Code,i2.spt_Notes,i2.spt_IndiaNotes FROM spt_specialtasks AS i1 LEFT OUTER JOIN spt_specialtasksdetails AS i2 ON (i1.spt_Code = i2.spt_SPLCode) where spt_ClientCode =".$cli_code;
            $result=@mysql_query($query);
            $row_notes = mysql_fetch_array($result);
            $sptasks  ->setCellValue('C10', "Notes");
            $sptasks  ->setCellValue('D10', $row_notes['spt_Notes']);
            $sptasks  ->setCellValue('C11', "India Notes");
            $sptasks  ->setCellValue('D11', $row_notes['spt_IndiaNotes']);
        }
// Task lists
	if(($access_file_level_duedate['stf_Add']=="Y" || $access_file_level_duedate['stf_View']=="Y" || $access_file_level_duedate['stf_Edit']=="Y" || $access_file_level_duedate['stf_Delete']=="Y" ))
	{
             $duedate  = $objPHPExcel->createSheet();
             $duedate  ->setTitle('Task List');
             $duedate ->getColumnDimension('C')->setAutoSize(true);
             $duedate ->getColumnDimension('D')->setWidth(50);
             $duedate ->getColumnDimension('E')->setAutoSize(true);
             $duedate ->getColumnDimension('F')->setWidth(20);
             $duedate ->getColumnDimension('G')->setAutoSize(true);
             $duedate ->getColumnDimension('H')->setWidth(20);
             $duedate ->getColumnDimension('I')->setWidth(20);
             $duedate ->getColumnDimension('J')->setWidth(20);
             $duedate ->getColumnDimension('K')->setWidth(20);
             $duedate ->getColumnDimension('L')->setWidth(50);
             
             $duedate ->getRowDimension('5')->setRowHeight(20);
             $duedate ->getRowDimension('12')->setRowHeight(20);
             
             $duedate ->getDefaultStyle()->getFont()->setName('Arial');
             $duedate ->getDefaultStyle()->getFont()->setSize(10);
             $duedate ->getStyle('C5:L5')->getFont()->setBold(true);
             $duedate ->getStyle('C5:L5')->getFont()->setSize(11);
             $duedate ->getStyle('C5:L5')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
             $duedate ->getStyle('C5:L5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
             $duedate ->getStyle('C5:L5')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
             $duedate ->getStyle('C5:L5')->getFill()->getStartColor()->setARGB('0a58720a5872');
             $duedate ->getStyle('C5:L5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
             $duedate ->getStyle('C5:L5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
             $duedate ->getStyle('C5:L5')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
             $duedate ->getStyle('C5:L5')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

             $duedate ->getStyle('C12')->getFont()->setBold(true);
             $duedate ->getStyle('C12')->getFont()->setSize(11);
             $duedate ->getStyle('C12')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
             $duedate ->getStyle('C12')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
             $duedate ->getStyle('C12')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
             $duedate ->getStyle('C12')->getFill()->getStartColor()->setARGB('0a58720a5872');
             $duedate ->getStyle('C12')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
             $duedate ->getStyle('C12')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
             $duedate ->getStyle('C12')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
             $duedate ->getStyle('C12')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
             
             // get task value
            $cli_code=$_REQUEST['cli_code'];
            $query = mysql_query("select * from tsk_perminfotasklist where cli_code=".$cli_code."");
            $tsk_row = mysql_fetch_array($query);
            // sub activity
            $sub_activity = explode(',',$tsk_row['sub_activity']);
            $sub_activity8 = explode('~',$sub_activity[0]); $sub_activity9 = explode('~',$sub_activity[1]); $sub_activity10 = explode('~',$sub_activity[2]); $sub_activity11 = explode('~',$sub_activity[3]); $sub_activity12 = explode('~',$sub_activity[4]);
            //befree internal due date
            $int_duedate = explode(',',$tsk_row['befree_internal_due_date']);
            $int_duedate3 = explode('~',$int_duedate[0]); $int_duedate4 = explode('~',$int_duedate[1]); $int_duedate5 = explode('~',$int_duedate[2]); $int_duedate7 = explode('~',$int_duedate[3]); $int_duedate8 = explode('~',$int_duedate[4]); $int_duedate9 = explode('~',$int_duedate[5]); $int_duedate10 = explode('~',$int_duedate[6]); $int_duedate11 = explode('~',$int_duedate[7]); $int_duedate12 = explode('~',$int_duedate[8]);
            //ato due date
            $ato_duedate = explode(',',$tsk_row['ato_due_date']);
            $ato_duedate1 = explode('~',$ato_duedate[0]); $ato_duedate2 = explode('~',$ato_duedate[1]); $ato_duedate3 = explode('~',$ato_duedate[2]); $ato_duedate4 = explode('~',$ato_duedate[3]); $ato_duedate5 = explode('~',$ato_duedate[4]); $ato_duedate7 = explode('~',$ato_duedate[5]); $ato_duedate8 = explode('~',$ato_duedate[6]); $ato_duedate9 = explode('~',$ato_duedate[7]); $ato_duedate10 = explode('~',$ato_duedate[8]); $ato_duedate11 = explode('~',$ato_duedate[9]); $ato_duedate12 = explode('~',$ato_duedate[10]);
            //one off
            $oneoff = explode(',',$tsk_row['one_off']);
            $oneoff1 = explode('~',$oneoff[0]); $oneoff2 = explode('~',$oneoff[1]); $oneoff3 = explode('~',$oneoff[2]); $oneoff4 = explode('~',$oneoff[3]); $oneoff5 = explode('~',$oneoff[4]); $oneoff7 = explode('~',$oneoff[5]); $oneoff8 = explode('~',$oneoff[6]); $oneoff9 = explode('~',$oneoff[7]); $oneoff10 = explode('~',$oneoff[8]); $oneoff11 = explode('~',$oneoff[9]); $oneoff12 = explode('~',$oneoff[10]);
            //monthly
            $monthly = explode(',',$tsk_row['monthly']);
            $monthly1 = explode('~',$monthly[0]); $monthly2 = explode('~',$monthly[1]); $monthly3 = explode('~',$monthly[2]); $monthly4 = explode('~',$monthly[3]); $monthly5 = explode('~',$monthly[4]); $monthly7 = explode('~',$monthly[5]); $monthly8 = explode('~',$monthly[6]); $monthly9 = explode('~',$monthly[7]); $monthly10 = explode('~',$monthly[8]); $monthly11 = explode('~',$monthly[9]); $monthly12 = explode('~',$monthly[10]);
            //quarterly
            $quarterly = explode(',',$tsk_row['quarterly']);
            $quarterly1 = explode('~',$quarterly[0]); $quarterly2 = explode('~',$quarterly[1]); $quarterly3 = explode('~',$quarterly[2]); $quarterly4 = explode('~',$quarterly[3]); $quarterly5 = explode('~',$quarterly[4]); $quarterly7 = explode('~',$quarterly[5]); $quarterly8 = explode('~',$quarterly[6]); $quarterly9 = explode('~',$quarterly[7]); $quarterly10 = explode('~',$quarterly[8]); $quarterly11 = explode('~',$quarterly[9]); $quarterly12 = explode('~',$quarterly[10]);
            //yearly
            $yearly = explode(',',$tsk_row['yearly']);
            $yearly2 = explode('~',$yearly[0]); $yearly3 = explode('~',$yearly[1]); $yearly4 = explode('~',$yearly[2]); $yearly5 = explode('~',$yearly[3]); $yearly7 = explode('~',$yearly[4]); $yearly8 = explode('~',$yearly[5]); $yearly9 = explode('~',$yearly[6]); $yearly10 = explode('~',$yearly[7]); $yearly11 = explode('~',$yearly[8]); $yearly12 = explode('~',$yearly[9]);
            //must
            $must = explode(',',$tsk_row['must']);
            $must2 = explode('~',$must[0]); $must3 = explode('~',$must[1]); $must4 = explode('~',$must[2]); $must5 = explode('~',$must[3]); $must7 = explode('~',$must[4]); $must8 = explode('~',$must[5]); $must9 = explode('~',$must[6]); $must10 = explode('~',$must[7]); $must11 = explode('~',$must[8]); $must12 = explode('~',$must[9]);
            //comments
            $comment = explode(',',$tsk_row['comment']);
            $comment1 = explode('~',$comment[0]); $comment2 = explode('~',$comment[1]); $comment3 = explode('~',$comment[2]); $comment4 = explode('~',$comment[3]); $comment5 = explode('~',$comment[4]); $comment7 = explode('~',$comment[5]); $comment8 = explode('~',$comment[6]); $comment9 = explode('~',$comment[7]); $comment10 = explode('~',$comment[8]); $comment11 = explode('~',$comment[9]); $comment12 = explode('~',$comment[10]);
             
                      $duedate ->setCellValue('A1',$company)
                        ->setCellValue('G1',"Report Generated at".date('d-M-y'))
                        ->setCellValue('C5','Master Activity')
                        ->setCellValue('D5','Sub Activity / Notes')
                        ->setCellValue('E5','Befree Internal Due Date')
                        ->setCellValue('F5','ATO Due Date')
                        ->setCellValue('G5','One off')
                        ->setCellValue('H5','Monthly')
                        ->setCellValue('I5','Quarterly')
                        ->setCellValue('J5','Yearly')
                        ->setCellValue('K5','Must')
                        ->setCellValue('L5','Comment')      
                
                              ->setCellValue('C6', "Preparation of SMSF Accounts")
                              ->setCellValue('D6', "Create Tasks for next year")
                              ->setCellValue('E6', "15th June (every year)")
                              ->setCellValue('F6', stripslashes($ato_duedate1[1]))
                              ->setCellValue('G6', stripslashes($oneoff1[1]))
                              ->setCellValue('H6', stripslashes($monthly1[1]))
                              ->setCellValue('I6', stripslashes($quarterly1[1]))
                              ->setCellValue('J6', "Yearly")
                              ->setCellValue('K6', "Must")
                              ->setCellValue('L6', stripslashes($comment1[1]))
                              
                              ->setCellValue('C7', "Bank Processing")
                              ->setCellValue('D7', "Processing SMSF Banks")
                              ->setCellValue('E7', "5th of next month")
                              ->setCellValue('F7', stripslashes($ato_duedate2[1]))
                              ->setCellValue('G7', stripslashes($oneoff2[1]))
                              ->setCellValue('H7', stripslashes($monthly2[1]))
                              ->setCellValue('I7', stripslashes($quarterly2[1]))
                              ->setCellValue('J7', stripslashes($yearly2[1]))
                              ->setCellValue('K7', stripslashes($must2[1]))
                              ->setCellValue('L7', stripslashes($comment2[1]))
                              
                              ->setCellValue('C8', "GST - SMSF Clients")
                              ->setCellValue('D8', "BAS")
                              ->setCellValue('E8', stripslashes($int_duedate3[1]))
                              ->setCellValue('F8', stripslashes($ato_duedate3[1]))
                              ->setCellValue('G8', stripslashes($oneoff3[1]))
                              ->setCellValue('H8', stripslashes($monthly3[1]))
                              ->setCellValue('I8', stripslashes($quarterly3[1]))
                              ->setCellValue('J8', stripslashes($yearly3[1]))
                              ->setCellValue('K8', stripslashes($must3[1]))
                              ->setCellValue('L8', stripslashes($comment3[1]))
                              
                              ->setCellValue('C9', "")
                              ->setCellValue('D9', "IAS")
                              ->setCellValue('E9', stripslashes($int_duedate4[1]))
                              ->setCellValue('F9', stripslashes($ato_duedate4[1]))
                              ->setCellValue('G9', stripslashes($oneoff4[1]))
                              ->setCellValue('H9', stripslashes($monthly4[1]))
                              ->setCellValue('I9', stripslashes($quarterly4[1]))
                              ->setCellValue('J9', stripslashes($yearly4[1]))
                              ->setCellValue('K9', stripslashes($must4[1]))
                              ->setCellValue('L9', stripslashes($comment4[1]))
                              
                              ->setCellValue('C10', "SMSF Tax Return")
                              ->setCellValue('D10', "Preparation of Tax return")
                              ->setCellValue('E10', stripslashes($int_duedate5[1]))
                              ->setCellValue('F10', stripslashes($ato_duedate5[1]))
                              ->setCellValue('G10', stripslashes($oneoff5[1]))
                              ->setCellValue('H10', stripslashes($monthly5[1]))
                              ->setCellValue('I10', stripslashes($quarterly5[1]))
                              ->setCellValue('J10', stripslashes($yearly5[1]))
                              ->setCellValue('K10', stripslashes($must5[1]))
                              ->setCellValue('L10', stripslashes($comment5[1]))
                              
                              ->setCellValue('C11', "")
                              ->setCellValue('D11', "")
                              ->setCellValue('E11', "")
                              ->setCellValue('F11', "")
                              ->setCellValue('G11', "")
                              ->setCellValue('H11', "")
                              ->setCellValue('I11', "")
                              ->setCellValue('J11', "")
                              ->setCellValue('K11', "")
                              ->setCellValue('L11', "")
                              
                              ->setCellValue('C12', "Misc Tasks")
                              ->setCellValue('D12', "")
                              
                              ->setCellValue('C13', "Backlog")
                              ->setCellValue('D13', "Create tasks for all agreed work we have to do for backlog")
                              ->setCellValue('E13', stripslashes($int_duedate7[1]))
                              ->setCellValue('F13', stripslashes($ato_duedate7[1]))
                              ->setCellValue('G13', stripslashes($oneoff7[1]))
                              ->setCellValue('H13', stripslashes($monthly7[1]))
                              ->setCellValue('I13', stripslashes($quarterly7[1]))
                              ->setCellValue('J13', stripslashes($yearly7[1]))
                              ->setCellValue('K13', stripslashes($must7[1]))
                              ->setCellValue('L13', stripslashes($comment7[1]))
                              
                              ->setCellValue('C14', "2")
                              ->setCellValue('D14', stripslashes($sub_activity8[1]))
                              ->setCellValue('E14', stripslashes($int_duedate8[1]))
                              ->setCellValue('F14', stripslashes($ato_duedate8[1]))
                              ->setCellValue('G14', stripslashes($oneoff8[1]))
                              ->setCellValue('H14', stripslashes($monthly8[1]))
                              ->setCellValue('I14', stripslashes($quarterly8[1]))
                              ->setCellValue('J14', stripslashes($yearly8[1]))
                              ->setCellValue('K14', stripslashes($must8[1]))
                              ->setCellValue('L14', stripslashes($comment8[1]))
                              
                              ->setCellValue('C15', "3")
                              ->setCellValue('D15', stripslashes($sub_activity9[1]))
                              ->setCellValue('E15', stripslashes($int_duedate9[1]))
                              ->setCellValue('F15', stripslashes($ato_duedate9[1]))
                              ->setCellValue('G15', stripslashes($oneoff9[1]))
                              ->setCellValue('H15', stripslashes($monthly9[1]))
                              ->setCellValue('I15', stripslashes($quarterly9[1]))
                              ->setCellValue('J15', stripslashes($yearly9[1]))
                              ->setCellValue('K15', stripslashes($must9[1]))
                              ->setCellValue('L15', stripslashes($comment9[1]))
                              
                              ->setCellValue('C16', "4")
                              ->setCellValue('D16', stripslashes($sub_activity10[1]))
                              ->setCellValue('E16', stripslashes($int_duedate10[1]))
                              ->setCellValue('F16', stripslashes($ato_duedate10[1]))
                              ->setCellValue('G16', stripslashes($oneoff10[1]))
                              ->setCellValue('H16', stripslashes($monthly10[1]))
                              ->setCellValue('I16', stripslashes($quarterly10[1]))
                              ->setCellValue('J16', stripslashes($yearly10[1]))
                              ->setCellValue('K16', stripslashes($must10[1]))
                              ->setCellValue('L16', stripslashes($comment10[1]))
                              
                              ->setCellValue('C17', "5")
                              ->setCellValue('D17', stripslashes($sub_activity11[1]))
                              ->setCellValue('E17', stripslashes($int_duedate11[1]))
                              ->setCellValue('F17', stripslashes($ato_duedate11[1]))
                              ->setCellValue('G17', stripslashes($oneoff11[1]))
                              ->setCellValue('H17', stripslashes($monthly11[1]))
                              ->setCellValue('I17', stripslashes($quarterly11[1]))
                              ->setCellValue('J17', stripslashes($yearly11[1]))
                              ->setCellValue('K17', stripslashes($must11[1]))
                              ->setCellValue('L17', stripslashes($comment11[1]))
                              
                              ->setCellValue('C18', "6")
                              ->setCellValue('D18', stripslashes($sub_activity12[1]))
                              ->setCellValue('E18', stripslashes($int_duedate12[1]))
                              ->setCellValue('F18', stripslashes($ato_duedate12[1]))
                              ->setCellValue('G18', stripslashes($oneoff12[1]))
                              ->setCellValue('H18', stripslashes($monthly12[1]))
                              ->setCellValue('I18', stripslashes($quarterly12[1]))
                              ->setCellValue('J18', stripslashes($yearly12[1]))
                              ->setCellValue('K18', stripslashes($must12[1]))
                              ->setCellValue('L18', stripslashes($comment12[1]))
                              
                        ->setCellValue('C20', "Notes")
                        ->setCellValue('D20', stripslashes($tsk_row['tsk_notes']))
                        ->setCellValue('C21', "India Notes")
                        ->setCellValue('D21', stripslashes($tsk_row['tsk_india_notes']));
        }



// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


$filename  = "perminfo_".strtotime("now").".xls";
$path = "excel_file/".$filename;
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save($path);

echo '<script>window.open ("excel_open.php?filename='.$filename.'","mywindow","menubar=1,resizable=1,width=350,height=250"); </script>';


?>