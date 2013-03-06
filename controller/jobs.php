<?php
include("../include/common.php");
include(MODEL."job_class.php");
$objScr = new Job();

$a = $_REQUEST["a"];
$recid = $_REQUEST["recid"];
$sql = $_REQUEST["sql"]?$_REQUEST["sql"]:'';

switch ($sql) {
	case "insert":
		$objScr->sql_insert();
			$pageUrl = basename($_SERVER['PHP_SELF']); 
			//Get Event Status according Page Url 
			$flagSet = getEventStatus($pageUrl);

			
			if($flagSet) //If Flag or Event Active it will Execute
			{
				//It will Get Email Id from Which Email Id the Email will Send.
				$fromEmail = get_email_id($_SESSION['PRACTICEID']);

				//It will Get All Details in array format for Send Email	
				$arrEmailInfo = get_email_info($pageUrl);
				
				$from = $fromEmail;
				$to = $arrEmailInfo['event_to'];
				$cc = $arrEmailInfo['event_cc'];
				$subject = $arrEmailInfo['event_subject'];
				$content = $arrEmailInfo['event_content'];
				
				
				//It will fetch Registered User Name according their Email id Set in to Event Manager.
				$toName = to_name($to);
				$fromName = $_SESSION['PRACTICE'];
		
				//it will replace @toName , @fromName to Appropriate Registered User Name
				$content = replace_to($content,$toName,$fromName);

				//Include Send Mail File For To Generate Email
				include_once(MAIL);
				
				//It will Get all Necessary Information and Send Email to Admin Person
				send_mail($from, $to, $cc, $subject, $content);
			}
			
			
			
		header('location: jobs.php');
		break;

	case "update":
		$objScr->sql_update();
		header('location: jobs.php');
		break;

	case "delete":
		$objScr->sql_delete($_REQUEST['recid']);
		header('location: jobs.php');
		break;
}

switch ($a) {
case "add":
	$arrClientType = $objScr->fetchClientType();
	$arrClients = $objScr->fetch_clients();
	include(VIEW.'jobs_add.php');
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
	$arrClients = $objScr->fetch_associated_clients('pending');
	$arrJobStatus = $objScr->fetchStatus();
	include(VIEW.'jobs_pending.php');
	break;

case "completed":
	$arrJobs = $objScr->sql_select('completed');
	$arrJobType = $objScr->fetchType();
	$arrClientType = $objScr->fetchClientType();
	$arrClients = $objScr->fetch_associated_clients('completed');
	$arrJobStatus = $objScr->fetchStatus();
	include(VIEW.'jobs_completed.php');
	break;

case "document":
	$arrJobs = $objScr->sql_select('completed');
	$arrJobType = $objScr->fetchType();
	$arrClientType = $objScr->fetchClientType();
	$arrClients = $objScr->fetch_associated_clients('completed');
	$arrJobStatus = $objScr->fetchStatus();
	include(VIEW.'jobs_document.php');
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