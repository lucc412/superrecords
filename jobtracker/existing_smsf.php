<?php

// include common file
include("include/common.php");


if(isset($_SESSION["jobId"]))
{
    $selQry="SELECT apply_abntfn, authority_status FROM es_smsf WHERE job_id = ".$_SESSION["jobId"]." AND smsf_type = 2";
    $fetchResult = mysql_query($selQry);
	$fetchResult = mysql_query($selQry);
    $arrSMSF = mysql_fetch_assoc($fetchResult);
}

if(isset($_REQUEST) && $_REQUEST['do'] == 'redirect')
{
    $sql='';
    if(isset($_SESSION["jobId"]))
    {
        $sql = "update";
    }
    else
    {
        $sql = "insertJob"; 
    }
    
    header('Location:jobs.php?sql='.$sql.'&type=SETUP&subfrmId=2');
}

// include view file 
include(VIEW . "existing_smsf.php");

?>