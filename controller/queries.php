<?php
include("../include/common.php");
include(MODEL."queries_class.php");

$objScr = new Query();

if(!empty($_REQUEST["action"]) && $_REQUEST["action"] == 'update') {
	if(!empty($_REQUEST["queryId"])) {
		$objScr->sql_update($_REQUEST["queryId"]);
	
		/* send mail function starts here */
		$pageUrl = basename($_SERVER['REQUEST_URI']);
		
		// check if event is active or inactive [This will return TRUE or FALSE as per result]
		$flagSet = getEventStatus($pageUrl);

		// if event is active it go for mail function
		if($flagSet) {

			//It will Get All Details in array format for Send Email	
			$arrEmailInfo = get_email_info($pageUrl);
			
			// TO mail parameter
			$arrManagerIds = $objScr->fetch_manager_ids($_SESSION["PRACTICEID"]);
			foreach($arrManagerIds AS $managerId) {
				$srManagerEmail = fetchStaffInfo($managerId, 'email');
				$to .= $srManagerEmail . ',';
			}
			$to = rtrim($to, ',');
			
			$cc = $arrEmailInfo['event_cc'];
			$subject = $arrEmailInfo['event_subject'];
			$content = $arrEmailInfo['event_content'];
			$jobId = $objScr->fetchJobId($_REQUEST["queryId"]);
			$content = replaceContent($content, NULL, $_SESSION["PRACTICEID"], NULL, $jobId);
			
			include_once(MAIL);
			send_mail($to, $cc, $subject, $content);
		}
		/* send mail function ends here */

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

		/* send mail function starts here */
		$pageUrl = basename($_SERVER['REQUEST_URI']);
		
		// check if event is active or inactive [This will return TRUE or FALSE as per result]
		$flagSet = getEventStatus($pageUrl);

		// if event is active it go for mail function
		if($flagSet) {

			//It will Get All Details in array format for Send Email	
			$arrEmailInfo = get_email_info($pageUrl);
			
			// TO mail parameter
			$arrManagerIds = $objScr->fetch_manager_ids($_SESSION["PRACTICEID"]);
			foreach($arrManagerIds AS $managerId) {
				$srManagerEmail = fetchStaffInfo($managerId, 'email');
				$to .= $srManagerEmail . ',';
			}
			$to = rtrim($to, ',');
			
			$cc = $arrEmailInfo['event_cc'];
			$subject = $arrEmailInfo['event_subject'];
			$content = $arrEmailInfo['event_content'];
			$content = str_replace('of JOBNAME', '', $content);
			$content = replaceContent($content, NULL, $_SESSION["PRACTICEID"]);
			
			include_once(MAIL);
			send_mail($to, $cc, $subject, $content);
		}
		/* send mail function ends here */

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
include(VIEW.'queries.php');
?>