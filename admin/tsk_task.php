<?php 
//************************************************************************************************
//  Task          : Controller page which redirect to View, Add or Update page
//  Modified By   : Dhiraj Sahu 
//  Created on    : 28-Dec-2012
//  Last Modified : 26-Jan-2013 
//************************************************************************************************
ob_start();
include 'common/varDeclare.php';
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
					$objCallData->sql_insert();
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
				include('views/tsk_task_add.php');
				break;

			case "view":
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