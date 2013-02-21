<?
include("../include/connection.php");
include("../model/job_class.php");

$objScr = new Job();

$a = $_REQUEST["a"];
$recid = $_REQUEST["recid"];
$sql = $_REQUEST["sql"]?$_REQUEST["sql"]:'';

switch ($sql) {
	case "insert":
		$objScr->sql_insert();
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
	include('../view/jobs_add.php');
	break;

case "edit":
	$arrJobs = $objScr->sql_select();
	$arrJobsData = $arrJobs[$recid];
	$arrJobType = $objScr->fetchType($arrJobsData['mas_Code']);
	$arrClientType = $objScr->fetchClientType();
	$arrClients = $objScr->fetch_clients();
	include('../view/jobs_edit.php');
	break;

case "pending":
	$arrJobs = $objScr->sql_select('pending');
	$arrJobType = $objScr->fetchType();
	$arrClientType = $objScr->fetchClientType();
	$arrClients = $objScr->fetch_associated_clients('pending');
	$arrJobStatus = $objScr->fetchStatus();
	include('../view/jobs_pending.php');
	break;

case "completed":
	$arrJobs = $objScr->sql_select('completed');
	$arrJobType = $objScr->fetchType();
	$arrClientType = $objScr->fetchClientType();
	$arrClients = $objScr->fetch_associated_clients('completed');
	$arrJobStatus = $objScr->fetchStatus();
	include('../view/jobs_completed.php');
	break;

case "download":
	$objScr->doc_download($_REQUEST["filePath"], $_REQUEST['flagChecklist']);
	include('../view/jobs_edit.php');
	break;

case "deleteDoc":
	$objScr->delete_doc($_REQUEST["filePath"], $_REQUEST['flagChecklist']);
	$arrJobStatus = $objScr->fetchStatus();
	$arrJobs = $objScr->sql_select();
	$arrJobsData = $arrJobs[$recid];
	$arrJobType = $objScr->fetchType();
	$arrClientType = $objScr->fetchClientType();
	$arrClients = $objScr->fetch_associated_clients();
	include('../view/jobs_edit.php');
	break;

default:
	$arrJobStatus = $objScr->fetchStatus();
	$arrJobs = $objScr->sql_select();
	$arrJobType = $objScr->fetchType();
	$arrClientType = $objScr->fetchClientType();
	$arrClients = $objScr->fetch_associated_clients();
	include('../view/jobs_list.php');
	break;
}
?>