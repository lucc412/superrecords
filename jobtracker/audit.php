<?php
include("include/common.php");
include(MODEL."audit_class.php");
$objScr = new Audit();

$sql = $_REQUEST['sql'];
switch ($sql)
{
	case "insertJob":		
		$jobId = $objScr->sql_insert();
		if(isset($_SESSION['jobId'])) unset($_SESSION['jobId']);
		$_SESSION['jobId'] = $jobId;	
                
                header('location: audit_checklist.php');
		break;

	case "update":			
                $objScr->sql_update();
                header('location: audit_checklist.php');
		break;
}


$a = $_REQUEST['a'];
switch ($a) {
        default :
                if(isset($_REQUEST['recid']) && !empty($_REQUEST['recid'])) {
			if(isset($_SESSION['jobId'])) unset($_SESSION['jobId']);
			$_SESSION['jobId'] = $_REQUEST['recid'];
		}
                    
		if(isset($_SESSION['jobId']) && !empty($_SESSION['jobId'])) {
			$arrJobInfo = $objScr->fetchJobDetail($_SESSION['jobId']);
                        $dbClientName = $arrJobInfo['client_name'];
                        $dbClientId = $arrJobInfo['client_id'];
                        $dbPeriod = $arrJobInfo['period'];
			$dbNotes = $arrJobInfo['notes'];
		}

		$arrAuditType = $objScr->getAuditCliJobType();
		include(VIEW.'audit.php');
		break;
}
?>