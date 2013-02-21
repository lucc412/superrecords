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

			$arrEmployees = $objCallData->sql_select();
			include('views/landing_page.php');
			
			include('includes/footer.php');
}  
else {
	header("Location:index.php?msg=timeout");
}
?>