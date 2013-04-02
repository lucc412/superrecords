<?php 
ob_start();
include 'common/varDeclare.php';
include 'dbclass/commonFunctions_class.php';
include 'dbclass/rf_referrer_class.php';

// create class object for class function access
$objCallData = new Referrer_Class();

if($_SESSION['validUser']) {
	?><html>
		<head>
			<title>Manage Referrer</title>
			<meta name="generator" http-equiv="content-type" content="text/html">
			<script type="text/javascript" src="<?php echo $javaScript; ?>datetimepicker.js"></script>
			<script type="text/javascript" src="<?php echo $javaScript; ?>validate.js"></script>
			<script type="text/javascript" src="<?php echo $javaScript; ?>rf_validate.js"></script>
		</head>

		<body><?
			include("includes/header.php");?><br><?

			$a = $_REQUEST["a"];
			$recid = $_REQUEST["recid"];
			$sql = $_REQUEST["sql"]?$_REQUEST["sql"]:'';

			switch ($sql) {
				case "insert":
					$objCallData->sql_insert();
					header('location: rf_referrer.php');
					break;

				case "update":
					$objCallData->sql_update();
					break;

				case "delete":
					$objCallData->sql_delete($_REQUEST['recid']);
					header('location: rf_referrer.php');
					break;
			}

			switch ($a) {
			case "add":
				include('views/rf_referrer_add.php');
				break;

			case "view":

				//Get FormCode
				$formcode = $commonUses->getFormCode("Manage Referrer");
				$access_file_level = $commonUses->checkFileAccess($_SESSION['staffcode'],$formcode);

				$arrReferer = $objCallData->sql_select();
				$arrRefererData = $arrReferer[$recid];
				include('views/rf_referrer_view.php');
				break;

			case "edit":
				$arrReferer = $objCallData->sql_select();
				$arrRefererData = $arrReferer[$recid];
				include('views/rf_referrer_edit.php');
				break;

			default:

				//Get FormCode
				$formcode = $commonUses->getFormCode("Manage Referrer");
				$access_file_level = $commonUses->checkFileAccess($_SESSION['staffcode'],$formcode);

				//If View, Add, Edit, Delete all set to N
				if($access_file_level == 0) {
					echo "You are not authorised to view this file.";
				}
				else {
					$arrReferer = $objCallData->sql_select();
					include('views/rf_referrer_list.php');
				}
				
				break;
			}
			
	include("includes/footer.php");
}  
else {
	header("Location:index.php?msg=timeout");
}
?>