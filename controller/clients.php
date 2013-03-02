<?
include("../include/connection.php");
include("../model/client_class.php");
include("../include/php_functions.php");

$objScr = new Client();

$a = $_REQUEST["a"];
$recid = $_REQUEST["recid"];
$sql = $_REQUEST["sql"]?$_REQUEST["sql"]:'';

switch ($sql) {
	case "insert":
	
		$_SESSION['CLIENTNAME'] = $objScr->fetch_client_name();
		if(!in_array($_REQUEST['txtName'], $_SESSION['CLIENTNAME'])) 
		{
			//Insert New Client By Practice Login into Database
			$objScr->sql_insert();
			
			//Get Event Status if Event is Active we Get 1 Else 0
			$flagSet = getEventStatus('1');
			
			if($flagSet) //If Flag or Event Active it will Execute
			{
				
				//It will Get Email Id from Which Email Id the Email will Send.
				$fromEmail = get_email_id($_SESSION['PRACTICEID']);

				//It will Get All Details in array format for Send Email	
				$arrEmailInfo = get_email_info('1');

				$from = $fromEmail;
				$to = $arrEmailInfo['event_to'];
				$cc = $arrEmailInfo['event_cc'];
				$subject = $arrEmailInfo['event_subject'];
				$content = $arrEmailInfo['event_content'];

				//Include Send Mail File For To Generate Email
				include_once('../include/send_mail.php');
				
				//It will Get all Necessary Information and Send Email to Admin Person
				send_mail($from, $to, $cc, $subject, $content);
			}
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
}

switch ($a) {
case "add":
	$_SESSION['CLIENTNAME'] = $objScr->fetch_client_name();
	$arrClientType = $objScr->fetchType();
	include('../view/clients_add.php');
	break;

case "edit":
	$_SESSION['CLIENTNAME'] = $objScr->fetch_client_name($recid);
	$arrClients = $objScr->sql_select();
	$arrClientsData = $arrClients[$recid];
	$arrClientType = $objScr->fetchType();
	include('../view/clients_edit.php');
	break;

default:
	$arrClients = $objScr->sql_select();
	$arrClientType = $objScr->fetchType();
	include('../view/clients_list.php');
	break;
}
?>