<?
include '../include/connection.php';
include("../model/queries_class.php");

$objScr = new Query();

if(!empty($_REQUEST["action"]) && $_REQUEST["action"] == 'update') {
	if(!empty($_REQUEST["queryId"])) {
		$objScr->sql_update($_REQUEST["queryId"]);
		header("Location: queries.php?flagUpdate=Y");
	}
	else {
		foreach($_REQUEST AS $varName => $varValue) {
			if(strstr($varName, 'txtResponse')) {
				$queryId = str_replace('txtResponse', '', $varName);
				$arrResponse[$queryId] = $varValue;
			}
		}
		$objScr->sql_update_all($arrResponse);
		header("Location: queries.php?flagUpdate=A");
	}
}
else if(!empty($_REQUEST["action"]) && $_REQUEST["action"] == 'download') {
	$objScr->doc_download($_REQUEST["filePath"]);
	header("Location: queries.php");
}
else if(!empty($_REQUEST["action"]) && $_REQUEST["action"] == 'deleteDoc') {
	$objScr->delete_doc($_REQUEST["filePath"]);
	header("Location: queries.php");
}

$arrQueries = $objScr->fetch_queries();
$arrClients = $objScr->fetch_clients();
$arrJobType = $objScr->fetchType();
$arrJobs = $objScr->fetch_jobs();
include('../view/queries.php');
?>