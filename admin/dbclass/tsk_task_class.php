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
		$this->arrJobType = $this->fetchJobType();
		$this->arrTaskStatus = $this->fetchTaskStatus();
		$this->arrPriority = $this->fetchPriority();
		$this->arrProcessingCycle = $this->fetchProcessingCycle();
  	}	

	public function fetchJobType()
	{
		$qrySel = "SELECT * FROM sub_subactivity order by sub_Order";

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
					ORDER BY mas_Order";

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
					ORDER BY sub_Order";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrSubActivity[$rowData['sub_Code']] = $rowData['sub_Description'];
		}
		return $arrSubActivity;	
	}

	public function sql_select($mode='',$recId='',$jobId='') {		
		global $filter;
		global $filterfield;
		global $wholeonly;
		global $commonUses;	

		$strWhere = "";		
		if($_SESSION["usertype"] == "Staff") {	
			$userId = $_SESSION["staffcode"];
			$strWhere .="AND (pr.sr_manager =".$userId." OR pr.india_manager =".$userId." OR c.team_member =".$userId." OR pr.sales_person =".$userId . ")";
		}
	
		if($jobId)
			$strWhere .= "AND t.job_id={$jobId}";

		if(isset($mode) && (($mode == 'view') || ($mode == 'edit'))) {				
			
			$qrySel = "SELECT t.*, pr.sr_manager, pr.india_manager, pr.sales_person, c.team_member
					FROM task t, job j, client c, pr_practice pr
					WHERE t.discontinue_date IS NULL 
					AND t.job_id = j.job_id
					AND j.client_id = c.client_id
					AND c.id = pr.id
					AND t.task_id = ".$recId."
					ORDER BY t.task_id DESC";
		}
		// listing case
		else {
			
			$filterstr = $commonUses->sqlstr($filter);
			if(!$wholeonly && isset($wholeonly) && $filterstr!='') $filterstr = "%" .$filterstr ."%";
			
			$qrySel = "SELECT t.*, s.*, cnt.*,j.*, pr.*, c.*, sa.*
					FROM task t, job j, client c, pr_practice pr, stf_staff s, con_contact cnt, sub_subactivity sa
					WHERE t.discontinue_date IS NULL 
					AND t.job_id = j.job_id
					AND j.client_id = c.client_id
					AND c.id = pr.id 
					AND sa.sub_Code = j.job_type_id
					AND pr.sr_manager = s.stf_Code 
					AND s.stf_CCode = cnt.con_Code 
					{$strWhere} ";
			
			if(isset($filterstr) && $filterstr!='' && isset($filterfield) && $filterfield!='') {
				
				if($commonUses->sqlstr($filterfield) == 'sr_manager') {
					$qrySel .= "AND (cnt.con_Firstname like '". $filterstr ."' OR cnt.con_Middlename like '". $filterstr ."' OR cnt.con_Lastname like '". $filterstr ."')";
				}elseif($commonUses->sqlstr($filterfield) == 'job_name'){
					$qrySel .= "AND (c.client_name like '".$filterstr."'
								OR sa.sub_Description like '".$filterstr."'
								OR j.period like '".$filterstr."')";
					
				}else{
					$qrySel .= " AND " .$commonUses->sqlstr($filterfield) ." like '" .$filterstr ."'";	
				}
				
			}
			elseif(isset($filterstr) && $filterstr!='') {
				
				$qrySel .= " AND (t.task_name like '" .$filterstr ."'
					OR pr.name like '" .$filterstr ."' 
					OR j.job_name like '". $filterstr ."'
					OR cnt.con_Firstname like '". $filterstr ."' OR cnt.con_Middlename like '". $filterstr ."' OR cnt.con_Lastname like '". $filterstr ."')";
					
			}				

			$qrySel .= " ORDER BY t.task_id DESC";
				
		}
			
		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrTask[$rowData['task_id']] = $rowData;
		}
		return $arrTask;	
	}

	public function fetchEmployees() {	

		$qrySel = "SELECT ss.stf_Code, CONCAT_WS(' ', cc.con_Firstname, cc.con_Lastname) staffName 
					 FROM stf_staff ss, con_contact cc
					 WHERE ss.stf_CCode = cc.con_Code ";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrEmployees[$rowData['stf_Code']] = $rowData['staffName'];
		}
		return $arrEmployees;	
	} 

	public function sql_insert($jobId, $clientId, $practiceId) {	

		// external due date
		$arrExtDate = explode("/", $_REQUEST["dateSignedUp"]);
		$strExtDate = $arrExtDate[2]."-".$arrExtDate[1]."-".$arrExtDate[0];

		// befree due date
		$arrBefreeDate = explode("/", $_REQUEST["befreeDueDate"]);
		$strBefreeDate = $arrBefreeDate[2]."-".$arrBefreeDate[1]."-".$arrBefreeDate[0];
		
		$qryIns = "INSERT INTO task(task_name, id, client_id, job_id, mas_Code, sub_Code, notes, task_status_id, priority_id, process_id, due_date, befree_due_date, created_date)
				VALUES (
				'" . addslashes($_REQUEST['txtTaskName']) . "', 
				'" . $practiceId . "', 
				'" . $clientId . "', 
				'" . $jobId . "', 
				'" . $_REQUEST['lstMasterActivity'] . "', 
				'" . $_REQUEST['lstSubActivity'] . "', 
				'" . $_REQUEST['txtNotes'] . "', 
				'" . $_REQUEST['lstTaskStatus'] . "', 
				'" . $_REQUEST['lstPriority'] . "', 
				'" . $_REQUEST['lstProcessingCycle'] . "', 
				'" . $strExtDate . "',
				'" . $strBefreeDate . "',
				NOW()  
				)";
		
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
					SET task_name = '" . addslashes($_REQUEST['txtTaskName']) . "',
					id = '" . $PracticeID . "',
					client_id = '" . $ClientID . "',
					job_id = '" . $_REQUEST["jobId"] . "',
					mas_Code = '" . $_REQUEST['lstMasterActivity'] . "',
					sub_Code = '" . $_REQUEST['lstSubActivity'] . "',
					notes = '" . $_REQUEST['txtNotes'] . "',
					task_status_id = '" . $_REQUEST['lstTaskStatus'] . "',
					priority_id = '" . $_REQUEST['lstPriority'] . "',
					process_id = '" . $_REQUEST['lstProcessingCycle'] . "',
					due_date = '" . $strExtDate . "',
					befree_due_date = '" . $strBefreeDate . "'
					WHERE task_id = '" . $_REQUEST['recid'] . "'";
		}
		else {

			$qryUpd = "UPDATE task
					SET task_name = '" . addslashes($_REQUEST['txtTaskName']) . "',
					id = '" . $_REQUEST['lstPractice'] . "',
					client_id = '" . $_REQUEST['lstClient'] . "',
					job_id = '" . $_REQUEST['lstJob'] . "',
					mas_Code = '" . $_REQUEST['lstMasterActivity'] . "',
					sub_Code = '" . $_REQUEST['lstSubActivity'] . "',
					notes = '" . $_REQUEST['txtNotes'] . "',
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

	// fetch sr manager, india manager, sales manager, team member for selected practice
	function sql_select_panel($itemId)
	{
		$sql = "SELECT id, sr_manager, india_manager, sales_person
				FROM pr_practice
				WHERE id=".$itemId;
				
		$res = mysql_query($sql) or die(mysql_error());
		$count = mysql_num_rows($res);

		if(!empty($count))
		{
			// fetch array of name of all employees
			$arrEmployees = $this->fetchEmployees();

			$rowData = mysql_fetch_assoc($res);
			$srManager = $arrEmployees[$rowData['sr_manager']];
			$salesPrson = $arrEmployees[$rowData['sales_person']];
			$inManager = $arrEmployees[$rowData['india_manager']];

			// set string of srManager, salesPrson, inManager, teamMember
			$strReturn = $srManager .'~'. $salesPrson .'~'. $inManager;
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
			$arrEmployees = $this->fetchEmployees();

			$rowData = mysql_fetch_assoc($res);
			$teamMember = $arrEmployees[$rowData['team_member']];
		}
		return $teamMember;
	}
}
?>