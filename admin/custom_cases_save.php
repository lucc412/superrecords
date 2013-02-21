<?php
session_start();
include("common/class.Database.php");
$conn = new Database();
 
    $stfid =  $_POST['stfcode'];
    $code =  $_POST['subject'];
    $query = "SELECT cas_Code,cas_Title,cas_Fields,cas_Conditions,cas_Values,cas_OutputFields FROM cas_customcasesreportsave WHERE cas_Code=".$code." AND cas_CCode=".$stfid;
    $result = mysql_query($query);
    $savequery = @mysql_fetch_array($result);
    $csroutput = $savequery['cas_OutputFields'];
    $csrconditions = $savequery['cas_Conditions'];
    $csrfields = $savequery['cas_Fields'];
    $csrvalues = $savequery['cas_Values'];
    $csrtitle = $savequery['cas_Title'];
    $csrauto = $savequery['cas_Code'];
    $content = "";
    $content .= $csrfields;
    $content .= "~~".$csrconditions;
    $content .= "~~".$csrvalues;
    $content .= "~~".$csroutput;
    $content .= "~~".$csrtitle;
    $content .= "~~".$csrauto;

    echo $content;
  
?>