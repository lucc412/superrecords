<?php
include("../include/common.php");
include(MODEL."queries_class.php");

$objScr = new Query();

if(!empty($_REQUEST["action"]) && $_REQUEST["action"] == 'update') {
	if(!empty($_REQUEST["queryId"])) {
		$objScr->sql_update($_REQUEST["queryId"]);
		
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
		$pageUrl = basename($_SERVER['PHP_SELF']); 
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