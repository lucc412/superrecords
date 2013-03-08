<?php
//It will Check Given Event is Active or Not it will Return Status Event according Event Id is Givent as Argument to Function
function getEventStatus($pageUrl) 
{
	//It will Generate Query to Fetch Event Record based on Event ID Given	
	$query = "SELECT event_status 
			  FROM   email_events 
			  WHERE  event_url='$pageUrl'";
	
		  
	$runquery = mysql_query($query);
		while($myRow = mysql_fetch_assoc($runquery))
		{
			//It will Store Event Status
			$eventStatus = $myRow['event_status'];
		}
    
	//Return the Status of Given Event Id
    return $eventStatus;
}

//It is Used to Get Email Id of Practice Login User it will Return Email Id of Practice User
/*function get_email_id($pr_id)
{
	//It will Give Email id of Practice Login User 	
	$myQueryPrId = "SELECT email 
					FROM pr_practice 
					WHERE id = '$pr_id'";

	$myRunQueryPrId = mysql_query($myQueryPrId);
	$fetchRow = mysql_fetch_assoc($myRunQueryPrId);
	 $prEmailId = $fetchRow['email'];

	//It will Return Email Id of Practice User
	return $prEmailId;
}*/

//It will Get All Information Regarding Event like TO , FROM , CC , Subject , Message etc It will Return all those Details in Array Form.
function get_email_info($pageUrl)
{
	//It will Generate Query and will get Require Details From Database
	$myQuery = "SELECT event_name,event_subject,event_content, event_cc
				FROM email_events 
				WHERE event_url = '$pageUrl'";
	
	$runQuery = mysql_query($myQuery);
	$arrEmailInfo = mysql_fetch_assoc($runQuery);
		
	//It will Return all Necessary Information in form of Array
	return $arrEmailInfo;
}

/*It will Replace 
function replace_to($content,$toName,$fromName)
{
	
	$content = str_replace('@toName',$toName,$content);
	$content = str_replace('@fromName',$fromName,$content);
	return $content;
}

it will Return To Person Name
function to_name($to)
{
	$mTo = explode(',',$to);
	$mTo = implode("','",$mTo);
	
	$query ="select CONCAT_WS(' ',con_Firstname,con_Middlename,con_Lastname) contactName from con_contact where con_Email in ('$mTo')";
	
	$RunQuery = mysql_query($query);
	while($row = mysql_fetch_assoc($RunQuery))
	{
		$arr_person_name[] = $row['contactName'];
	}

	$toName = implode(' , ',$arr_person_name);
	return $toName;
	
}*/

function fetchEntityName($entityId, $flagType) {	
	
	if($flagType == 'P') {
		$selStr = "p.name";
		$frmStr = "pr_practice p";
		$whrStr = "p.id = {$entityId}";
	}
	else if($flagType == 'C') {
		$selStr = "c.client_name name";
		$frmStr = "client c";
		$whrStr = "c.client_id = {$entityId}";
	}
	else if($flagType == 'J') {
		$selStr = "j.job_name name";
		$frmStr = "job j";
		$whrStr = "j.job_id = {$entityId}";
	}

	$qrySel = "SELECT {$selStr}
				FROM {$frmStr}
				WHERE {$whrStr}";

	$fetchResult = mysql_query($qrySel);		
	$rowData = mysql_fetch_assoc($fetchResult);
	$entityName = $rowData['name'];
	
	return $entityName;	
}

function fetchStaffInfo($staffId, $flagType) {	
	
	if($flagType == 'email') {
		$selStr = "cc.con_Email staffInfo";
	}
	else if($flagType == 'name') {
		$selStr = "CONCAT_WS(' ',cc.con_Firstname,cc.con_Middlename,cc.con_Lastname) staffInfo";
	}

	$qrySel = "SELECT {$selStr}
				FROM stf_staff ss, con_contact cc
				WHERE ss.stf_CCode = cc.con_Code
				AND ss.stf_Code = {$staffId}";

	$fetchResult = mysql_query($qrySel);		
	$rowData = mysql_fetch_assoc($fetchResult);
	$staffInfo = $rowData['staffInfo'];
	
	return $staffInfo;	
}

// this is used to replace the dynamic variables used in mail content
function replaceContent($content, $salesPersonId=NULL, $practiceId=NULL, $clientId=NULL, $jobId=NULL) {
	
	// for sales person name
	if(!empty($salesPersonId)) {
		$staffName = fetchStaffInfo($salesPersonId, 'name');
		$content = str_replace('SALESPERSONNAME', $staffName, $content);
	}

	// for practice name
	if(!empty($practiceId)) {
		$prName = fetchEntityName($practiceId, 'P');
		$content = str_replace('PRACTICENAME', $prName, $content);
	}

	// for client name
	if(!empty($clientId)) {
		$clientName = fetchEntityName($clientId, 'C');
		$content = str_replace('CLIENTNAME', $clientName, $content);
	}

	// for job name
	if(!empty($jobId)) {
		$jobName = fetchEntityName($jobId, 'J');
		$content = str_replace('JOBNAME', $jobName, $content);
	}
	
	return $content;	
} 

?>