<?php
//************************************************************************************************
//  Task          : Functions to select sub activities of passed master activities
//  Modified By   : Disha Goyal
//  Created on    : 05-Feb-13
//  Last Modified : 05-Feb-13
//************************************************************************************************


include $_SERVER['DOCUMENT_ROOT'].'jobtracker/include/connection.php';
//include 'jobtracker/include/connection.php';

$doAction = $_REQUEST['doAction'];
$itemId = $_REQUEST['itemId'];

switch($doAction) {
	case 'JobType':
			$returnStr = sql_select_subActivity($itemId);
			break;
}

// fetch Sub Activity
function sql_select_subActivity($itemId)
{
	$sql = "SELECT sub_Code, sub_Description 
			FROM sub_subactivity 
			WHERE sas_Code=".$itemId."
			AND display_in_practice = 'yes'
			ORDER BY sub_Order";
		
	$res = mysql_query($sql) or die(mysql_error());
	$count = mysql_num_rows($res);

	$strReturn = "";
	if(!empty($count))
	{
		while ($rowData = mysql_fetch_assoc($res))
		{
			$strReturn .= $rowData['sub_Code'] . '_' . $rowData['sub_Description'] . '+';
		}
		$strReturn = rtrim($strReturn, '+');
	}
	return $strReturn;
}
print($returnStr);
?>
