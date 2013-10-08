<?php 
ob_start();
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
					$clientId = $objCallData->sql_insert();
					$arrPracInfo = $objCallData->fetchPracticeInfo($clientId);

					$srManager = $arrPracInfo[1];
					$practiceId = $_REQUEST['lstPractice'];
					$clientName = $_REQUEST['cliName'];
				
					/* send mail function starts here */

					// new client added
					$flagSet = getEventStatus('NEWCL');
					if($flagSet) {
						$arrEmailInfo = get_email_info('NEWCL');
						$to = fetch_prac_designation($practiceId,true,true,true,true);
						$cc = $arrEmailInfo['event_cc'];
						$bcc = $arrEmailInfo['event_bcc'];
						$from = $arrEmailInfo['event_from'];
						$subject = $arrEmailInfo['event_subject'];
						$content = $arrEmailInfo['event_content'];
						$content = replaceContent($content, NULL,$practiceId,NULL,NULL);
						$content = str_replace('CLIENTNAME',$clientName,$content);
						include_once(MAIL);
						send_mail($from, $to, $cc, $bcc, $subject, $content);
					}

					// Sr. Accountant Comp assigned to client
					$flagSet = getEventStatus('COMCL');
					if($flagSet) {
						if(!empty($_REQUEST['lstSrAccntComp'])) {
							$arrEmailInfo = get_email_info('COMCL');
							$srManagerEmail = fetchStaffInfo($srManager, 'email');
							$srCompEmail = fetchStaffInfo($_REQUEST["lstSrAccntComp"], 'email');
							$to = $srManagerEmail.','.$srCompEmail;
							$cc = $arrEmailInfo['event_cc'];
							$bcc = $arrEmailInfo['event_bcc'];
							$from = $arrEmailInfo['event_from'];
							$subject = $arrEmailInfo['event_subject'];
							$content = $arrEmailInfo['event_content'];
							$content = str_replace('CLIENTNAME',$clientName,$content);
							include_once(MAIL);
							send_mail($from, $to, $cc, $bcc, $subject, $content);
						}
					}

					// Sr. Accountant Audit assigned to client
					$flagSet = getEventStatus('AUDCL');
					if($flagSet) {
						if(!empty($_REQUEST['lstSrAccntAudit'])) {
							$arrEmailInfo = get_email_info('AUDCL');
							$srManagerEmail = fetchStaffInfo($srManager, 'email');
							$srCompEmail = fetchStaffInfo($_REQUEST["lstSrAccntAudit"], 'email');
							$to = $srManagerEmail.','.$srCompEmail;
							$cc = $arrEmailInfo['event_cc'];
							$bcc = $arrEmailInfo['event_bcc'];
							$from = $arrEmailInfo['event_from'];
							$subject = $arrEmailInfo['event_subject'];
							$content = $arrEmailInfo['event_content'];
							$content = str_replace('CLIENTNAME',$clientName,$content);
							include_once(MAIL);
							send_mail($from, $to, $cc, $bcc, $subject, $content);
						}
					}

					// Jnr. Accountant Comp assigned to client
					$flagSet = getEventStatus('JNRCL');
					if($flagSet) {
						if(!empty($_REQUEST['lstTeamMember'])) {
							$arrEmailInfo = get_email_info('JNRCL');
							$srManagerEmail = fetchStaffInfo($srManager, 'email');
							$srCompEmail = fetchStaffInfo($_REQUEST["lstTeamMember"], 'email');
							$to = $srManagerEmail.','.$srCompEmail;
							$cc = $arrEmailInfo['event_cc'];
							$bcc = $arrEmailInfo['event_bcc'];
							$from = $arrEmailInfo['event_from'];
							$subject = $arrEmailInfo['event_subject'];
							$content = $arrEmailInfo['event_content'];
							$content = str_replace('CLIENTNAME',$clientName,$content);
							include_once(MAIL);
							send_mail($from, $to, $cc, $bcc, $subject, $content);
						}
					}
					/* send mail function ends here */
					
					header('location: cli_client.php');
					break;

				case "update":
					$arrPracInfo = $objCallData->fetchPracticeInfo($_REQUEST['recid']);
					$practiceId = $arrPracInfo[0];
					$srManager = $arrPracInfo[1];

					// Sr. Accountant Comp assigned to client
					$flagSet = getEventStatus('COMCL');
					if($flagSet) {
						$newCompManager = $_REQUEST['lstSrAccntComp'];
						if(!empty($newCompManager)) {
							$oldCompManager = $objCallData->fetchManager($_REQUEST['recid'], 'sr_accnt_comp');
							if($oldCompManager != $newCompManager) {
								$arrEmailInfo = get_email_info('COMCL');
								$srManagerEmail = fetchStaffInfo($srManager, 'email');
								$compManagerEmail = fetchStaffInfo($_REQUEST["lstSrAccntComp"], 'email');
								$to = $srManagerEmail.','.$compManagerEmail;
								$cc = $arrEmailInfo['event_cc'];
								$bcc = $arrEmailInfo['event_bcc'];
								$from = $arrEmailInfo['event_from'];
								$subject = $arrEmailInfo['event_subject'];
								$content = $arrEmailInfo['event_content'];
								$content = replaceContent($content,NULL,NULL,$_REQUEST['recid']);
								include_once(MAIL);
								send_mail($from, $to, $cc, $bcc, $subject, $content);
							}
						}
					}

					// Sr. Accountant Audit assigned to client
					$flagSet = getEventStatus('AUDCL');
					if($flagSet) {
						$newCompManager = $_REQUEST['lstSrAccntAudit'];
						if(!empty($newCompManager)) {
							$oldCompManager = $objCallData->fetchManager($_REQUEST['recid'], 'sr_accnt_audit');
							if($oldCompManager != $newCompManager) {
								$arrEmailInfo = get_email_info('AUDCL');
								$srManagerEmail = fetchStaffInfo($srManager, 'email');
								$auditManagerEmail = fetchStaffInfo($_REQUEST["lstSrAccntAudit"], 'email');
								$to = $srManagerEmail.','.$auditManagerEmail;
								$cc = $arrEmailInfo['event_cc'];
								$bcc = $arrEmailInfo['event_bcc'];
								$from = $arrEmailInfo['event_from'];
								$subject = $arrEmailInfo['event_subject'];
								$content = $arrEmailInfo['event_content'];
								$content = replaceContent($content,NULL,NULL,$_REQUEST['recid']);
								include_once(MAIL);
								send_mail($from, $to, $cc, $bcc, $subject, $content);
							}
						}
					}

					// Jnr. Accountant Comp assigned to client
					$flagSet = getEventStatus('JNRCL');
					if($flagSet) {
						$newCompManager = $_REQUEST['lstTeamMember'];
						if(!empty($newCompManager)) {
							$oldCompManager = $objCallData->fetchManager($_REQUEST['recid'], 'team_member');
							if($oldCompManager != $newCompManager) {
								$arrEmailInfo = get_email_info('JNRCL');
								$srManagerEmail = fetchStaffInfo($srManager, 'email');
								$compManagerEmail = fetchStaffInfo($_REQUEST["lstTeamMember"], 'email');
								$to = $srManagerEmail.','.$compManagerEmail;
								$cc = $arrEmailInfo['event_cc'];
								$bcc = $arrEmailInfo['event_bcc'];
								$from = $arrEmailInfo['event_from'];
								$subject = $arrEmailInfo['event_subject'];
								$content = $arrEmailInfo['event_content'];
								$content = replaceContent($content,NULL,NULL,$_REQUEST['recid']);
								include_once(MAIL);
								send_mail($from, $to, $cc, $bcc, $subject, $content);
							}
						}
					}

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