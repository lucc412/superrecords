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
function get_email_id($pr_id)
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
}

//It will Get All Information Regarding Event like TO , FROM , CC , Subject , Message etc It will Return all those Details in Array Form.
function get_email_info($pageUrl)
{
	//It will Generate Query and will get Require Details From Database
	$myQuery = "SELECT event_name,event_subject,event_content, event_to,event_cc,event_from
				FROM email_events 
				WHERE event_url = '$pageUrl'";
	
	$runQuery = mysql_query($myQuery);
	$arrEmailInfo = mysql_fetch_assoc($runQuery);
		
	//It will Return all Necessary Information in form of Array
	return $arrEmailInfo;
}

//It will Replace 
function replace_to($content,$toName,$fromName)
{
	
	$content = str_replace('@toName',$toName,$content);
	$content = str_replace('@fromName',$fromName,$content);
	return $content;
}

//it will Return To Person Name
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
	
}

?>