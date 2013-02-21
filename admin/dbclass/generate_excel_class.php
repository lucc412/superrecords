<?php
ob_start();
session_start();
include("../common/class.Database.php");
$dbconnect = new Database();
if($_SESSION['Submit']=="Generate Excel Report")
{

    $sql=$_SESSION['query'];
    $result = mysql_query($sql);
    $count = mysql_num_fields($result);
    if($_GET['report']=="worksheet")
    $count=13;
    if($_GET['report']=="timesheet")
    $count=11;
    if($_GET['report']=="client")
    $count=7;
    if($_GET['report']=="subactivity")
    $count=4;

    for ($i = 0; $i < $count; $i++){
        $header .= mysql_field_name($result, $i)."\t";
    }
    while($row = mysql_fetch_row($result)){
      $line = '';
      foreach($row as $key=>$value)
      {
      if($_GET['report']=="worksheet")
      {
              if($key<13)
              {
                    if(!isset($value) || $value == "")
                    {
                      $value = "\t";
                    }
                    else{
            # important to escape any quotes to preserve them in the data.
                      $value = str_replace('"', '""', $value);
            # needed to encapsulate data in quotes because some data might be multi line.
            # the good news is that numbers remain numbers in Excel even though quoted.
                      $value = '"' . $value . '"' . "\t";
                    }
                    $line .= $value;
               }
       }
      if($_GET['report']=="timesheet")
      {
              if($key<11)
              {
                    if(!isset($value) || $value == "")
                    {
                      $value = "\t";
                    }
                    else{
            # important to escape any quotes to preserve them in the data.
                      $value = str_replace('"', '""', $value);
            # needed to encapsulate data in quotes because some data might be multi line.
            # the good news is that numbers remain numbers in Excel even though quoted.
                      $value = '"' . $value . '"' . "\t";
                    }
                    $line .= $value;
               }
       }
      if($_GET['report']=="client")
      {
              if($key<7)
              {
                    if(!isset($value) || $value == "")
                    {
                      $value = "\t";
                    }
                    else{
            # important to escape any quotes to preserve them in the data.
                      $value = str_replace('"', '""', $value);
            # needed to encapsulate data in quotes because some data might be multi line.
            # the good news is that numbers remain numbers in Excel even though quoted.
                      $value = '"' . $value . '"' . "\t";
                    }
                    $line .= $value;
               }
       }
      if($_GET['report']=="subactivity")
      {
              if($key<4)
              {
                    if(!isset($value) || $value == "")
                    {
                      $value = "-\t";
                    }
                    else{
            # important to escape any quotes to preserve them in the data.
                      $value = str_replace('"', '""', $value);
            # needed to encapsulate data in quotes because some data might be multi line.
            # the good news is that numbers remain numbers in Excel even though quoted.
                      $value = '"' . $value . '"' . "\t";
                    }
                    $line .= $value;
               }
       }

      }//end of foreach
      $data .= trim($line)."\n";
    }
    ////end of while loop
    # this line is needed because returns embedded in the data have "\r"
    # and this looks like a "box character" in Excel
      $data = str_replace("\r", "", $data);
    # Nice to let someone know that the search came up empty.
    # Otherwise only the column name headers will be output to Excel.
    if ($data == "") {
      $data = "\nno matching records found\n";
    }
     if($_GET['report']=="timesheet")
    $filename="Report-Timesheet-".date("d-m-Y");
    if($_GET['report']=="worksheet")
    $filename="Report-Worksheet-".date("d-m-Y");
    if($_GET['report']=="client")
    $filename="Report-Client-".date("d-m-Y");
    if($_GET['report']=="subactivity")
    $filename="Sub Activity-".date('d-m-Y');

    # This line will stream the file to the user rather than spray it across the screen
    //header("Content-type: application/octet-stream");
    header('Content-Type: application/vnd.ms-excel;');                 // This should work for IE & Opera
    header("Content-type: application/x-msexcel");                    // This should work for the rest
    # replace excelfile.xls with whatever you want the filename to default to
    header("Content-Disposition: attachment; filename=$filename.xls");
    header("Pragma: no-cache");
    header("Expires: 0");

    echo $header."\n".$data;
    }
 ?> 
