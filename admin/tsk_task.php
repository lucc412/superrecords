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

// create class object for class function access
$objCallData = new Task_Class();

if($_SESSION['validUser']) {
	?><html>
		<head>
			<title>Task</title>
			<meta name="generator" http-equiv="content-type" content="text/html">
			<LINK href="<?=$styleSheet;?>stylesheet.css" rel="stylesheet" type="text/css">
			<LINK href="<?=$styleSheet;?>tooltip.css" rel="stylesheet" type="text/css">
	
			<script type="text/javascript" src="<?=$javaScript;?>validate.js"></script>
			<script type="text/javascript" src="<?=$javaScript;?>tsk_task_validate.js"></script>
			<script type="text/javascript" src="<?=$javaScript;?>datetimepicker.js"></script>
			<script type="text/javascript" src="<?=$javaScript;?>jquery-1.4.2.min.js"></script>
		</head>

		<body><?
			include("includes/header.php");?><br><?

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
					$pageUrl = basename($_SERVER['REQUEST_URI']);
					$arrPageUrl = explode('&',$pageUrl);	
					$pageUrl = $arrPageUrl[0];
					
					// check if event is active or inactive [This will return TRUE or FALSE as per result]
					$flagSet = getEventStatus($pageUrl);
					
					// if event is active it go for mail function
					if($flagSet) {

						//It will Get All Details in array format for Send Email	
						$arrEmailInfo = get_email_info($pageUrl);

						// fetch email id of sr manager
						$strPanelInfo = sql_select_panel($practiceId);
						$arrPanelInfo = explode('~', $strPanelInfo);
						$inManagerEmail = $arrPanelInfo[2];

						$to = $inManagerEmail;
						$cc = $arrEmailInfo['event_cc'];
						$subject = $arrEmailInfo['event_subject'];
						$content = $arrEmailInfo['event_content'];
						$content =replaceContent($content, NULL, NULL, NULL, $jobId);
						
						include_once(MAIL);
						send_mail($to, $cc, $subject, $content);
					}
					/* send mail function ends here */

					header('location: tsk_task.php?jobId='.$_REQUEST["jobId"]);
					break;

				case "update":
					$objCallData->sql_update();
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
				}

				// fetch name of sr manager, india manager & team member
				$arrPanelInfo = explode('~', $strPanelInfo);
				$srManagerEmail = $arrPanelInfo[0];
				$inManagerEmail = $arrPanelInfo[2];
				$teamMemberEmail = $arrPanelInfo[3];
				include('views/tsk_task_add.php');
				break;

			case "view":

				//Get FormCode
				$formcode = $commonUses->getFormCode("Task");
				$access_file_level = $commonUses->checkFileAccess($_SESSION['staffcode'],$formcode);

				$arrTask = $objCallData->sql_select();
				$arrTaskData = $arrTask[$recid];
				$arrEmployees = $objCallData->fetchEmployees();
				include('views/tsk_task_view.php');
				break;

			case "edit":
				$arrTask = $objCallData->sql_select();
				$arrTaskData = $arrTask[$recid];
				$arrFewClient = $objCallData->fetchClient($arrTaskData["id"]);
				$arrFewJob = $objCallData->fetchJob($arrTaskData["client_id"]);
				$arrFewSubActivity = $objCallData->fetchSubActivity($arrTaskData["mas_Code"]);
				$arrEmployees = $objCallData->fetchEmployees();
				include('views/tsk_task_edit.php');
				break;

			default:
				//Get FormCode
				$formcode = $commonUses->getFormCode("Task");
				$access_file_level = $commonUses->checkFileAccess($_SESSION['staffcode'],$formcode);

				//If View, Add, Edit, Delete all set to N
				if($access_file_level == 0) {
					echo "You are not authorised to view this file.";
				}
				else {
					$arrEmployees = $objCallData->fetchEmployees();
					$arrTask = $objCallData->sql_select($_REQUEST["jobId"]);
					include('views/tsk_task_list.php');
				}
				break;
			}
		
		include("includes/footer.php");	
		
		?></body>
	</html><?
}  
else {
	header("Location:index.php?msg=timeout");
}
?>