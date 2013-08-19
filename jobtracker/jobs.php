<?php
include("include/common.php");
include(MODEL."job_class.php");

$objScr = new Job();

$a = $_REQUEST["a"];
$recid = $_REQUEST["recid"];
$sql = $_REQUEST["sql"]?$_REQUEST["sql"]:'';

if($_REQUEST['var'] == 'new')
	unset($_SESSION['jobId']);

switch ($sql)
{
	case "insertJob":
		$jobId = $objScr->sql_insert();

		if(isset($_SESSION['jobId'])) unset($_SESSION['jobId']);
		$_SESSION['jobId'] = $jobId;
		
		/* send mail function starts here for ADD NEW JOB */
		$pageUrl = "jobs.php?sql=insertJob";
		$pageUrl = basename($_SERVER['REQUEST_URI']);	
		
		// check if event is active or inactive [This will return TRUE or FALSE as per result]
		$flagSet = getEventStatus($pageUrl);
		
		// if event is active it go for mail function
		if($flagSet)
		{
			//It will Get All Details in array format for Send Email	
			$arrEmailInfo = get_email_info($pageUrl);

			// fetch email id of sr manager
			$strPanelInfo = sql_select_panel($_SESSION['PRACTICEID']);
			$arrPanelInfo = explode('~', $strPanelInfo);
			$srManagerEmail = $arrPanelInfo[0];
			$inManagerEmail = $arrPanelInfo[2];

			$to = $srManagerEmail. ',' .$inManagerEmail;
			$cc = $arrEmailInfo['event_cc'];
			$subject = $arrEmailInfo['event_subject'];
			$content = $arrEmailInfo['event_content'];
			$content = replaceContent($content, NULL, $_SESSION['PRACTICEID'], NULL, $jobId);

			include_once(MAIL);
			send_mail($to, $cc, $subject, $content);
		}
		/* send mail function ends here */	
			
		/* send mail function starts here for ADD NEW TASK */
		$pageUrl = "job.php?sql=addTask";
		
		// check if event is active or inactive [This will return TRUE or FALSE as per result]
		$flagSet = getEventStatus($pageUrl);
		
		// if event is active it go for mail function
		if($flagSet)
		{
			//It will Get All Details in array format for Send Email	
			$arrEmailInfo = get_email_info($pageUrl);

			// fetch email id of sr manager
			$strPanelInfo = sql_select_panel($_SESSION['PRACTICEID']);
			$arrPanelInfo = explode('~', $strPanelInfo);
			$inManagerEmail = $arrPanelInfo[2];

			$to = $inManagerEmail;
			$cc = $arrEmailInfo['event_cc'];
			$subject = $arrEmailInfo['event_subject'];
			$content = $arrEmailInfo['event_content'];
			$content = replaceContent($content, NULL, $_SESSION['PRACTICEID'], NULL, $jobId);

			include_once(MAIL);
			send_mail($to, $cc, $subject, $content);
		}
		/* send mail function ends here */		
			
		if($_REQUEST['type'] == 'COMPLIANCE')
			header('location: jobs.php?a=pending');
		else if($_REQUEST['type'] == 'AUDIT')
			header('location: jobs.php?a=checklist');

		break;

	case "uploadAuditDocs":
		$objScr->add_audit_Docs($_SESSION['jobId'], $_REQUEST['checklistId']);
		header('location: jobs.php?a=uploadAudit&checklistId='.$_REQUEST['checklistId']);
		break;

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
			header('location: jobs.php?a=saved');
		}
		else {
			$objScr->update_job_completed($_SESSION['jobId']);
			header('location: jobs.php?a=pending');
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
			header('location: jobs.php');
		}
		else {
			$objScr->update_job_completed($_SESSION['jobId']);
			header('location: jobs.php?a=pending');
		}

		break;

	case "update":
		$objScr->sql_update();
		if($_REQUEST['type'] == 'COMPLIANCE')
			header('location: jobs.php?a=pending');
		else if($_REQUEST['type'] == 'AUDIT')
			header('location: jobs.php?a=checklist');
		break;

	case "delete":
		$objScr->sql_delete($_REQUEST['recid']);
		header('location: jobs.php');
		break;
	
	case "insertDoc":
	
		$returnPath = $objScr->upload_document();
		
		/* send mail function starts here */
		$pageUrl = basename($_SERVER['REQUEST_URI']);	
		
		// check if event is active or inactive [This will return TRUE or FALSE as per result]
		$flagSet = getEventStatus($pageUrl);
		
		// if event is active it go for mail function
		if($flagSet) {
			//It will Get All Details in array format for Send Email	
			$arrEmailInfo = get_email_info($pageUrl);
			
			$arrIds = $objScr->fetch_manager_ids($_REQUEST['lstJob']);
			
			// TO mail parameter
			$srManagerEmail = fetchStaffInfo($arrIds[0]['sr_manager'], 'email');
			$IndiaManagerEmail = fetchStaffInfo($arrIds[0]['india_manager'], 'email');

			// fetch email id of sr manager & india manager of practice
			$strPanelInfo = sql_select_panel($_SESSION['PRACTICEID']);
			$arrPanelInfo = explode('~', $strPanelInfo);
			$srManagerEmail = $arrPanelInfo[0];
			$inManagerEmail = $arrPanelInfo[2];
			
			$to = $srManagerEmail.",".$inManagerEmail;
			$cc = $arrEmailInfo['event_cc'];
			$subject = $arrEmailInfo['event_subject'];
			$content = $arrEmailInfo['event_content'];

			$arrReturnPath = explode('~', $returnPath);
			$docName = $arrReturnPath[0];
			$uploadedTime =	$arrReturnPath[1];

			// replace DOCNAME with actual doc name
			$content = str_replace('DOCNAME', $docName, $content);

			// replace DOCNAME with actual doc name
			$content = str_replace('DATETIME', $uploadedTime, $content);

			$content = replaceContent($content, NULL, $_SESSION['PRACTICEID'], NULL, $_REQUEST['lstJob']);

			include_once(MAIL);
			send_mail($to, $cc, $subject, $content);
		}
		/* send mail function ends here */		

		header('location: jobs.php?a=document');
		break;
}

switch ($a) {
case "add":
	$arrClientType = $objScr->fetchClientType();
	$arrClients = $objScr->fetch_clients();
    include(VIEW.'jobs_add.php');
    break;

case "audit":

	if(isset($_REQUEST['recid']) && !empty($_REQUEST['recid'])) {
		if(isset($_SESSION['jobId'])) unset($_SESSION['jobId']);
		$_SESSION['jobId'] = $_REQUEST['recid'];
	}

	if(isset($_SESSION['jobId']) && !empty($_SESSION['jobId'])) {
		$arrJobInfo = $objScr->fetchJobDetail($_SESSION['jobId']);
		if(!empty($arrJobInfo['client_id']))
			$dbClientId = $arrJobInfo['client_id'];

		if(!empty($arrJobInfo['mas_Code']))
			$dbCliTypeId = $arrJobInfo['mas_Code'];

		if(!empty($arrJobInfo['job_type_id']))
			$dbJobTypeId = $arrJobInfo['job_type_id'];

		if(!empty($arrJobInfo['period']))
			$dbPeriod = $arrJobInfo['period'];

		if(!empty($arrJobInfo['notes']))
			$dbNotes = $arrJobInfo['notes'];

		$arrJobType = $objScr->fetchType($dbCliTypeId);
	}
	else {
		$arrJobInfo = array();
		$dbClientId = "";
		$dbCliTypeId = "";
		$dbJobTypeId = "";
		$dbPeriod = "";
		$dbNotes = "";
	}

	$arrClientType = $objScr->fetchClientType();
	$arrClients = $objScr->fetch_clients();
	include(VIEW.'jobs_audit.php');
    break;

case "checklist":
	$arrChecklist = $objScr->getAuditChecklist();
	$arrDocDetails = $objScr->getAuditDetails($_SESSION['jobId']);
	$arrUplStatus['PENDING'] = 'Pending';
	$arrUplStatus['ATTACHED'] = 'Attached';
	$arrUplStatus['NA'] = 'N/A';
	include(VIEW.'jobs_audit_checklist.php');
    break;

case "uploadAudit":
	$checklistName = $objScr->getChecklistName($_REQUEST['checklistId']);
	$arrDocList = $objScr->getAuditDocList($_SESSION['jobId'],$_REQUEST['checklistId']);
	include(VIEW.'jobs_audit_upload.php');
	break;

case "edit":
	$arrJobs = $objScr->sql_select();
	$arrJobsData = $arrJobs[$recid];
	$arrJobType = $objScr->fetchType($arrJobsData['mas_Code']);
	$arrClientType = $objScr->fetchClientType();
	$arrClients = $objScr->fetch_clients();
	include(VIEW.'jobs_edit.php');
	break;

case "pending":
	$arrJobs = $objScr->sql_select('pending');
	$arrJobType = $objScr->fetchType();
	$arrClientType = $objScr->fetchClientType();
	$arrClients = $objScr->fetch_associated_clients();
	$arrJobStatus = $objScr->fetchStatus();
	include(VIEW.'jobs_pending.php');
	break;

case "saved":
	$arrJobs = $objScr->sql_select('saved');
	$arrJobType = $objScr->fetchType();
	$arrClientType = $objScr->fetchClientType();
	$arrClients = $objScr->fetch_associated_clients();
	$arrJobStatus = $objScr->fetchStatus();
	include(VIEW.'jobs_saved.php');
	break;

case "completed":
	$arrJobs = $objScr->sql_select('completed');
	$arrJobType = $objScr->fetchType();
	$arrClientType = $objScr->fetchClientType();
	$arrClients = $objScr->fetch_associated_clients();
	$arrJobStatus = $objScr->fetchStatus();
	include(VIEW.'jobs_completed.php');
	break;

case "document":
	$arrjobs = $objScr->sql_select();
	$arrDoc = $objScr->fetch_documents();
	$arrJobType = $objScr->fetchType();
	$arrClients = $objScr->fetch_associated_clients();
	include(VIEW.'jobs_documents.php');
	break;

case "uploadDoc":
	$arrjobs = $objScr->sql_select();
	$arrJobType = $objScr->fetchType();
	$arrClients = $objScr->fetch_associated_clients();
	include(VIEW.'jobs_documents.php');
	break;

case "download":
	$objScr->doc_download($_REQUEST["filePath"], $_REQUEST['flagChecklist']);
	include(VIEW.'jobs_edit.php');
	break;

case "deleteDoc":
	$objScr->delete_doc($_REQUEST["filePath"], $_REQUEST['flagChecklist']);
	$arrJobStatus = $objScr->fetchStatus();
	$arrJobs = $objScr->sql_select();
	$arrJobsData = $arrJobs[$recid];
	$arrJobType = $objScr->fetchType();
	$arrClientType = $objScr->fetchClientType();
	$arrClients = $objScr->fetch_associated_clients();
	include(VIEW.'jobs_edit.php');
	break;

default:
	$arrJobStatus = $objScr->fetchStatus();
	$arrJobs = $objScr->sql_select();
	$arrJobType = $objScr->fetchType();
	$arrClientType = $objScr->fetchClientType();
	$arrClients = $objScr->fetch_associated_clients();
	include(VIEW.'jobs_list.php');
	break;
}
?>