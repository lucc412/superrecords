<?php 
ob_start();
include 'dbclass/commonFunctions_class.php';
include 'dbclass/lead_class.php';

// create class object for class function access
$objCallData = new Lead_Class();
//print_r($_SESSION);
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

				$arrLead = $objCallData->sql_select($a,$recid);
				$arrLeadData = $arrLead[$recid];
				include('views/lead_view.php');
				break;

			case "edit":
				$arrLead = $objCallData->sql_select($a,$recid);
				$arrLeadData = $arrLead[$recid];
				include('views/lead_edit.php');
				break;

			case "reset":
			
				//Get FormCode
				$formcode = $commonUses->getFormCode("Manage Lead");
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
					$arrLead = $objCallData->sql_select();
					include('views/lead_list.php');
				}
				
				//header('location: lead.php');
				break;
				

			default:
				
				//Get FormCode
				$formcode = $commonUses->getFormCode("Manage Lead");
				$access_file_level = $commonUses->checkFileAccess($_SESSION['staffcode'],$formcode);

				$checkstr = "";
				if ($wholeonly) $checkstr = " checked";

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