<?php
//************************************************************************************************
//  Task          : Functions to select details from table based on parameter received.
//  Modified By   : Dhiraj Sahu 
//  Created on    : 29-Dec-2012
//  Last Modified : 26-Jan-2013 
//************************************************************************************************

include("dbclass/commonFunctions_class.php");
include("dbclass/tsk_task_class.php");

$doAction = $_REQUEST['doAction'];
$itemId = $_REQUEST['itemId'];

switch($doAction) {
	case 'Client':
			$returnStr = sql_select_client($itemId);
			break;
	
	case 'Job':
			$returnStr = sql_select_job($itemId);
			break;
			
	case 'SubActivity':
			$returnStr = sql_select_subActivity($itemId);
			break;
}

// fetch Clients
function sql_select_client($itemId)
{
	$sql = "SELECT client_id, client_name
			FROM client  
			WHERE id=".$itemId." 
			ORDER BY client_name";
			
	$res = mysql_query($sql) or die(mysql_error());
	$count = mysql_num_rows($res);

	$strReturn = "";
	if(!empty($count))
	{
		while ($rowData = mysql_fetch_assoc($res))
		{
			$strReturn .= $rowData['client_id'] . '_' . $rowData['client_name'] . '+';
		}
		$strReturn = rtrim($strReturn, '+');
	}
	return $strReturn;
}

// fetch Job Name
function sql_select_job($itemId)
{
	// fetch Job's details for selected Client
	$sql = "SELECT job_id, job_name, period
			FROM job  
			WHERE client_id=".$itemId." AND discontinue_date IS NULL 
			ORDER BY job_name";
	$res = mysql_query($sql) or die(mysql_error());
	$count = mysql_num_rows($res);

	// fetch Client's details
	$qrySelClient = "SELECT client_id, client_name 
				FROM client ".$strWhere." 
				ORDER BY client_name";
	$fetchResult = mysql_query($qrySelClient);		
	while($rowData = mysql_fetch_assoc($fetchResult))
	{
		$arrClient[$rowData['client_id']] = $rowData['client_name'];
	}
	
	// fetch Job types
	$qrySelJobType = "SELECT * FROM sub_subactivity";
		$fetchResult = mysql_query($qrySelJobType);		
		while($rowData = mysql_fetch_assoc($fetchResult))
		{
			$arrJobType[$rowData['sub_Code']] = $rowData['sub_Description'];
		}

	$strReturn = "";
	if(!empty($count))
	{
		while ($rowData = mysql_fetch_assoc($res))
		{
		   $arrJobParts = explode('::', $rowData['job_name']);
		   $jobName = $arrClient[$arrJobParts[0]] . ' - ' . $arrJobParts[1]. ' - ' . $arrJobType[$arrJobParts[2]];
		   $arrJobNames[$rowData['job_id']] = $jobName;
		}

		// Sort array of Job names in ascending order		
		asort($arrJobNames);
		
		foreach($arrJobNames AS $jobId => $jobName)
			$strReturn .= $jobId . '_' . $jobName . '+';

		$strReturn = rtrim($strReturn, '+');
	}
	return $strReturn;
}

// fetch Sub Activity
function sql_select_subActivity($itemId)
{
	$sql = "SELECT sub_Code, sub_Description 
				FROM sub_subactivity 
				WHERE sas_Code=".$itemId." 
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