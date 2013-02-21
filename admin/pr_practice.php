<?php 
ob_start();
include 'common/varDeclare.php';
include 'dbclass/commonFunctions_class.php';
include 'dbclass/pr_practice_class.php';

// create class object for class function access
$objCallData = new Practice_Class();

if($_SESSION['validUser']) {
	?><html>
		<head>
			<title>Manage Practice</title>
			<meta name="generator" http-equiv="content-type" content="text/html">
			<script type="text/javascript" src="<?php echo $javaScript; ?>datetimepicker.js"></script>
			<script type="text/javascript" src="<?php echo $javaScript; ?>validate.js"></script>
			<script type="text/javascript" src="<?php echo $javaScript; ?>pr_validate.js"></script>
		</head>

		<body><?
			include("includes/header.php");?><br><?

			$a = $_REQUEST["a"];
			$recid = $_REQUEST["recid"];
			$sql = $_REQUEST["sql"]?$_REQUEST["sql"]:'';

			switch ($sql) {
				case "insert":
					$objCallData->sql_insert();
					header('location: pr_practice.php');
					break;

				case "update":
					$objCallData->sql_update();
					break;

				case "delete":
					$objCallData->sql_delete($_REQUEST['recid']);
					header('location: pr_practice.php');
					break;
			}

			switch ($a) {
			case "add":
				include('views/pr_practice_add.php');
				break;

			case "view":
				$arrPractice = $objCallData->sql_select();
				$arrPracticeData = $arrPractice[$recid];
				include('views/pr_practice_view.php');
				break;

			case "edit":
				$arrPractice = $objCallData->sql_select();
				$arrPracticeData = $arrPractice[$recid];
				include('views/pr_practice_edit.php');
				break;

			default:
				//Get FormCode
				$formcode = $commonUses->getFormCode("Manage Practice");
				$access_file_level = $commonUses->checkFileAccess($_SESSION['staffcode'],$formcode);

				//If View, Add, Edit, Delete all set to N
				if($access_file_level == 0) {
					echo "You are not authorised to view this file.";
				}
				else {
					$arrPractice = $objCallData->sql_select();
					include('views/pr_practice_list.php');
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