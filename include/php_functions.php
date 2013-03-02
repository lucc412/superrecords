<?php
//It will Check Given Event is Active or Not it will Return Status Event according Event Id is Givent as Argument to Function
function getEventStatus($eventId) 
{
	//It will Generate Query to Fetch Event Record based on Event ID Given	
	$query = "SELECT event_status 
			  FROM   email_events 
			  WHERE  event_id='$eventId'";
	
		  
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
function get_email_id($pr_id)
{
	//It will Give Email id of Practice Login User 	
	$myQueryPrId = "SELECT email 
					FROM pr_practice 
					WHERE id = '$pr_id'";
	

	$myRunQueryPrId = mysql_query($myQueryPrId);
		while($myRowPrId = mysql_fetch_assoc($myRunQueryPrId))
		{
			//It will Fetch Email id of Practice User
			$prEmailId = $myRowPrId['email'];
		}
		//It will Return Email Id of Practice User
		return $prEmailId;
}

//It will Get All Information Regarding Event like TO , FROM , CC , Subject , Message etc It will Return all those Details in Array Form.
function get_email_info($eventId)
{
	//It will Generate Query and will get Require Details From Database
	$myQuery = "SELECT event_name,event_subject,event_content, event_to,event_cc,event_from
				FROM email_events 
				WHERE event_id = '$eventId'";
	
	$runQuery = mysql_query($myQuery);
	$arrEmailInfo = mysql_fetch_assoc($runQuery);
		
	//It will Return all Necessary Information in form of Array
	return $arrEmailInfo;
}
?>