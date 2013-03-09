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
		
		$this->arrSrManager = $this->fetchEmployees('srmanager');
		$this->arrIndiaManager = $this->fetchEmployees('indiamanager');
		$this->arrEmployees = $this->fetchEmployees('teammember');
		
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
		$qrySel = "SELECT t1.id, t1.description, t1.order 
		           FROM task_status t1 
				   ORDER BY t1.order";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrTaskStatus[$rowData['id']] = $rowData['description'];
		}
		return $arrTaskStatus;	
	}  
	
	public function fetchPriority()
	{		
		$qrySel = "SELECT t1.pri_Code, t1.pri_Description, t1.pri_Order 
		            FROM pri_priority t1 
					ORDER BY t1.pri_Order";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrPriority[$rowData['pri_Code']] = $rowData['pri_Description'];
		}
		return $arrPriority;	
	}  
	
	public function fetchProcessingCycle()
	{		
		$qrySel = "SELECT t1.prc_Code, t1.prc_Description, t1.prc_Order 
		            FROM prc_processcycle t1 
					ORDER BY t1.prc_Order";

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
		
	public function fetchEmployees($flagManager)
	{
		$appendStr = "";
		
        // if employees are fetched that are SR Manager
        if($flagManager == 'srmanager') { 
                        $appendStr = 'AND c1.con_Designation = 24';
        }
        // if employees are fetched that are Sales Manager
        else if($flagManager == 'indiamanager') { 
                        $appendStr = 'AND c1.con_Designation = 27';
        }
        // if employees are fetched that are Sales Manager
        else if($flagManager == 'teammember') { 
                        $appendStr = 'AND c1.con_Designation = 29';
        }

		$qrySel = "SELECT stf_Code, c1.con_Firstname, c1.con_Lastname 
				     FROM stf_staff t1, aty_accesstype t2, con_contact c1
				     WHERE t1.stf_AccessType = t2.aty_Code 
				     AND t1.stf_CCode = c1.con_Code 
				     AND t2.aty_Description like 'Staff' 
					 {$appendStr} 
				     ORDER BY stf_Code";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrSrManager[$rowData['stf_Code']] = $rowData['con_Firstname'] . ' ' . $rowData['con_Lastname'];
		}
		return $arrSrManager;	
	} 

	public function sql_select($jobId)
	{		
		$userId = $_SESSION["staffcode"];
		
		$strWhere = "";		
		if($_SESSION["usertype"]=="Staff")
			$strWhere="AND manager_id=".$userId." or india_manager_id=".$userId." or team_member_id=".$userId;
	
		if($jobId)
			$strWhere .= "AND job_id={$jobId}";
			
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
			
			$qryIns = "INSERT INTO task(task_name, id, client_id, job_id, mas_Code, sub_Code, notes, manager_id, india_manager_id, team_member_id, task_status_id, priority_id, process_id, due_date, befree_due_date, created_date)
					VALUES (
					'" . $_REQUEST['txtTaskName'] . "', 
					'" . $PracticeID . "', 
					'" . $ClientID . "', 
					'" . $_REQUEST["jobId"] . "', 
					'" . $_REQUEST['lstMasterActivity'] . "', 
					'" . $_REQUEST['lstSubActivity'] . "', 
					'" . $_REQUEST['txtNotes'] . "', 
					'" . $_REQUEST['lstSrManager'] . "', 
					'" . $_REQUEST['lstSrIndiaManager'] . "', 
					'" . $_REQUEST['lstSrTeamMember'] . "', 
					'" . $_REQUEST['lstTaskStatus'] . "', 
					'" . $_REQUEST['lstPriority'] . "', 
					'" . $_REQUEST['lstProcessingCycle'] . "', 
					'" . $strExtDate . "',
					'" . $strBefreeDate . "',
					NOW(),
					)";
		}	
		else {

			$qryIns = "INSERT INTO task(task_name, id, client_id, job_id, mas_Code, sub_Code, notes, manager_id, india_manager_id, team_member_id, task_status_id, priority_id, process_id, due_date, befree_due_date, created_date)
					VALUES (
					'" . $_REQUEST['txtTaskName'] . "', 
					'" . $_REQUEST['lstPractice'] . "', 
					'" . $_REQUEST['lstClient'] . "', 
					'" . $_REQUEST['lstJob'] . "', 
					'" . $_REQUEST['lstMasterActivity'] . "', 
					'" . $_REQUEST['lstSubActivity'] . "', 
					'" . $_REQUEST['txtNotes'] . "', 
					'" . $_REQUEST['lstSrManager'] . "', 
					'" . $_REQUEST['lstSrIndiaManager'] . "', 
					'" . $_REQUEST['lstSrTeamMember'] . "',
					'" . $_REQUEST['lstTaskStatus'] . "', 
					'" . $_REQUEST['lstPriority'] . "', 
					'" . $_REQUEST['lstProcessingCycle'] . "', 
					'" . $strExtDate . "',
					'" . $strBefreeDate . "',
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
					notes = '" . $_REQUEST['txtNotes'] . "',
					manager_id = '" . $_REQUEST['lstSrManager'] . "',
					india_manager_id = '" . $_REQUEST['lstSrIndiaManager'] . "',
					team_member_id = '" . $_REQUEST['lstSrTeamMember'] . "', 
					task_status_id = '" . $_REQUEST['lstTaskStatus'] . "',
					priority_id = '" . $_REQUEST['lstPriority'] . "',
					process_id = '" . $_REQUEST['lstProcessingCycle'] . "',
					due_date = '" . $strExtDate . "',
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
					notes = '" . $_REQUEST['txtNotes'] . "',
					manager_id = '" . $_REQUEST['lstSrManager'] . "',
					india_manager_id = '" . $_REQUEST['lstSrIndiaManager'] . "',
					team_member_id = '" . $_REQUEST['lstSrTeamMember'] . "', 
					task_status_id = '" . $_REQUEST['lstTaskStatus'] . "',
					priority_id = '" . $_REQUEST['lstPriority'] . "',
					process_id = '" . $_REQUEST['lstProcessingCycle'] . "',
					due_date = '" . $strExtDate . "',
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