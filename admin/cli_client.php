<?php 
ob_start();
include 'common/varDeclare.php';
include 'dbclass/commonFunctions_class.php';
include 'dbclass/cli_client_class.php';
include (PHPFUNCTION);
include("includes/header.php");

// create class object for class function access
$objCallData = new Client_Class();


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
	?>
	<br/><?

			$a = $_REQUEST["a"];
			$b = $_REQUEST["b"];
			$recid = $_REQUEST["recid"];
			$sql = $_REQUEST["sql"]?$_REQUEST["sql"]:'';

			switch ($sql) {
				case "insert":

					// insert new client
					$objCallData->sql_insert();
				
					$srManager = $_REQUEST['lstSrManager'];
					$salePerson = $_REQUEST['lstSalesPerson'];
					$practiceId = $_REQUEST['lstPractice'];
					$clientName = $_REQUEST['cliName'];
				
					/* send mail function starts here */
					$pageCode = 'NEWCL';
					// check if event is active or inactive [This will return TRUE or FALSE as per result]
					$flagSet = getEventStatus($pageCode);
					// if event is active it go for mail function
					if($flagSet) {

						// It will Get All Details in array format for Send Email	
						$arrEmailInfo = get_email_info($pageCode);

						// fetch email id of sr manager & sales person of practice
						$to = fetch_prac_designation($practiceId,true,true,true,true);
						$cc = $arrEmailInfo['event_cc'];
						$bcc = $arrEmailInfo['event_bcc'];
						$from = $arrEmailInfo['event_from'];
						$subject = $arrEmailInfo['event_subject'];
						$content = $arrEmailInfo['event_content'];
						$content = replaceContent($content, NULL,$practiceId,NULL,NULL);
						$content = str_replace('CLIENTNAME',$clientName,$content);
						//It will include send_mail.php to send Email.
						include_once(MAIL);
						send_mail($from, $to, $cc, $bcc, $subject, $content);
					}
					/* send mail function ends here */
					
					header('location: cli_client.php');
					break;

				case "update":
					$objCallData->sql_update();
					header('location: cli_client.php');
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

				$filter = "";
				$filterfield = "";
				$wholeonly = "";
				$checkstr = "";
				if ($wholeonly) $checkstr = " checked";

				//Get FormCode
				$formcode = $commonUses->getFormCode("Manage Client");
				$access_file_level = $commonUses->checkFileAccess($_SESSION['staffcode'],$formcode);

				$arrClient = $objCallData->sql_select($a,$recid);
				$arrClientData = $arrClient[$recid];
				$arrEmployees = $objCallData->fetchEmployees();
				include('views/cli_client_view.php');
				break;

			case "edit":
			
				$filter = "";
				$filterfield = "";
				$wholeonly = "";
				$checkstr = "";
				if ($wholeonly) $checkstr = " checked";
			
				$arrClient = $objCallData->sql_select($a,$recid);
                                
				$arrClientData = $arrClient[$recid];
				$arrEmployees = $objCallData->fetchEmployees();
				include('views/cli_client_edit.php');
				break;
			
			case "reset":
			
				//Get FormCode
				$formcode = $commonUses->getFormCode("Manage Client");
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
					$arrClient = $objCallData->sql_select();
					$arrEmployees = $objCallData->fetchEmployees();
					include('views/cli_client_list.php');
				}
				
				//header('location: cli_client.php');
				break;
				
			default:
			
				//Get FormCode
				$formcode = $commonUses->getFormCode("Manage Client");
				$access_file_level = $commonUses->checkFileAccess($_SESSION['staffcode'],$formcode);

				$checkstr = "";
				if ($wholeonly) $checkstr = " checked";
				 
				//If View, Add, Edit, Delete all set to N
				if($access_file_level == 0) {
					echo "You are not authorised to view this file.";
				}
				else {
					$arrClient = $objCallData->sql_select();
					$arrEmployees = $objCallData->fetchEmployees();
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