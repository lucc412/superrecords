<?php
include("../../jobtracker/include/common.php");
include(MODEL."queries_class.php");

$objScr = new Query();

if(!empty($_REQUEST["action"]) && $_REQUEST["action"] == 'update') {
	if(!empty($_REQUEST["queryId"])) {
		$objScr->sql_update($_REQUEST["queryId"]);
	
		$sentTime = $objScr->fetchSentTime();
		$currentTime = date('Y-m-d H:i:s');
		$lastSentMin = $objScr->timeDiff($sentTime,$currentTime);
	
		if($lastSentMin > 60) {
		
			$objScr->updateSentTime($currentTime);
	
			/* send mail function starts here */
			$pageUrl = basename($_SERVER['REQUEST_URI']);
			
			// check if event is active or inactive [This will return TRUE or FALSE as per result]
			$flagSet = getEventStatus($pageUrl);

			// if event is active it go for mail function
			if($flagSet) {

				//It will Get All Details in array format for Send Email	
				$arrEmailInfo = get_email_info($pageUrl);

				// fetch email id of sr manager
				$strPanelInfo = sql_select_panel($_SESSION["PRACTICEID"]);
				$arrPanelInfo = explode('~', $strPanelInfo);
				$srManagerEmail = $arrPanelInfo[0];
				$inManagerEmail = $arrPanelInfo[2];

				$to = $srManagerEmail.",".$inManagerEmail;
				$cc = $arrEmailInfo['event_cc'];
				$subject = $arrEmailInfo['event_subject'];
				$content = $arrEmailInfo['event_content'];
				$jobId = $objScr->fetchJobId($_REQUEST["queryId"]);
				$content = replaceContent($content, NULL, $_SESSION["PRACTICEID"], NULL, $jobId);
				
				include_once(MAIL);
				send_mail($to, $cc, $subject, $content);
			}
			/* send mail function ends here */
		}	

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
		$sentTime = $objScr->fetchSentTime();
		$currentTime = date('Y-m-d H:i:s');
		$lastSentMin = $objScr->timeDiff($sentTime,$currentTime);
	
		if($lastSentMin > 60) {
		
			$objScr->updateSentTime($currentTime);

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
		}

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