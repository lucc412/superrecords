<?php
include("include/common.php");
include(MODEL."compliance_class.php");
$objScr = new COMPLIANCE();
	
$sql = $_REQUEST['sql'];
switch ($sql)
{
    case "insertJob":		
            $jobId = $objScr->sql_insert();
            
            new_job_task_mail();
            if(isset($_SESSION['jobId'])) unset($_SESSION['jobId']);
            header('location: jobs_pending.php');
            break;
}

$a = $_REQUEST['a'];
switch ($a) {
    case "duplicateJob":
            $arrObj = $objScr->sql_select('duplicate');

            if(count($arrObj) != 0)
            {
                    print_r($arrObj);
                    return $arrObj;
            }  
            else 
            {
                    return false;
            }
            exit;
            break;

    default :
            $arrClientType = $objScr->fetchClientType();
            include(VIEW.'compliance.php');
            break;
}
?>