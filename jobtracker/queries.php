<?php
include("include/common.php");
include(MODEL."queries_class.php");

$objScr = new Query();

if(!empty($_REQUEST["action"]) && $_REQUEST["action"] == 'update') {
	//if(!empty($_REQUEST["queryId"])) {
		$objScr->sql_update($_REQUEST["queryId"]);
	
		$sentTime = $objScr->fetchSentTime();
		$currentTime = date('Y-m-d H:i:s');
		$lastSentMin = $objScr->timeDiff($sentTime,$currentTime);
	
		if($lastSentMin > 60) {
		
			$objScr->updateSentTime($currentTime);
	
			/* send mail function starts here */
			$pageCode = 'QRYAN';
			
			// check if event is active or inactive [This will return TRUE or FALSE as per result]
			$flagSet = getEventStatus($pageCode);

			// if event is active it go for mail function
			if($flagSet) {

				//It will Get All Details in array format for Send Email	
				$arrEmailInfo = get_email_info($pageCode);

				// fetch email id of sr manager
				$to = fetch_prac_designation($_SESSION["PRACTICEID"], true, false, true, true);
				$cc = $arrEmailInfo['event_cc'];
				$bcc = $arrEmailInfo['event_bcc'];
				$from = $arrEmailInfo['event_from'];
				$subject = $arrEmailInfo['event_subject'];
				$content = $arrEmailInfo['event_content'];
				$jobId = $objScr->fetchJobId($_REQUEST["queryId"]);
				$content = replaceContent($content, NULL, $_SESSION["PRACTICEID"], NULL, $jobId);
				
				include_once(MAIL);
				send_mail($from, $to, $cc, $bcc, $subject, $content);
			}
			/* send mail function ends here */
		}	

		header("Location: queries.php?flagUpdate=Y&lstJob={$_REQUEST['lstJob']}&lstCliType={$_REQUEST['lstCliType']}");
	//}
	/*else {
		foreach($_REQUEST AS $varName => $varValue) {
			if(strstr($varName, 'txtResponse')) {
				$queryId = str_replace('txtResponse', '', $varName);
				$arrResponse[$queryId] = $varValue;
			}
		}

		$objScr->sql_update_all($arrResponse);
		$sentTime = $objScr->fetchSentTime();
		$currentTime = date('Y-m-d H:i:s');
		$lastSentMin = $objScr->timeDiff($sentTime,$currentTime);
	
		if($lastSentMin > 60) {
		
			$objScr->updateSentTime($currentTime);

			// send mail function starts here 
			$pageCode = 'QRYAN';
			
			// check if event is active or inactive [This will return TRUE or FALSE as per result]
			$flagSet = getEventStatus($pageCode);

			// if event is active it go for mail function
			if($flagSet) {

				//It will Get All Details in array format for Send Email	
				$arrEmailInfo = get_email_info($pageCode);
				
				// TO mail parameter
				$to = fetch_prac_designation($_SESSION["PRACTICEID"], true, false, true, true);
				$cc = $arrEmailInfo['event_cc'];
				$bcc = $arrEmailInfo['event_bcc'];
				$from = $arrEmailInfo['event_from'];
				$subject = $arrEmailInfo['event_subject'];
				$content = $arrEmailInfo['event_content'];
				$content = str_replace('of JOBNAME', '', $content);
				$content = replaceContent($content, NULL, $_SESSION["PRACTICEID"]);
				
				include_once(MAIL);
				send_mail($from, $to, $cc, $bcc, $subject, $content);
				
			}
			// send mail function ends here
		}

		header("Location: queries.php?flagUpdate=A&lstJob={$_REQUEST['lstJob']}");
	}*/
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