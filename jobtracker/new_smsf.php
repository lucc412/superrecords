<?php

// include common file
include("include/common.php");

if(isset($_SESSION["jobId"]))
{
    $selQry="SELECT * FROM es_smsf WHERE job_id = ".$_SESSION["jobId"];
    $fetchResult = mysql_query($selQry);
    
    while($rowData = mysql_fetch_assoc($fetchResult)) 
    {
        $arrSMSF[$rowData['job_id']] = $rowData;
    }
    
}

if(isset($_REQUEST) && $_REQUEST['do'] == 'redirect')
{
    $sql='';
    if(isset($_SESSION["jobId"]))
    {
        $sql = "update"; 
        if($arrSMSF[$_SESSION["jobId"]]['authority_status']==1)$flag=TRUE;
    }
    else
    {
        $sql = "insertJob"; 
    }
    
    header('Location:jobs.php?sql='.$sql.'&type=SETUP&subfrmId=1');
}

// include view file 
include(VIEW . "new_smsf.php");

?>