<?php 
ob_start();
include 'common/varDeclare.php';
include 'dbclass/commonFunctions_class.php';
include 'dbclass/landing_page_class.php';

// create class object for class function access
$objCallData = new Landing_Class();

if($_SESSION['validUser']) {
	?><html>
		<head>
			<title>Default Landing URL</title>
			<meta name="generator" http-equiv="content-type" content="text/html">
			<script type="text/javascript" src="<?=$javaScript;?>landing_page_validate.js"></script>
		</head>

		<body><?
			include("includes/header.php");?><br><?

			if(!empty($_REQUEST['doAction'])) {
				$objCallData->sql_update($_REQUEST["employeeId"]);
			}

			//Get FormCode
			$formcode = $commonUses->getFormCode("Default Landing URL");
			$access_file_level = $commonUses->checkFileAccess($_SESSION['staffcode'],$formcode);

			//If View, Add, Edit, Delete all set to N
			if($access_file_level == 0) {
				echo "You are not authorised to view this file.";
			}
			else {
				// DB function to fetch all landing URL's here 
				$arrEmployees = $objCallData->sql_select();
				include('views/landing_page.php');
			}

			include('includes/footer.php');
}  
else {
	header("Location:index.php?msg=timeout");
}
?>