<?php 
//************************************************************************************************
//  Task          : Controller page which redirect to View, Add or Update page
//  Modified By   : Dhiraj Sahu 
//  Created on    : 28-Dec-2012
//  Last Modified : 26-Jan-2013 
//************************************************************************************************
ob_start();
include 'common/varDeclare.php';
include(PHPFUNCTION);
include 'dbclass/commonFunctions_class.php';
include 'dbclass/tsk_task_class.php';
include("includes/header.php");

// create class object for class function access
$objCallData = new Task_Class();

if($_SESSION['validUser']) {
	
	if (isset($_POST["filter"])) $filter = @$_POST["filter"];
	if (isset($_POST["filter_field"])) $filterfield = @$_POST["filter_field"];
	$wholeonly = false;
	if (isset($_POST["wholeonly"])) $wholeonly = @$_POST["wholeonly"];
	
	if (!isset($filter) && isset($_SESSION["filter"])) $filter = $_SESSION["filter"];
	if (!isset($filterfield) && isset($_SESSION["filter_field"])) $filterfield = $_SESSION["filter_field"];

	if (isset($filter)) $_SESSION["filter"] = $filter;
	if (isset($filterfield)) $_SESSION["filter_field"] = $filterfield;
	if (isset($wholeonly)) $_SESSION["wholeonly"] = $wholeonly;	
	
	?><br/><?

			$a = $_REQUEST["a"];
			$recid = $_REQUEST["recid"];
			$sql = $_REQUEST["sql"]?$_REQUEST["sql"]:'';

			switch ($sql) {
				case "insert":

					// set parameters when task is added from Job Page - View Associated tasks
					if(isset($_REQUEST['jobId']) && !empty($_REQUEST['jobId'])) {
						$jobId = $_REQUEST["jobId"];
						$clientId = $objCallData->arrJobDetails[$jobId]["client_id"];
						$practiceId = $objCallData->arrClientDetails[$clientId]["id"];
					}
					// set parameters when task is added from Task page
					else {
						$jobId = $_REQUEST["lstJob"];
						$clientId = $_REQUEST["lstClient"];
						$practiceId = $_REQUEST["lstPractice"];
					}

					// insert query for add task
					$objCallData->sql_insert($jobId, $clientId, $practiceId);

					/* send mail function starts here */
					$pageCode = 'NWTSK';
					
					// check if event is active or inactive [This will return TRUE or FALSE as per result]
					$flagSet = getEventStatus($pageCode);
					
					// if event is active it go for mail function
					if($flagSet) {

						//It will Get All Details in array format for Send Email	
						$arrEmailInfo = get_email_info($pageCode);
						$to = fetch_prac_designation($practiceId,true,false,true,true);
						$cc = fetch_client_designation($jobId,true,true,true);
						if(!empty($arrEmailInfo['event_cc'])) $cc .= ','.$arrEmailInfo['event_cc'];
						$bcc = $arrEmailInfo['event_bcc'];
						$from = $arrEmailInfo['event_from'];
						$subject = $arrEmailInfo['event_subject'];
						$content = $arrEmailInfo['event_content'];
						$content = replaceContent($content, NULL, NULL, NULL, $jobId);
						
						include_once(MAIL);
						send_mail($from, $to, $cc, $bcc, $subject, $content);
					}
					/* send mail function ends here */

					header('location: tsk_task.php?jobId='.$_REQUEST["jobId"]);
					break;

				case "update":
					// set parameters when task is added from Job Page - View Associated tasks
					if(isset($_REQUEST['jobId']) && !empty($_REQUEST['jobId'])) {
						$jobId = $_REQUEST["jobId"];
						$practiceId = $objCallData->arrClientDetails[$clientId]["id"];
					}
					// set parameters when task is added from Task page
					else {
						$jobId = $_REQUEST["lstJob"];
						$practiceId = $_REQUEST["lstPractice"];
					}

					$taskId = $_REQUEST['recid'];
					$oldTaskStatus = $objCallData->getTaskStatus($taskId);
					$newTaskStatus = $_POST['lstTaskStatus'];
					
					if($oldTaskStatus != $newTaskStatus && $newTaskStatus == '16')
					{
						/* send mail function starts here */	
						$pageCode = 'TSKDN';
						// check if event is active or inactive [This will return TRUE or FALSE as per result]
						$flagSet = getEventStatus($pageCode);
						// if event is active it go for mail function
						if($flagSet) {
							//It will Get All Details in array format for Send Email
							$arrEmailInfo = get_email_info($pageCode);
							//It will Get Email Id from Which Email Id the Email will Send.
							$to = fetch_prac_designation($practiceId,true,false,true,true);
							$cc = fetch_client_designation($jobId,true,true,true);
							if(!empty($arrEmailInfo['event_cc'])) $cc .= ','.$arrEmailInfo['event_cc'];
							$bcc = $arrEmailInfo['event_bcc'];
							$from = $arrEmailInfo['event_from'];
							$subject = $arrEmailInfo['event_subject'];
							$content = $arrEmailInfo['event_content'];
							$content = replaceContent($content,NULL,NULL,NULL,NULL,$taskId);
							
							include_once(MAIL);
							send_mail($from, $to, $cc, $bcc, $subject, $content);
						}
						/* send mail function ends here */
					}

					$objCallData->sql_update();
					header('location: tsk_task.php?jobId='.$_REQUEST["jobId"]);
					break;

				case "delete":
					$objCallData->sql_delete($_REQUEST['recid']);
					header('location: tsk_task.php?jobId='.$_REQUEST["jobId"]);
					break;
			}

			switch ($a) {
			case "add":

				// get practice id of this job
				if(isset($_REQUEST['jobId']) && !empty($_REQUEST['jobId'])) {
					$jobId = $_REQUEST["jobId"];
					$clientId = $objCallData->arrJobDetails[$jobId]["client_id"];
					$practiceId = $objCallData->arrClientDetails[$clientId]["id"];
					$strPanelInfo = $objCallData->sql_select_panel($practiceId);
					$teamMemberEmail = $objCallData->fetch_team_member($clientId);
					$SrAccntCompEmail = $objCallData->fetch_SrAccnt_Comp($clientId);
					$SrAccntAuditEmail = $objCallData->fetch_SrAccnt_Audit($clientId);
				}

				// fetch name of sr manager, india manager & team member
				$arrPanelInfo = explode('~', $strPanelInfo);
				$srManagerEmail = $arrPanelInfo[0];
				$salesPersonEmail = $arrPanelInfo[1];
				$inManagerEmail = $arrPanelInfo[2];
                $auditManagerEmail = $arrPanelInfo[3];
				include('views/tsk_task_add.php');
				break;

			case "view":

				//Get FormCode
				$formcode = $commonUses->getFormCode("Task");
				$access_file_level = $commonUses->checkFileAccess($_SESSION['staffcode'],$formcode);

				$arrTask = $objCallData->sql_select($a,$recid);
				$arrTaskData = $arrTask[$recid];
				$arrEmployees = $objCallData->fetchEmployees();
				include('views/tsk_task_view.php');
				break;

			case "edit":
				$arrTask = $objCallData->sql_select($a,$recid);
				$arrTaskData = $arrTask[$recid];
				$arrFewClient = $objCallData->fetchClient($arrTaskData["id"]);
				$arrFewJob = $objCallData->fetchJob($arrTaskData["client_id"]);
				$arrFewSubActivity = $objCallData->fetchSubActivity($arrTaskData["mas_Code"]);
				$arrEmployees = $objCallData->fetchEmployees();
				include('views/tsk_task_edit.php');
				break;

			case "reset":
			
				//Get FormCode
				$formcode = $commonUses->getFormCode("Task");
				$access_file_level = $commonUses->checkFileAccess($_SESSION['staffcode'],$formcode);
				
				// reset filter	
				$filter = "";
				$filterfield = "";
				$wholeonly = "";
				$checkstr = "";
				if ($wholeonly) $checkstr = " checked";
				 
				//If View, Add, Edit, Delete all set to N
				if($access_file_level == 0) {
					echo "You are not authorised to view this file.";
				}
				else {
					$arrEmployees = $objCallData->fetchEmployees();
					$arrTask = $objCallData->sql_select(NULL, NULL, $_REQUEST['jobId']);
					include('views/tsk_task_list.php');
				}
				break;


			default:
				//Get FormCode
				$formcode = $commonUses->getFormCode("Task");
				$access_file_level = $commonUses->checkFileAccess($_SESSION['staffcode'],$formcode);

				$checkstr = "";
				if ($wholeonly) $checkstr = " checked";

				//If View, Add, Edit, Delete all set to N
				if($access_file_level == 0) {
					echo "You are not authorised to view this file.";
				}
				else {
					$arrEmployees = $objCallData->fetchEmployees();
					$arrTask = $objCallData->sql_select(NULL, NULL, $_REQUEST["jobId"]);
					include('views/tsk_task_list.php');
				}
				break;
			}
		
		include("includes/footer.php");	
		
		
}  
else {
	header("Location:index.php?msg=timeout");
}
?>