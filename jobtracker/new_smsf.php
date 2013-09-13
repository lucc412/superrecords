<?php

// include common file
include("include/common.php");

if(isset($_SESSION["jobId"]))
{
    $selQry="SELECT * FROM es_smsf WHERE job_id = ".$_SESSION["jobId"]." AND smsf_type = 1";
    $fetchResult = mysql_query($selQry);
    
    while($rowData = mysql_fetch_assoc($fetchResult)) 
    {
        $arrSMSF[$rowData['job_id']] = $rowData;
    }
    
}

if(isset($_REQUEST) && $_REQUEST['do'] == 'redirect')
{
    $sql='';
    $flag ='';
    if(isset($_SESSION["jobId"]))
    {
        $sql = "update"; 
        if($arrSMSF[$_SESSION["jobId"]]['authority_status']==1)$flag=TRUE;
    }
    else
    {
        $sql = "insertJob"; 
        $Qry = "INSERT INTO es_smsf (authority_status,smsf_type) VALUES (".$_REQUEST['cbAuthority'].",'".$_REQUEST['smsf_type']."')";
        $flag = mysql_query($Qry);
    }
    
    if($flag)
        header('Location:jobs.php?sql='.$sql.'&type=SETUP&subfrmId=1');
}

// include view file 
include(VIEW . "new_smsf.php");

?>