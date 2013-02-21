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
$defees = $objPHPExcel->getActiveSheet()->setTitle('Email Options');
$objPHPExcel->setActiveSheetIndex(0);
              
// Default fees details
            // $defees  = $objPHPExcel->createSheet();
          //   $defees ->setTitle('Email Options');
             $defees ->getColumnDimension('C')->setWidth(10);
             $defees ->getColumnDimension('D')->setWidth(50);
             $defees ->getColumnDimension('E')->setWidth(50);
             $defees ->getColumnDimension('F')->setWidth(50);
             $defees ->getColumnDimension('G')->setWidth(50);
             $defees ->getColumnDimension('H')->setWidth(50);
             $defees ->getRowDimension('5')->setRowHeight(20);
             $defees ->getDefaultStyle()->getFont()->setName('Arial');
             $defees ->getDefaultStyle()->getFont()->setSize(10);
             $defees ->getStyle('C5:H5')->getFont()->setBold(true);
             $defees ->getStyle('D1')->getFont()->setBold(true);
             $defees ->getStyle('C5:H5')->getFont()->setSize(11);
             $defees ->getStyle('C5:H5')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
             $defees ->getStyle('C5:H5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
             $defees ->getStyle('C5:H5')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
             $defees ->getStyle('C5:H5')->getFill()->getStartColor()->setARGB('0a58720a5872');
             $defees ->getStyle('C5:H5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
             $defees ->getStyle('C5:H5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
             $defees ->getStyle('C5:H5')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
             $defees ->getStyle('C5:H5')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
             
                      $defees  ->setCellValue('E1',"Report Generated at".date('d-M-y'))
                        ->setCellValue('D1','Email Options')
                        ->setCellValue('C5','SNo')
                        ->setCellValue('D5','Name')
                        ->setCellValue('E5','Event when email will be sent automatically')
                        ->setCellValue('F5','Email Address')
                        ->setCellValue('G5','Email Address / Description')
                        ->setCellValue('H5','Content of the Email');
           //get task query
                $details_query = "SELECT * FROM email_options order by email_order";
                $details_result=mysql_query($details_query);
                $c=1;
                $row=6;
                while($task_data = mysql_fetch_array($details_result))
                {
                        $flag = false;
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
                    $defees->setCellValue("C".$r, $c);
                    $defees->setCellValue("D".$r, $task_data['email_shortname']);
                    $defees->setCellValue("E".$r, $task_data['email_name']);
                    $defees->setCellValue("F".$r, $task_data['email_value']);
                    $defees->setCellValue("G".$r, $task_data['email_comments']);
                    $defees->setCellValue("H".$r, html_entity_decode($task_data['email_content']));
                $c++;
                }
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
$filename  = "email_option_".strtotime("now").".xls";
$path = "excel_file/".$filename;
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save($path);
echo '<script>window.open ("excel_open.php?filename='.$filename.'","mywindow","menubar=1,resizable=1,width=350,height=250"); </script>';


?>