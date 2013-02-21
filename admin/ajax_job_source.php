<?php
include("dbclass/commonFunctions_class.php");
include("dbclass/client_db_class.php");

$practiceId = $_REQUEST['practiceId'];
$referralId = $_REQUEST['referralId'];
$doAction = $_REQUEST['doAction'];
$jobSource = $_REQUEST['jobSource'];

switch($doAction) {
	case 'JobSource':

		if($jobSource == '1') {
			$returnStr = sql_select_practice();
		}
		else {
			$returnStr = sql_select_referral();
		}
	break;
}

// fetch practices
function sql_select_practice()
{
	$sql = "SELECT t1.`id`, t1.`name`
			FROM `pr_practice` t1 ";
			
	$res = mysql_query($sql) or die(mysql_error());
	$count = mysql_num_rows($res);

	$strReturn = "";
	if(!empty($count)) {
		while ($rowData = mysql_fetch_assoc($res)){
			$strReturn .= $rowData['id'] . '_' . $rowData['name'] . '+';
		}
		$strReturn = rtrim($strReturn, '+');
	}
	return $strReturn;
}

// fetch referrals
function sql_select_referral()
{
	$sql = "SELECT t1.`id`, t1.`name` 
			FROM `rf_referrer` t1";
			
	$res = mysql_query($sql) or die(mysql_error());
	$count = mysql_num_rows($res);

	$strReturn = "";
	if(!empty($count)) {
		while ($rowData = mysql_fetch_assoc($res)){
			$strReturn .= $rowData['id'] . '_' . $rowData['name'] . '+';
		}
		$strReturn = rtrim($strReturn, '+');
	}
	return $strReturn;
}

print($returnStr);
?>