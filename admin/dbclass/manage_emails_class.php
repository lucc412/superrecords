<?
/*	
	Created Date: 01-Mar-13										
	Created By: Disha Goyal										
	Description: This is class file for page 'Manage Emails'	
*/

class Manage_Emails extends Database { 	

	/* Class constructor */
	public function __construct() {
		
  	}

	/* This is email event function to fetch all email events 
	   Date Created -> 01-Mar-13 [Disha Goyal]
	*/
	public function sql_select($eventId) {	
		
		if(!empty($eventId)) $appendStr = "WHERE ee.event_id = {$eventId}";

		$qrySel = "SELECT ee.*
					FROM email_events ee
					{$appendStr}";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			if(empty($eventId)) $arrEvents[] = $rowData;
			else $arrEvents = $rowData;
		}
		return $arrEvents;	
	}

	/* This is email event update function to update cc, to, from email addresses 
	   Date Created -> 01-Mar-13 [Disha Goyal]
	*/
	public function sql_update($eventId, $frmEmail, $toEmail, $ccEmail) {

		$qryUpd = "UPDATE email_events
				SET event_from = '" . addslashes($frmEmail) . "',
					event_to = '" . addslashes($toEmail) . "',
					event_cc = '" . addslashes($ccEmail) . "'
				WHERE event_id = '" . $eventId . "'";

		mysql_query($qryUpd);	
	} 

	/* This is email event update function to update subject & content of event
	   Date Created -> 01-Mar-13 [Disha Goyal]
	*/
	public function sql_update_template($eventId, $subject, $content) {
		$qryUpd = "UPDATE email_events
				SET event_subject = '" . addslashes($subject) . "',
					event_content = '" . addslashes($content) . "'
				WHERE event_id = '" . $eventId . "'";

		mysql_query($qryUpd);	
	} 

	/* This is email event update function to update status of event
	   Date Created -> 01-Mar-13 [Disha Goyal]
	*/
	public function sql_update_status($eventId, $status) {
		$qryUpd = "UPDATE email_events
				SET event_status = '" . $status . "'
				WHERE event_id = '" . $eventId . "'";

		mysql_query($qryUpd);	
	} 
}
?>