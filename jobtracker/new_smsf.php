<?php
// include common file
include("include/common.php");

if(isset($_SESSION["jobId"]))
{
    $selQry="SELECT apply_abntfn, authority_status FROM es_smsf WHERE job_id = ".$_SESSION["jobId"];
    $fetchResult = mysql_query($selQry);
    $arrSMSF = mysql_fetch_assoc($fetchResult);
}

if(isset($_REQUEST) && $_REQUEST['do'] == 'redirect')
{
    if(isset($_SESSION["jobId"])) {
		if(!empty($_REQUEST['cbApply'])) {
			$updQry = "UPDATE es_smsf SET apply_abntfn = 1";
			mysql_query($updQry);
		}
		else {
			$updQry = "UPDATE es_smsf SET apply_abntfn = 0";
			mysql_query($updQry);
		}
		header('Location:jobs.php?sql=update&type=SETUP&subfrmId=1');
	}
	else {
		header('Location:jobs.php?sql=insertJob&type=SETUP&subfrmId=1&cbApply='.$_REQUEST['cbApply']);
	}
}

// include view file 
include(VIEW . "new_smsf.php");
?>