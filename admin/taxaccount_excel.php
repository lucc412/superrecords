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
              
            $formcode=$commonUses->getFormCode("Tax & Accounting");
                //Call CheckAccess function by passing $_SESSION of staff code and form code
            $access_file_level_taxaccount=$commonUses->checkFileAccess($_SESSION['staffcode'],$formcode);

//card file info
//header
$cli_code=$_REQUEST['cli_code'];
$cli_query = "SELECT name FROM jos_users WHERE cli_Code=".$cli_code;
$st_query = mysql_query($cli_query);
$clientName = mysql_fetch_array($st_query);
$company = $clientName['name'];
//TAXACCOUNT details
	if(($access_file_level_taxaccount['stf_Add']=="Y" || $access_file_level_taxaccount['stf_View']=="Y" || $access_file_level_taxaccount['stf_Edit']=="Y" || $access_file_level_taxaccount['stf_Delete']=="Y"))
	{
             $tax  = $objPHPExcel->getActiveSheet()->setTitle('Tax & Accounting');
             $tax ->getColumnDimension('C')->setAutoSize(true);
             $tax ->getColumnDimension('D')->setAutoSize(true);
             $tax ->getRowDimension('5')->setRowHeight(20);
             $tax ->getDefaultStyle()->getFont()->setName('Arial');
             $tax ->getDefaultStyle()->getFont()->setSize(10);
             $tax ->getStyle('C5:D5')->getFont()->setBold(true);
             $tax ->getStyle('C5:D5')->getFont()->setSize(11);
             $tax ->getStyle('C5:D5')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
             $tax ->getStyle('C5:D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
             $tax ->getStyle('C5:D5')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
             $tax ->getStyle('C5:D5')->getFill()->getStartColor()->setARGB('0a58720a5872');
             $tax ->getStyle('C5:D5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
             $tax ->getStyle('C5:D5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
             $tax ->getStyle('C5:D5')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
             $tax ->getStyle('C5:D5')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

                      $tax ->setCellValue('A1',$company)
                        ->setCellValue('G1',"Report Generated at".date('d-M-y'))
                        ->setCellValue('C5','Task Description')
                        ->setCellValue('D5','');
           //get task query
                $cli_code=$_REQUEST['cli_code'];
                $query = "SELECT * FROM tax_taxaccounting where tax_ClientCode =".$cli_code;
                $result=@mysql_query($query);
                $row_inv = mysql_fetch_assoc($result);
                $tax_Code=@mysql_result( $result,0,'tax_Code') ;
                $details_query = "SELECT * FROM tax_taxaccountingdetails where tax_TAXCode =".$tax_Code." order by tax_Code";
                $details_result=@mysql_query($details_query);
                $c=0;
                $row=6;
                while($task_data = mysql_fetch_array($details_result))
                {
                        $flag = false;
                    if($c==0) { $tax ->getStyle('C6')->getFont()->setBold(true); $tax->getStyle('C6')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE); $tax->setCellValue("C".$row,'Tax & Accounting'); $flag = true; }
                    $taskContent = $commonUses->getTaskDescription(htmlspecialchars($task_data["tax_TaskCode"]));
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
                    $tax->setCellValue("C".$r, $taskContent);
                    $tax->setCellValue("D".$r, $task_data["tax_TaskValue"]);
            $c++;
                }
                        $query = "SELECT i1.tax_Code,i2.tax_Notes,i2.tax_IndiaNotes FROM tax_taxaccounting AS i1 LEFT OUTER JOIN tax_taxaccountingdetails AS i2 ON (i1.tax_Code = i2.tax_TAXCode) where tax_ClientCode =".$cli_code;
                        $result=@mysql_query($query);
                        $row_notes = mysql_fetch_array($result);
                        $tax->setCellValue('C15', "Notes");
                        $tax->setCellValue('D15', $row_notes['tax_Notes']);
                        $tax->setCellValue('C16', "India Notes");
                        $tax->setCellValue('D16', $row_notes['tax_IndiaNotes']);
        }

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

$filename  = "taxAccount_".strtotime("now").".xls";
$path = "excel_file/".$filename;
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save($path);
echo '<script>window.open ("excel_open.php?filename='.$filename.'","mywindow","menubar=1,resizable=1,width=350,height=250"); </script>';

?>