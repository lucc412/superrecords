<?php 
ob_start();
include 'dbclass/commonFunctions_class.php';
include 'dbclass/pr_practice_class.php';
include(PHPFUNCTION);
include("includes/header.php");

// create class object for class function access
$objCallData = new Practice_Class();

if($_SESSION['validUser']) {
	
	if (isset($_POST["filter"])) $filter = @$_POST["filter"];
	if (isset($_POST["filter_field"])) $filterfield = @$_POST["filter_field"];
	$wholeonly = false;
	if (isset($_POST["wholeonly"])) $wholeonly = @$_POST["wholeonly"];
	if (isset($_REQUEST["order"])) $order = @$_REQUEST["order"]; else $order = 'pracId';
        if (isset($_REQUEST["type"])) $ordertype = @$_REQUEST["type"];
        
	if (!isset($filter) && isset($_SESSION["filter"])) $filter = $_SESSION["filter"];
	if (!isset($filterfield) && isset($_SESSION["filter_field"])) $filterfield = $_SESSION["filter_field"];
        if (!isset($order) && isset($_SESSION["order"])) $order = $_SESSION["order"];
        if (!isset($order) && isset($_SESSION["ordertype"])) $ordertype = $_SESSION["ordertype"];
        

	if (isset($filter)) $_SESSION["filter"] = $filter;
	if (isset($filterfield)) $_SESSION["filter_field"] = $filterfield;
	if (isset($wholeonly)) $_SESSION["wholeonly"] = $wholeonly;	
	if (isset($order)) $_SESSION["order"] = $order;
	if (isset($ordertype)) $_SESSION["ordertype"] = $ordertype;	

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

					// new practice added
					$flagSet = getEventStatus('NEWPR');
					if($flagSet) {
						$arrEmailInfo = get_email_info('NEWPR');
						if(!empty($_REQUEST['lstSrManager'])) {
							$srManagerEmail = fetchStaffInfo($_REQUEST["lstSrManager"], 'email');
						}
						$to = $srManagerEmail;
						$from = $arrEmailInfo['event_from'];
						$cc = $arrEmailInfo['event_cc'];
						$bcc = $arrEmailInfo['event_bcc'];
						$subject = $arrEmailInfo['event_subject'];
						$content = $arrEmailInfo['event_content'];
						$content = replaceContent($content, $_REQUEST["lstSalesPerson"], $practiceId);
						 
						send_mail($from, $to, $cc, $bcc, $subject, $content);
					}

					// india manager assigned to practice
					$flagSet = getEventStatus('COMPR');
					if($flagSet) {
						if(!empty($_REQUEST['lstManager'])) {
							$arrEmailInfo = get_email_info('COMPR');
							$srManagerEmail = fetchStaffInfo($_REQUEST["lstSrManager"], 'email');
							$compManagerEmail = fetchStaffInfo($_REQUEST["lstManager"], 'email');
							$to = $srManagerEmail.','.$compManagerEmail;
							$cc = $arrEmailInfo['event_cc'];
							$bcc = $arrEmailInfo['event_bcc'];
							$from = $arrEmailInfo['event_from'];
							$subject = $arrEmailInfo['event_subject'];
							$content = $arrEmailInfo['event_content'];
							$content = replaceContent($content,NULL,$practiceId,NULL,NULL);
							 
							send_mail($from, $to, $cc, $bcc, $subject, $content);
						}
					}

					// audit manager assigned to practice
					$flagSet = getEventStatus('AUDPR');
					if($flagSet) {
						if(!empty($_REQUEST['lstAuditManager'])) {
							$arrEmailInfo = get_email_info('AUDPR');
							$srManagerEmail = fetchStaffInfo($_REQUEST["lstSrManager"], 'email');
							$auditManagerEmail = fetchStaffInfo($_REQUEST["lstAuditManager"], 'email');
							$to = $srManagerEmail.','.$auditManagerEmail;
							$cc = $arrEmailInfo['event_cc'];
							$bcc = $arrEmailInfo['event_bcc'];
							$from = $arrEmailInfo['event_from'];
							$subject = $arrEmailInfo['event_subject'];
							$content = $arrEmailInfo['event_content'];
							$content = replaceContent($content,NULL,$practiceId,NULL,NULL);
							 
							send_mail($from, $to, $cc, $bcc, $subject, $content);
						}
					}
					/* send mail function ends here */
					header('location: pr_practice.php');
					break;

				case "update":

					// india manager assigned to practice
					$flagSet = getEventStatus('COMPR');
					if($flagSet) {
						$newCompManager = $_REQUEST['lstManager'];
						if(!empty($newCompManager)) {
							$oldCompManager = $objCallData->fetchManager($_REQUEST['recid'], 'india_manager');
							if($oldCompManager != $newCompManager) {
								$arrEmailInfo = get_email_info('COMPR');
								$srManagerEmail = fetchStaffInfo($_REQUEST["lstSrManager"], 'email');
								$compManagerEmail = fetchStaffInfo($_REQUEST["lstManager"], 'email');
								$to = $srManagerEmail.','.$compManagerEmail;
								$cc = $arrEmailInfo['event_cc'];
								$bcc = $arrEmailInfo['event_bcc'];
								$from = $arrEmailInfo['event_from'];
								$subject = $arrEmailInfo['event_subject'];
								$content = $arrEmailInfo['event_content'];
								$content = replaceContent($content,NULL,$_REQUEST['recid'],NULL,NULL);
								 
								send_mail($from, $to, $cc, $bcc, $subject, $content);
							}
						}
					}

					// audit manager assigned to practice
					$flagSet = getEventStatus('AUDPR');
					if($flagSet) {
						$newAudtManager = $_REQUEST['lstAuditManager'];
						if(!empty($newAudtManager)) {
							$oldAudtManager = $objCallData->fetchManager($_REQUEST['recid'], 'audit_manager');
							if($oldAudtManager != $newAudtManager) {
								$arrEmailInfo = get_email_info('AUDPR');
								$srManagerEmail = fetchStaffInfo($_REQUEST["lstSrManager"], 'email');
								$auditManagerEmail = fetchStaffInfo($_REQUEST["lstAuditManager"], 'email');
								$to = $srManagerEmail.','.$auditManagerEmail;
								$cc = $arrEmailInfo['event_cc'];
								$bcc = $arrEmailInfo['event_bcc'];
								$from = $arrEmailInfo['event_from'];
								$subject = $arrEmailInfo['event_subject'];
								$content = $arrEmailInfo['event_content'];
								$content = replaceContent($content,NULL,$_REQUEST['recid'],NULL,NULL);
								 
								send_mail($from, $to, $cc, $bcc, $subject, $content);
							}
						}
					}
					$objCallData->sql_update();
					header('location: pr_practice.php');
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
                                if ($ordertype == "DESC") { $ordertype = "ASC"; } else { $ordertype = "DESC"; }                                

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