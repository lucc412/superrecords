<?php
session_start();
include("common/class.Database.php");
$conn = new Database();
 
    $stfid =  $_POST['stfcode'];
    $code =  $_POST['subject'];
    $query = "SELECT cso_Code,cso_Title,cso_Fields,cso_Conditions,cso_Values,cso_OutputFields FROM cso_salesopportunityreport WHERE cso_Code=".$code." AND cso_SCode=".$stfid;
    $result = mysql_query($query);
    $savequery = @mysql_fetch_array($result);
    $csroutput = $savequery['cso_OutputFields'];
    $csrconditions = $savequery['cso_Conditions'];
    $csrfields = $savequery['cso_Fields'];
    $csrvalues = $savequery['cso_Values'];
    $csrtitle = $savequery['cso_Title'];
    $csrauto = $savequery['cso_Code'];
    $content = "";
    $content .= $csrfields;
    $content .= "~~".$csrconditions;
    $content .= "~~".$csrvalues;
    $content .= "~~".$csroutput;
    $content .= "~~".$csrtitle;
    $content .= "~~".$csrauto;

    echo $content;
  
?>