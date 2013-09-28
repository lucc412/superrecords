<?
/*	
	Created By -> 01-Mar-13 [Disha Goyal]
	Last Modified By -> 07-Mar-13 [Disha Goyal]									
	Description: This is controller file for page 'Manage Emails'	
*/

ob_start();

/* Include common functions files */
include 'common/varDeclare.php';
include 'dbclass/commonFunctions_class.php';
include("includes/header.php");
/* include class file & create class object for class function access */
include 'dbclass/manage_emails_class.php';
$objCallData = new Manage_Emails();

if($_SESSION['validUser']) {
	
?><br/><?

			// set request variables here
			$doAction = $_REQUEST["doAction"]?$_REQUEST["doAction"]:'';
			$action = $_REQUEST["action"]?$_REQUEST["action"]:'';


			/* switch case for fucntion calling in DB file */ 
			switch ($doAction) {

				/* update event to, cc, from email address */
				case "update":

					// set to, cc, from email variables to update in database 
					$eventId = $_REQUEST["eventId"];
					$frmEmail = $_REQUEST["txtFrm~".$eventId];
					$ccEmail = $_REQUEST["txtCc~".$eventId];
					$bccEmail = $_REQUEST["txtBcc~".$eventId];
					
					$arrFrmEmail = explode(',', $frmEmail);
					$frmEmail = $arrFrmEmail[0];

					// DB function to update event
					$objCallData->sql_update($eventId, $frmEmail, $ccEmail, $bccEmail);

					break;

				/* update event subject & content */
				case "setTemplate":

					// set subject, content, event_id variables to update in database 
					$eventId = $_REQUEST["eventId"];
					$subject = $_REQUEST["txtSubject"];
					$content = $_REQUEST["txtContent"];

					// DB function to update event template
					$objCallData->sql_update_template($eventId, $subject, $content);

					break;

				/* update status of event */
				case "changeStatus":

					// set status, event_id variables to update in database 
					$eventId = $_REQUEST["eventId"];
					$status = $_REQUEST["status"];

					if(empty($status)) $status = 1;
					else $status = 0;

					// DB function to update event status
					$objCallData->sql_update_status($eventId, $status);
					header("Location:manage_emails.php");

					break;

				// view case
				default:
					break;
			}


			/* switch case to display pages as per request */ 
			switch ($action) {

				// edit case [to set mail content]
				case "edit":

					/* DB function to fetch selected event data */
					$arrEventInfo = $objCallData->sql_select($_REQUEST['eventId']);
					include('views/manage_emails_edit.php');

					break;

				// view case [to show email events]
				default:

					//Get FormCode
					$formcode = $commonUses->getFormCode("Manage Emails");
					$access_file_level = $commonUses->checkFileAccess($_SESSION['staffcode'],$formcode);

					//If View, Add, Edit, Delete all set to N
					if($access_file_level == 0) {
						echo "You are not authorised to view this file.";
					}
					else {
						// DB function to fetch all events here 
						$arrEvents = $objCallData->sql_select();
						include('views/manage_emails_view.php');
					}

					break;
			}


			/* include footer file */
			include('includes/footer.php');
}  
else {
	header("Location:index.php?msg=timeout");
}
?>