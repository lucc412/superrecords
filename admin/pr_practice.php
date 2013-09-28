<?php 
ob_start();
include 'common/varDeclare.php';
include(PHPFUNCTION);
include 'dbclass/commonFunctions_class.php';
include 'dbclass/pr_practice_class.php';
include("includes/header.php");

// create class object for class function access
$objCallData = new Practice_Class();

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

					
					// check if email address is unique
					$flagExists = $objCallData->checkEmailExists($_REQUEST['email']);

					if(!$flagExists) {
						header("Location: pr_practice.php?a=add&flagErrMsg=Y");
						exit;
					}
					
				
					$practiceId = $objCallData->sql_insert();

					/* send mail function starts here */
					$pageCode = 'NEWPR';	
					// check if event is active or inactive [This will return TRUE or FALSE as per result]
					$flagSet = getEventStatus($pageCode);
					// if event is active it go for mail function
					if($flagSet) {
						//It will Get All Details in array format for Send Email	
						$arrEmailInfo = get_email_info($pageCode);
						// TO mail parameter
						if(!empty($_REQUEST['lstSrManager'])) {
							$srManagerEmail = fetchStaffInfo($_REQUEST["lstSrManager"], 'email');
						}
						$to = $srManagerEmail;
						$cc = $arrEmailInfo['event_cc'];
						$subject = $arrEmailInfo['event_subject'];
						$content = $arrEmailInfo['event_content'];
						$content = replaceContent($content, $_REQUEST["lstSalesPerson"], $practiceId);
						include_once(MAIL);
						send_mail($to, $cc, $subject, $content);
					}
					/* send mail function ends here */
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

				//Get FormCode
				$formcode = $commonUses->getFormCode("Manage Practice");
				$access_file_level = $commonUses->checkFileAccess($_SESSION['staffcode'],$formcode);

				$arrPractice = $objCallData->sql_select($a,$recid);
				$arrPracticeData = $arrPractice[$recid];
				include('views/pr_practice_view.php');
				break;

			case "edit":
				$arrPractice = $objCallData->sql_select($a,$recid);
				$arrPracticeData = $arrPractice[$recid];
				include('views/pr_practice_edit.php');
				break;

			case "reset":
			
				//Get FormCode
				$formcode = $commonUses->getFormCode("Manage Practice");
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
					$arrPractice = $objCallData->sql_select();
					include('views/pr_practice_list.php');
				}
				
				//header('location: lead.php');
				break;

			default:

				//Get FormCode
				$formcode = $commonUses->getFormCode("Manage Practice");
				$access_file_level = $commonUses->checkFileAccess($_SESSION['staffcode'],$formcode);

				$checkstr = "";
				if ($wholeonly) $checkstr = " checked";

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
		
}  
else {
	header("Location:index.php?msg=timeout");
}
?>