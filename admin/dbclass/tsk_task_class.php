<?php
//************************************************************************************************
//  Task          : Class and Functions required for Task management
//  Modified By   : Dhiraj Sahu 
//  Created on    : 28-Dec-2012
//  Last Modified : 30-Jan-2013 
//************************************************************************************************  
class Task_Class extends Database { 	
	public function __construct() {
		$this->arrPractice = $this->fetchPractice();
		$this->arrClient = $this->fetchClient();
		$this->arrClientDetails = $this->arrClientDetails();
		$this->arrJob = $this->fetchJob();
		$this->arrJobDetails = $this->fetchJobDetails();
		$this->arrMasterActivity = $this->fetchMasterActivity();
		$this->arrSubActivity = $this->fetchSubActivity();
		$this->arrSrManager = $this->fetchEmployees(true);
		$this->arrEmployees = $this->fetchEmployees(false);
		$this->arrJobType = $this->fetchJobType();
		$this->arrTaskStatus = $this->fetchTaskStatus();
		$this->arrPriority = $this->fetchPriority();
		$this->arrProcessingCycle = $this->fetchProcessingCycle();
  	}	

	public function fetchJobType()
	{
		$qrySel = "SELECT * FROM sub_subactivity";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrJobType[$rowData['sub_Code']] = $rowData;
		}
		return $arrJobType;	
	} 
	
	public function fetchPractice() {		

		$qrySel = "SELECT id, name 
					FROM pr_practice
					ORDER BY name";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrPractice[$rowData['id']] = $rowData['name'];
		}
		return $arrPractice;	
	} 
	
	public function fetchClient($practice_id)
	{		
		$strWhere = "";

		if($practice_id)
			$strWhere = "WHERE id=".$practice_id;
		
		$qrySel = "SELECT client_id, client_name 
					FROM client ".$strWhere." 
					ORDER BY client_name";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrClient[$rowData['client_id']] = $rowData['client_name'];
		}
		return $arrClient;	
	}  
	
	public function arrClientDetails()
	{		
		$qrySel = "SELECT *	FROM client ORDER BY client_name";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrClient[$rowData['client_id']] = $rowData;
		}
		return $arrClient;	
	}  
	
	public function fetchJob($client_id)
	{		
		$strWhere = "";

		if($client_id)
			$strWhere = " WHERE client_id=".$client_id." AND discontinue_date IS NULL ";
		else
			$strWhere = " WHERE discontinue_date IS NULL ";

		$qrySel = "SELECT job_id, job_name 
					FROM job ".$strWhere."
					ORDER BY job_name";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrJob[$rowData['job_id']] = $rowData['job_name'];
		}
		return $arrJob;	
	}  
	
	public function fetchJobDetails()
	{	
		$qrySel = "SELECT * FROM job WHERE discontinue_date IS NULL ORDER BY job_name";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrJob[$rowData['job_id']] = $rowData;
		}
		return $arrJob;	
	}  
	
	public function fetchTaskStatus()
	{		
		$qrySel = "SELECT * FROM task_status ORDER BY description";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrTaskStatus[$rowData['id']] = $rowData['description'];
		}
		return $arrTaskStatus;	
	}  
	
	public function fetchPriority()
	{		
		$qrySel = "SELECT * FROM pri_priority ORDER BY pri_Description";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrPriority[$rowData['pri_Code']] = $rowData['pri_Description'];
		}
		return $arrPriority;	
	}  
	
	public function fetchProcessingCycle()
	{		
		$qrySel = "SELECT * FROM prc_processcycle ORDER BY prc_Description";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrProcessCycle[$rowData['prc_Code']] = $rowData['prc_Description'];
		}
		return $arrProcessCycle;	
	}  
	
	public function fetchMasterActivity() {		

		$qrySel = "SELECT mas_Code, mas_Description 
					FROM mas_masteractivity 
					ORDER BY mas_Description";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrMasterActivity[$rowData['mas_Code']] = $rowData['mas_Description'];
		}
		return $arrMasterActivity;	
	}  
	
	public function fetchSubActivity($code)
	{	
		$strWhere = "";

		if($code)
			$strWhere = "WHERE sas_Code=".$code;
	
		$qrySel = "SELECT sub_Code, sub_Description 
					FROM sub_subactivity ".$strWhere."
					ORDER BY sub_Description";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrSubActivity[$rowData['sub_Code']] = $rowData['sub_Description'];
		}
		return $arrSubActivity;	
	}  
		
	public function fetchEmployees($flagManager) {
		
		if($flagManager) { 
			$appendStr = 'AND t1.con_Designation = 24';
		}

		$qrySel = "SELECT t1.con_Code, t1.con_Firstname, t1.con_Lastname 
					FROM con_contact as t1 
					LEFT JOIN cnt_contacttype AS t2 ON t1.con_Type = t2.cnt_Code 
					WHERE t2.cnt_Description like 'Employee'
					{$appendStr}";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrSrManager[$rowData['con_Code']] = $rowData['con_Firstname'] . ' ' . $rowData['con_Lastname'];
		}
		return $arrSrManager;	
	} 

	public function sql_select($jobId) {		
	
		if($jobId)
			$strWhere = "AND job_id={$jobId}";
			
			$qrySel = "SELECT * 
						FROM task
						WHERE discontinue_date IS NULL 
						{$strWhere} 
						ORDER BY task_id desc";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrTask[$rowData['task_id']] = $rowData;
		}
		return $arrTask;	
	}

	public function sql_insert() {	

		// external due date
		$arrExtDate = explode("/", $_REQUEST["dateSignedUp"]);
		$strExtDate = $arrExtDate[2]."-".$arrExtDate[1]."-".$arrExtDate[0];

		// befree due date
		$arrBefreeDate = explode("/", $_REQUEST["befreeDueDate"]);
		$strBefreeDate = $arrBefreeDate[2]."-".$arrBefreeDate[1]."-".$arrBefreeDate[0];
		
		if($_REQUEST["jobId"]) {

			$ClientID = $this->arrJobDetails[$_REQUEST["jobId"]]["client_id"];
			$PracticeID = $this->arrClientDetails[$ClientID]["id"];
			
			$qryIns = "INSERT INTO task(task_name, id, client_id, job_id, mas_Code, sub_Code, last_reports_sent, current_job_in_hand, notes, manager_id, india_manager_id, team_member_id, task_status_id, priority_id, process_id, due_date, befree_due_date, resolution, related_cases, created_date)
					VALUES (
					'" . $_REQUEST['txtTaskName'] . "', 
					'" . $PracticeID . "', 
					'" . $ClientID . "', 
					'" . $_REQUEST["jobId"] . "', 
					'" . $_REQUEST['lstMasterActivity'] . "', 
					'" . $_REQUEST['lstSubActivity'] . "', 
					'" . $_REQUEST['txtReportsSent'] . "', 
					'" . $_REQUEST['txtJobInHand'] . "', 
					'" . $_REQUEST['txtNotes'] . "', 
					'" . $_REQUEST['lstSrManager'] . "', 
					'" . $_REQUEST['lstSrIndiaManager'] . "', 
					'" . $_REQUEST['lstSrTeamMember'] . "', 
					'" . $_REQUEST['lstTaskStatus'] . "', 
					'" . $_REQUEST['lstPriority'] . "', 
					'" . $_REQUEST['lstProcessingCycle'] . "', 
					'" . $strExtDate . "',
					'" . $strBefreeDate . "',
					'" . $_REQUEST['txtResolution'] . "', 
					'" . $_REQUEST['txtRelatedCases'] . "', 
					NOW(),
					)";
		}	
		else {

			$qryIns = "INSERT INTO task(task_name, id, client_id, job_id, mas_Code, sub_Code, last_reports_sent, current_job_in_hand, notes, manager_id, india_manager_id, team_member_id, task_status_id, priority_id, process_id, due_date, befree_due_date, resolution, related_cases, created_date)
					VALUES (
					'" . $_REQUEST['txtTaskName'] . "', 
					'" . $_REQUEST['lstPractice'] . "', 
					'" . $_REQUEST['lstClient'] . "', 
					'" . $_REQUEST['lstJob'] . "', 
					'" . $_REQUEST['lstMasterActivity'] . "', 
					'" . $_REQUEST['lstSubActivity'] . "', 
					'" . $_REQUEST['txtReportsSent'] . "', 
					'" . $_REQUEST['txtJobInHand'] . "', 
					'" . $_REQUEST['txtNotes'] . "', 
					'" . $_REQUEST['lstSrManager'] . "', 
					'" . $_REQUEST['lstSrIndiaManager'] . "', 
					'" . $_REQUEST['lstSrTeamMember'] . "',
					'" . $_REQUEST['lstTaskStatus'] . "', 
					'" . $_REQUEST['lstPriority'] . "', 
					'" . $_REQUEST['lstProcessingCycle'] . "', 
					'" . $strExtDate . "',
					'" . $strBefreeDate . "',
					'" . $_REQUEST['txtResolution'] . "', 
					'" . $_REQUEST['txtRelatedCases'] . "', 
					NOW()  
					)";
		}
		mysql_query($qryIns);
	} 

	public function sql_update()
	{	

		// external due date
		$arrExtDate = explode("/", $_REQUEST["dateSignedUp"]);
		$strExtDate = $arrExtDate[2]."-".$arrExtDate[1]."-".$arrExtDate[0];

		// befree due date
		$arrBefreeDate = explode("/", $_REQUEST["befreeDueDate"]);
		$strBefreeDate = $arrBefreeDate[2]."-".$arrBefreeDate[1]."-".$arrBefreeDate[0];
	
		if($_REQUEST["jobId"]) {

			$ClientID = $this->arrJobDetails[$_REQUEST["jobId"]]["client_id"];
			$PracticeID = $this->arrClientDetails[$ClientID]["id"];

			$qryUpd = "UPDATE task
					SET task_name = '" . $_REQUEST['txtTaskName'] . "',
					id = '" . $PracticeID . "',
					client_id = '" . $ClientID . "',
					job_id = '" . $_REQUEST["jobId"] . "',
					mas_Code = '" . $_REQUEST['lstMasterActivity'] . "',
					sub_Code = '" . $_REQUEST['lstSubActivity'] . "',
					last_reports_sent = '" . $_REQUEST['txtReportsSent'] . "',
					current_job_in_hand = '" . $_REQUEST['txtJobInHand'] . "',
					notes = '" . $_REQUEST['txtNotes'] . "',
					manager_id = '" . $_REQUEST['lstSrManager'] . "',
					india_manager_id = '" . $_REQUEST['lstSrIndiaManager'] . "',
					team_member_id = '" . $_REQUEST['lstSrTeamMember'] . "', 
					task_status_id = '" . $_REQUEST['lstTaskStatus'] . "',
					priority_id = '" . $_REQUEST['lstPriority'] . "',
					process_id = '" . $_REQUEST['lstProcessingCycle'] . "',
					due_date = '" . $strExtDate . "',
					resolution = '" . $_REQUEST['txtResolution'] . "',
					related_cases = '" . $_REQUEST['txtRelatedCases'] . "',
					befree_due_date = '" . $strBefreeDate . "'
					WHERE task_id = '" . $_REQUEST['recid'] . "'";
		}
		else {

			$qryUpd = "UPDATE task
					SET task_name = '" . $_REQUEST['txtTaskName'] . "',
					id = '" . $_REQUEST['lstPractice'] . "',
					client_id = '" . $_REQUEST['lstClient'] . "',
					job_id = '" . $_REQUEST['lstJob'] . "',
					mas_Code = '" . $_REQUEST['lstMasterActivity'] . "',
					sub_Code = '" . $_REQUEST['lstSubActivity'] . "',
					last_reports_sent = '" . $_REQUEST['txtReportsSent'] . "',
					current_job_in_hand = '" . $_REQUEST['txtJobInHand'] . "',
					notes = '" . $_REQUEST['txtNotes'] . "',
					manager_id = '" . $_REQUEST['lstSrManager'] . "',
					india_manager_id = '" . $_REQUEST['lstSrIndiaManager'] . "',
					team_member_id = '" . $_REQUEST['lstSrTeamMember'] . "', 
					task_status_id = '" . $_REQUEST['lstTaskStatus'] . "',
					priority_id = '" . $_REQUEST['lstPriority'] . "',
					process_id = '" . $_REQUEST['lstProcessingCycle'] . "',
					due_date = '" . $strExtDate . "',
					resolution = '" . $_REQUEST['txtResolution'] . "',
					related_cases = '" . $_REQUEST['txtRelatedCases'] . "',
					befree_due_date = '" . $strBefreeDate . "'
					WHERE task_id = '" . $_REQUEST['recid'] . "'";
		}			
		mysql_query($qryUpd);	
	} 

	function sql_delete($recid) {

		// set discontinue date of task 
		$qryDel = "UPDATE task SET discontinue_date=NOW() WHERE task_id=".$recid;
		mysql_query($qryDel);
	}
}
?>