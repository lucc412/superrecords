<?php
session_start();
include("common/class.Database.php");
$conn = new Database();
 
    $stfid =  $_POST['stfcode'];
    $code =  $_POST['subject'];
    $query = "SELECT cwr_Code,cwr_Title,cwr_Fields,cwr_Conditions,cwr_Values,cwr_OutputFields FROM cwr_customwrkreportsave WHERE cwr_Code=".$code." AND cwr_SCode=".$stfid;
    $result = mysql_query($query);
    $savequery = @mysql_fetch_array($result);
    $csroutput = $savequery['cwr_OutputFields'];
    $csrconditions = $savequery['cwr_Conditions'];
    $csrfields = $savequery['cwr_Fields'];
    $csrvalues = $savequery['cwr_Values'];
    $csrtitle = $savequery['cwr_Title'];
    $csrauto = $savequery['cwr_Code'];
    $content = "";
    $content .= $csrfields;
    $content .= "~~".$csrconditions;
    $content .= "~~".$csrvalues;
    $content .= "~~".$csroutput;
    $content .= "~~".$csrtitle;
    $content .= "~~".$csrauto;

    echo $content;
  
?>