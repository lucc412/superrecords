<?php
include("include/common.php");
include(MODEL."audit_subchecklist_class.php");
$objScr = new AuditSubchecklist();

$sql = $_REQUEST['sql'];
switch ($sql)
{
	case "insertAudit":
		foreach($_POST AS $postName => $postVal) {
			$flagStatus = strstr($postName, "rdUplStatus");
			if($flagStatus) {
				$arrSubForm[replaceString('rdUplStatus', '', $postName)]['status'] = $postVal;  
			}

			$flagNotes = strstr($postName, "taNotes");
			if($flagNotes) {
				$arrSubForm[replaceString('taNotes', '', $postName)]['notes'] = $postVal;  
			}
		}

		foreach($arrSubForm AS $subChecklistId => $checklistInfo) {
			$strInsert .= "(".$_SESSION['jobId'].",".$subChecklistId.",'".$checklistInfo['status']."','".$checklistInfo['notes']."'),";
		}
		$strInsert = stringrtrim($strInsert, ",");
                
		$objScr->add_audit_details($strInsert);
		if($_REQUEST['button'] == 'Save') {
                    if(isset($_SESSION['jobId'])) unset($_SESSION['jobId']);
                    header('location: jobs_saved.php');
		}
		else {
                    $objScr->update_job_completed($_SESSION['jobId']);
                    add_new_task('11');
                    new_job_task_mail();
                    if(isset($_SESSION['jobId'])) unset($_SESSION['jobId']);
                    header('location: jobs_pending.php');
		}
		break;

	case "updateAudit":
		foreach($_POST AS $postName => $postVal) {
			$flagStatus = strstr($postName, "rdUplStatus");
			if($flagStatus) {
				$arrSubForm[replaceString('rdUplStatus', '', $postName)]['status'] = $postVal;  
			}

			$flagNotes = strstr($postName, "taNotes");
			if($flagNotes) {
				$arrSubForm[replaceString('taNotes', '', $postName)]['notes'] = $postVal;  
			}
		}
		$objScr->edit_audit_details($arrSubForm, $_SESSION['jobId']);
		if($_REQUEST['button'] == 'Save') {
                        if(isset($_SESSION['jobId'])) unset($_SESSION['jobId']);
			header('location: jobs_saved.php');
		}
		else {
			$objScr->update_job_completed($_SESSION['jobId']);
			add_new_task('11'); //Removed Practice Session & Job Session // 11 is JobType For Audit Only
			new_job_task_mail();
                        if(isset($_SESSION['jobId'])) unset($_SESSION['jobId']);
			header('location: jobs_pending.php');
		}
		break;
                
	case "dwnldchcklst":
		$objScr->sql_download_checklist($_SESSION['jobId']);
		break;

	case "uploadSubAuditDocs":
		$objScr->add_audit_Docs($_SESSION['jobId'],$_REQUEST['checklistId'],$_REQUEST['subchecklistId']);
		echo "<script>
			opener.parent.location.href = 'audit_subchecklist.php?checklistId=".$_REQUEST['checklistId']."';
			self.close();
		</script>";
		break;
}

$a = $_REQUEST['a'];
switch ($a) {
            
        default :
                $arrSubchecklist = $objScr->getAuditSubChecklist($_SESSION['jobId']);
		$arrDocDetails = $objScr->getAuditDetails($_SESSION['jobId']);
		$arrSubDocList = $objScr->getAuditSubDocList($_SESSION['jobId']);
		$arrUplStatus['PENDING'] = 'Pending';
		$arrUplStatus['ATTACHED'] = 'Attached';
		$arrUplStatus['NA'] = 'N/A';
		include(VIEW.'audit_subchecklist.php');
		break;
}
?>