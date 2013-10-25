<?php
include("include/common.php");
include(MODEL."audit_checklist_class.php");
$objScr = new AuditChecklist();

$sql = $_REQUEST['sql'];
switch ($sql)
{
	case "checklistSelection":
		$arrSelChckList = $objScr->fetch_existing_checklist_selection($_SESSION['jobId']);
		foreach($_POST AS $postName => $postVal) {
			$flagChckList = strstr($postName, "checklist");
			if($flagChckList) {
				$arrFilChckList[] = replaceString('checklist', '', $postName);  
			}
		}
		if(!empty($arrFilChckList) && !empty($arrSelChckList)) {
			$arrAddChckList = array_diff($arrFilChckList, $arrSelChckList);
			$arrRemChckList = array_diff($arrSelChckList, $arrFilChckList);
		}
		else if(!empty($arrFilChckList) && empty($arrSelChckList)) {
			$arrAddChckList = $arrFilChckList;
		}
		$objScr->sql_checklist_selection($arrAddChckList, $arrRemChckList, $_SESSION['jobId']);
		header('location: audit_subchecklist.php');
		break;
}


$a = $_REQUEST['a'];
switch ($a) {
        default :
                $arrChecklist = $objScr->getAuditChecklist($_SESSION['jobId']);
		include(VIEW.'audit_checklist.php');
		break;
}
?>