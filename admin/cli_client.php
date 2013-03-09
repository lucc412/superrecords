<?php 
ob_start();
include 'common/varDeclare.php';
include 'dbclass/commonFunctions_class.php';
include 'dbclass/cli_client_class.php';
include ('../include/php_functions.php');

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
				
				
				$srManager = $_REQUEST['lstSrManager'];
				$salePerson = $_REQUEST['lstSalesPerson'];
				$practiceId = $_REQUEST['lstPractice'];
				$clientName = $_REQUEST['cliName'];
				
				/* send mail function starts here */
					$pageUrl = basename($_SERVER['REQUEST_URI']);
					$arrPageUrl = explode('&',$pageUrl);	
					$pageUrl = $arrPageUrl[0];
					// check if event is active or inactive [This will return TRUE or FALSE as per result]
					$flagSet = getEventStatus($pageUrl);
					// if event is active it go for mail function
					if($flagSet) {

						//It will Get All Details in array format for Send Email	
						$arrEmailInfo = get_email_info($pageUrl);
						//It will Get Email Id from Which Email Id the Email will Send.
						$salePersonEmailId = fetchStaffInfo($salePerson,'email');
						$srManagerEmailId = fetchStaffInfo('113','email');
						$to = $salePersonEmailId.','.$srManagerEmailId.','.'er.anujjaha@gmail.com';
						$cc = $arrEmailInfo['event_cc'];
						$subject = $arrEmailInfo['event_subject'];
						$content = $arrEmailInfo['event_content'];
						$content = replaceContent($content, NULL,$practiceId,NULL,NULL);
						$content = str_replace('CLIENTNAME',$clientName,$content);
						//It will include send_mail.php to send Email.
						include_once(MAIL);
						send_mail($to, $cc, $subject, $content);
					}
					/* send mail function ends here */
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