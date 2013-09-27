<?php
/*
	Task : Functions to load associative clients, jobs as per selected practice [Pages: clients, jobs, tasks]
	Created By	: Dhiraj Sahu 
	Modified By : Disha Goyal
	Created on  : 29-Dec-2012
	Modified on : 26-Jan-2013 
*/

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

	case 'LoadPanel':
			$returnStr = sql_select_panel($itemId);
			break;

	case 'LoadTeamMember':
			$returnStr = fetch_team_member($itemId);
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
			WHERE client_id=".$itemId." 
			AND discontinue_date IS NULL
			AND job_submitted = 'Y'
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
	print($strReturn);
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

// fetch sr manager, india manager, sales manager, team member for selected practice
function sql_select_panel($itemId)
{
	$sql = "SELECT id, sr_manager, india_manager, sales_person, audit_manager
			FROM pr_practice
			WHERE id=".$itemId;
			
	$res = mysql_query($sql) or die(mysql_error());
	$count = mysql_num_rows($res);

	if(!empty($count))
	{
		// fetch array of name of all employees
		$arrEmployees = fetchEmployees();

		$rowData = mysql_fetch_assoc($res);
		$srManager = $arrEmployees[$rowData['sr_manager']];
		$salesPrson = $arrEmployees[$rowData['sales_person']];
		$inManager = $arrEmployees[$rowData['india_manager']];
                $auditManager = $arrEmployees[$rowData['audit_manager']];

		// set string of srManager, salesPrson, inManager, teamMember
		$strReturn = $srManager .'~'. $salesPrson .'~'. $inManager.'~'. $teamMember.'~'.$auditManager;
	}
	return $strReturn;
}

// fetch team member for selected client
function fetch_team_member($clientId) {
	$sql = "SELECT team_member
			FROM client
			WHERE client_id=".$clientId;
			
	$res = mysql_query($sql) or die(mysql_error());
	$count = mysql_num_rows($res);

	if(!empty($count))
	{
		// fetch array of name of all employees
		$arrEmployees = fetchEmployees();

		$rowData = mysql_fetch_assoc($res);
		$teamMember = $arrEmployees[$rowData['team_member']];
	}
	return $teamMember;
}

function fetchEmployees() {	

	$qrySel = "SELECT ss.stf_Code, CONCAT_WS(' ', cc.con_Firstname, cc.con_Lastname) staffName 
				 FROM stf_staff ss, con_contact cc
				 WHERE ss.stf_CCode = cc.con_Code ";

	$fetchResult = mysql_query($qrySel);		
	while($rowData = mysql_fetch_assoc($fetchResult)) {
		$arrEmployees[$rowData['stf_Code']] = $rowData['staffName'];
	}
	return $arrEmployees;	
} 

print($returnStr);
?>