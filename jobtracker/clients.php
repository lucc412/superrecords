<?php
include("include/common.php");
include(MODEL."client_class.php");

$objScr = new Client();

$a = $_REQUEST["a"];
$recid = $_REQUEST["recid"];
$sql = $_REQUEST["sql"]?$_REQUEST["sql"]:'';

switch ($sql) {
	case "insert":
	
		$_SESSION['CLIENTNAME'] = $objScr->fetch_client_name();
		if(!in_array($_REQUEST['txtName'], $_SESSION['CLIENTNAME'])) {
			
			//Insert New Client By Practice Login into Database
			$clientId = $objScr->sql_insert();
                        
			/* send mail function starts here */
			$pageCode = 'NEWCL';	
			
			// check if event is active or inactive [This will return TRUE or FALSE as per result]
			$flagSet = getEventStatus($pageCode);

			// if event is active it go for mail function
			if($flagSet) {

				//It will Get All Details in array format for Send Email	
				$arrEmailInfo = get_email_info($pageCode);
				
				// fetch email id of sr manager & sales person of practice
				$to = fetch_prac_designation($_SESSION['PRACTICEID'],true,true,true,true);
				$cc = $arrEmailInfo['event_cc'];
				$bcc = $arrEmailInfo['event_bcc'];
				$from = $arrEmailInfo['event_from'];
				$subject = $arrEmailInfo['event_subject'];
				$content = $arrEmailInfo['event_content'];
				$content = replaceContent($content, NULL, $_SESSION['PRACTICEID'], $clientId);
				send_mail($from, $to, $cc, $bcc, $subject, $content);
			}
			/* send mail function ends here */
			header("location: clients.php");
		}
		else 
		{
			header("location: clients.php?a=add&flagDuplicate=Y");
		}
		break;

	case "update":
		$_SESSION['CLIENTNAME'] = $objScr->fetch_client_name($_REQUEST['recid']);
		if(!in_array($_REQUEST['txtName'], $_SESSION['CLIENTNAME'])) {
			$objScr->sql_update();
		}
		else {
			header("location: clients.php?a=edit&recid={$_REQUEST['recid']}&flagDuplicate=Y");
		}
		break;

	case "delete":
		$objScr->sql_delete($_REQUEST['recid']);
		break;
		
	case "ajaxsearch":
		$arrClients = $objScr->sql_select($_REQUEST['clientNameSearch']);
		$arrClientType = $objScr->fetchType();
		include(VIEW.'clients_list.php');
		exit;
		break;
}

switch ($a) {
case "add":
	$_SESSION['CLIENTNAME'] = $objScr->fetch_client_name();
	$arrClientType = $objScr->fetchType();
	include(VIEW.'clients_add.php');
	break;

case "edit":
	$_SESSION['CLIENTNAME'] = $objScr->fetch_client_name($recid);
	$arrClients = $objScr->sql_select();
	$arrClientsData = $arrClients[$recid];
	$arrClientType = $objScr->fetchType();
	include(VIEW.'clients_edit.php');
	break;

default:
	$arrClients = $objScr->sql_select();
	$arrClientType = $objScr->fetchType();
	include(VIEW.'clients_list.php');
	break;
}
?>