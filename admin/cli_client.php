<?php 
ob_start();
include 'common/varDeclare.php';
include 'dbclass/commonFunctions_class.php';
include 'dbclass/cli_client_class.php';

// create class object for class function access
$objCallData = new Practice_Class();

if($_SESSION['validUser']) {
	?><html>
		<head>
			<title>Manage Client</title>
			<meta name="generator" http-equiv="content-type" content="text/html">
			<script type="text/javascript" src="<?php echo $javaScript; ?>datetimepicker.js"></script>
			<script type="text/javascript" src="<?php echo $javaScript; ?>validate.js"></script>
			<script type="text/javascript" src="<?php echo $javaScript; ?>cli_validate.js"></script>
		</head>

		<body><?
			include("includes/header.php");?><br><?

			$a = $_REQUEST["a"];
			$recid = $_REQUEST["recid"];
			$sql = $_REQUEST["sql"]?$_REQUEST["sql"]:'';

			switch ($sql) {
				case "insert":
					$objCallData->sql_insert();
					header('location: cli_client.php');
					break;

				case "update":
					$objCallData->sql_update();
					break;

				case "delete":
					$objCallData->sql_delete($_REQUEST['recid']);
					header('location: cli_client.php');
					break;
			}

			switch ($a) {
			case "add":
				include('views/cli_client_add.php');
				break;

			case "view":
				$arrClient = $objCallData->sql_select();
				$arrClientData = $arrClient[$recid];
				include('views/cli_client_view.php');
				break;

			case "edit":
				$arrClient = $objCallData->sql_select();
				$arrClientData = $arrClient[$recid];
				include('views/cli_client_edit.php');
				break;

			default:
				//Get FormCode
				$formcode = $commonUses->getFormCode("Manage Client");
				$access_file_level = $commonUses->checkFileAccess($_SESSION['staffcode'],$formcode);

				//If View, Add, Edit, Delete all set to N
				if($access_file_level == 0) {
					echo "You are not authorised to view this file.";
				}
				else {
					$arrClient = $objCallData->sql_select();
					include('views/cli_client_list.php');
				}

				break;
			}
			
	include("includes/footer.php");
}  
else {
	header("Location:index.php?msg=timeout");
}
?>