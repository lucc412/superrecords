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
              
            $formcode=$commonUses->getFormCode("Hosting");
                //Call CheckAccess function by passing $_SESSION of staff code and form code
            $access_file_level_host=$commonUses->checkFileAccess($_SESSION['staffcode'],$formcode);

//card file info
//header
$cli_code=$_REQUEST['cli_code'];
$cli_query = "SELECT name FROM jos_users WHERE cli_Code=".$cli_code;
$st_query = mysql_query($cli_query);
$clientName = mysql_fetch_array($st_query);
$company = $clientName['name'];
//Hosting details
	if(($access_file_level_host['stf_Add']=="Y" || $access_file_level_host['stf_View']=="Y" || $access_file_level_host['stf_Edit']=="Y" || $access_file_level_host['stf_Delete']=="Y"))
	{
             $host  = $objPHPExcel->getActiveSheet()->setTitle('Hosting');
             $host ->getColumnDimension('C')->setAutoSize(true);
             $host ->getColumnDimension('D')->setAutoSize(true);
             $host ->getRowDimension('5')->setRowHeight(20);
             $host ->getDefaultStyle()->getFont()->setName('Arial');
             $host ->getDefaultStyle()->getFont()->setSize(10);
             $host ->getStyle('C5:D5')->getFont()->setBold(true);
             $host ->getStyle('C5:D5')->getFont()->setSize(11);
             $host ->getStyle('C5:D5')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
             $host ->getStyle('C5:D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
             $host ->getStyle('C5:D5')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
             $host ->getStyle('C5:D5')->getFill()->getStartColor()->setARGB('0a58720a5872');
             $host ->getStyle('C5:D5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
             $host ->getStyle('C5:D5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
             $host ->getStyle('C5:D5')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
             $host ->getStyle('C5:D5')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

                      $host ->setCellValue('A1',$company)
                        ->setCellValue('G1',"Report Generated at".date('d-M-y'))
                        ->setCellValue('C5','Task List')
                        ->setCellValue('D5','');
           //get task query
                $cli_code=$_REQUEST['cli_code'];
                $query = "SELECT * FROM mhg_qmyobhosting where mhg_ClientCode =".$cli_code;
                $result=@mysql_query($query);
                $row_mhg = mysql_fetch_assoc($result);
                $mhg_Code=@mysql_result( $result,0,'mhg_Code') ;
                $details_query = "SELECT * FROM mhg_qmyobhostingdetails where mhg_MYOBHCode =".$mhg_Code." order by mhg_Code";
                $details_result=@mysql_query($details_query);
                $c=0;
                $row=6;
                while($task_data = mysql_fetch_array($details_result))
                {
                        $flag = false;
                    if($c==0) { $host ->getStyle('C6')->getFont()->setBold(true); $host->getStyle('C6')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE); $host->setCellValue("C".$row,'MYOB Hosting Services'); $flag = true; }
                    if($c==6) { $host ->getStyle('C13')->getFont()->setBold(true); $host->getStyle('C13')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE); $host->setCellValue("C".$row,'Befree ADMIN to complete'); $flag = true; }
                    if($task_data['mhg_TaskValue']=="Y") { $TaskVal = "Yes"; } else { $TaskVal = $task_data['mhg_TaskValue']; }
                    $taskContent = $commonUses->getTaskDescription(htmlspecialchars($task_data["mhg_TaskCode"]));
                    if($taskContent=="<b>Email details</b>") { $taskContent = "Email details"; }
                    if($taskContent=="<b>Printer details</b>") { $taskContent = "Printer details"; }
                    if($taskContent=="<b>Data File Details</b>") { $taskContent = "Data File details"; }
                    
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
                    $host->setCellValue("C".$r, $taskContent);
                    $host->setCellValue("D".$r, $TaskVal);
            $c++;
                }
                        $query = "SELECT i1.mhg_Code,i2.mhg_Notes,i2.mhg_IndiaNotes FROM mhg_qmyobhosting AS i1 LEFT OUTER JOIN mhg_qmyobhostingdetails AS i2 ON (i1.mhg_Code = i2.mhg_MYOBHCode) where mhg_ClientCode =".$cli_code;
                        $result=@mysql_query($query);
                        $row_notes = mysql_fetch_array($result);
                        $host->setCellValue('C24', "Notes");
                        $host->setCellValue('D24', $row_notes['mhg_Notes']);
                        $host->setCellValue('C25', "India Notes");
                        $host->setCellValue('D25', $row_notes['mhg_IndiaNotes']);
        }

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

$filename  = "hosting_".strtotime("now").".xls";
$path = "excel_file/".$filename;
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save($path);
echo '<script>window.open ("excel_open.php?filename='.$filename.'","mywindow","menubar=1,resizable=1,width=350,height=250"); </script>';

?>