<?php
function getEventStatus($eventId) 
{

 	$query = "select event_status from email_events where event_id='$eventId'";
	
	$runquery = mysql_query($query);
	
	while($myRow = mysql_fetch_assoc($runquery))
	{
		$eventStatus = $myRow['event_status'];
	}
    
    return $eventStatus;

}

function get_email_id($pr_id)
	{
		$myQueryPrId = "SELECT email 
						FROM pr_practice 
						WHERE id = '$pr_id'";
		

		$myRunQueryPrId = mysql_query($myQueryPrId);
			
			while($myRowPrId = mysql_fetch_assoc($myRunQueryPrId))
			{
				$prEmailId = $myRowPrId['email'];
				//It will Fetch Email id of Practice User
			}
		return $prEmailId;
	}

function get_email_info($eventId)

	$myQuery = "SELECT event_name,event_subject,event_content, event_to,event_cc
				FROM email_events 
				WHERE event_id = '$eventId'";
		
		$runQuery = mysql_query($myQuery);
		while($row = mysql_fetch_assoc($runQuery))
		{
			$arrEmailInfo = $row;
		}
		
		return $arrEmailInfo;
}


?>