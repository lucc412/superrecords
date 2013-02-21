<?php
session_start();
include("common/class.Database.php");
$conn = new Database();
 
    $stfid =  $_POST['stfcode'];
    $code =  $_POST['subject'];
    $query = "SELECT csr_Code,csr_Title,csr_Fields,csr_Conditions,csr_Values,csr_OutputFields FROM csr_customsalesreportsave WHERE csr_Code=".$code." AND csr_SCode=".$stfid;
    $result = mysql_query($query);
    $savequery = @mysql_fetch_array($result);
    $csroutput = $savequery['csr_OutputFields'];
    $csrconditions = $savequery['csr_Conditions'];
    $csrfields = $savequery['csr_Fields'];
    $csrvalues = $savequery['csr_Values'];
    $csrtitle = $savequery['csr_Title'];
    $csrauto = $savequery['csr_Code'];
  //  $csroutput = explode(",", $csroutput);
   // $csrconditions = explode(",", $csrconditions);
   // $csrfields = explode(",", $csrfields);
   // $csrvalues = explode(",", $csrvalues);
    $content = "";
  /*  for($i=1; $i<count($csrfields); $i++)
    {
        $csrfields1 .= $csrfields[$i];
        $csrconditions1 .= $csrconditions[$i];
        $csrvalues1 .= $csrvalues[$i];
        $csroutput1 .= $csroutput[$i];
        $count .= $i;
    }
    */
    $content .= $csrfields;
    $content .= "~~".$csrconditions;
    $content .= "~~".$csrvalues;
    $content .= "~~".$csroutput;
    $content .= "~~".$csrtitle;
    $content .= "~~".$csrauto;

    echo $content;
  
?>