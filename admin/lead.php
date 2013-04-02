<?php 
ob_start();
include 'common/varDeclare.php';
include 'dbclass/commonFunctions_class.php';
include 'dbclass/lead_class.php';

// create class object for class function access
$objCallData = new Lead_Class();
//print_r($_SESSION);
if($_SESSION['validUser']) {
	?><html>
		<head>
			<title>Manage Lead</title>
			<meta name="generator" http-equiv="content-type" content="text/html">
			<script type="text/javascript" src="<?php echo $javaScript; ?>datetimepicker.js"></script>
			<script type="text/javascript" src="<?php echo $javaScript; ?>validate.js"></script>
			<script type="text/javascript" src="<?php echo $javaScript; ?>lead_validate.js"></script>
			
			<!-- Added by Yogi 24-1-2013 for Not succefull drop down -->
		</head>

		<body><?
			include("includes/header.php");?><br><?

			$a = $_REQUEST["a"];
			$recid = $_REQUEST["recid"];
			$sql = $_REQUEST["sql"]?$_REQUEST["sql"]:'';

			switch ($sql) {
				case "insert":
					$objCallData->sql_insert();
					header('location: lead.php');
					break;

				case "update":
					$objCallData->sql_update();
					break;

				case "delete":
					$objCallData->sql_delete($_REQUEST['recid']);
					header('location: lead.php');
					break;
			}

			switch ($a) {
			case "add":
				include('views/lead_add.php');
				break;

			case "view":

				//Get FormCode
				$formcode = $commonUses->getFormCode("Manage Lead");
				$access_file_level = $commonUses->checkFileAccess($_SESSION['staffcode'],$formcode);

				$arrLead = $objCallData->sql_select();
				$arrLeadData = $arrLead[$recid];
				include('views/lead_view.php');
				break;

			case "edit":
				$arrLead = $objCallData->sql_select();
				$arrLeadData = $arrLead[$recid];
				include('views/lead_edit.php');
				break;

			default:
				
				//Get FormCode
				$formcode = $commonUses->getFormCode("Manage Lead");
				$access_file_level = $commonUses->checkFileAccess($_SESSION['staffcode'],$formcode);

				//If View, Add, Edit, Delete all set to N
				if($access_file_level == 0) {
					echo "You are not authorised to view this file.";
				}
				else {
					$arrLead = $objCallData->sql_select();
					include('views/lead_list.php');
				}

				break;
			}
			
	include("includes/footer.php");
}  
else {
	header("Location:index.php?msg=timeout");
}
?>