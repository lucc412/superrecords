<?php
class Practice_Class extends Database
{ 	
	public function __construct()
	{
		$this->arrTypes = $this->fetchType();
		
		$this->arrSrManager = $this->fetchEmployees('srmanager');
		$this->arrIndiaManager = $this->fetchEmployees('indiamanager');
		$this->arrEmployees = $this->fetchEmployees('teammember');
		$this->arrSalesPerson = $this->fetchEmployees('salesperson');
		$this->arrStepsList = $this->fetchStepsList();
		$this->arrPractice = $this->fetchPractice();
  	}	

	public function fetchType() {		

		$qrySel = "SELECT ct.client_type_id, ct.client_type 
					FROM client_type ct
					ORDER BY ct.order";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrTypes[$rowData['client_type_id']] = $rowData['client_type'];
		}
		return $arrTypes;
	}

	public function fetchPractice() {		

		$qrySel = "SELECT ct.id, ct.name 
					FROM pr_practice ct 
					ORDER BY ct.name";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrPractice[$rowData['id']] = $rowData['name'];
		}
		return $arrPractice;
	}
	
	public function fetchEmployees($flagManager)
	{	
		
        // if employees are fetched that are SR Manager
        if($flagManager == 'srmanager') { 
			$appendStr = 'AND c1.con_Designation = 24';
        }
        // if employees are fetched that are India Manager
        else if($flagManager == 'indiamanager') { 
			$appendStr = 'AND c1.con_Designation = 28';
        }
        // if employees are fetched that are Team Member
        else if($flagManager == 'teammember') { 
			$appendStr = 'AND c1.con_Designation = 29';
        }
		// if employees are fetched that are Sales Manager
        else if($flagManager == 'salesperson') { 
			$appendStr = 'AND c1.con_Designation = 14';
        }

		$qrySel = "SELECT stf_Code, c1.con_Firstname, c1.con_Lastname 
			         FROM stf_staff t1, aty_accesstype t2, con_contact c1
			         WHERE t1.stf_AccessType = t2.aty_Code 
			         AND t1.stf_CCode = c1.con_Code 
			         AND t2.aty_Description like 'Staff' 
			      	 {$appendStr} 
			         ORDER BY c1.con_Firstname";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrEmployees[$rowData['stf_Code']] = $rowData['con_Firstname'] . ' ' . $rowData['con_Lastname'];
		}
		return $arrEmployees;	
	} 

	public function fetchStepsList() {		

		$qrySel = "SELECT cs.id, cs.description
					FROM cli_steps cs
					ORDER BY cs.order";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrItemList[$rowData['id']] = $rowData['description'];
		}
		return $arrItemList;	
	} 

	public function sql_select()
	{		
		$userId = $_SESSION["staffcode"];
		
		$strWhere = "";		
		if($_SESSION["usertype"]=="Staff")
			$strWhere="WHERE sr_manager=".$userId." or india_manager=".$userId." or team_member=".$userId ." or sales_person=".$userId;

		$qrySel = "SELECT t1.* 
			FROM client t1 
			{$strWhere}
			ORDER BY t1.client_id DESC";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrClients[$rowData['client_id']] = $rowData;
		}
		return $arrClients;	
	}

	public function sql_insert() {	

		global $commonUses;

		foreach($_REQUEST AS $fieldName => $fieldValue) {
			 if(strstr($fieldName, "step:")) {
				$fieldId = str_replace('step:','',$fieldName);
				$arrSteps[] = $fieldId;
			 }
		}

		$strSteps = '';
		if(!empty($arrSteps)) $strSteps = implode(',', $arrSteps);

		$dateSignedUp = $commonUses->getDateFormat($_REQUEST["dateSignedUp"]);

		$qryIns = "INSERT INTO client(client_type_id, client_name, id, sr_manager, india_manager, team_member, sales_person, client_notes, client_received, steps_done)
					VALUES (
					'" . $_REQUEST['lstType'] . "', 
					'" . $_REQUEST['cliName'] . "',
					'" . $_REQUEST['lstPractice'] . "', 
					'" . $_REQUEST['lstSrManager'] . "', 
					'" . $_REQUEST['lstInManager'] . "', 
					'" . $_REQUEST['lstTeamMember'] . "', 
					'" . $_REQUEST['lstSalesPerson'] . "', 
					'" . $_REQUEST['client_notes'] . "',
					'" . $dateSignedUp . "',  
					'" . $strSteps . "'
					)";
		

		mysql_query($qryIns);
	} 

	public function sql_update() {	

		global $commonUses;

		foreach($_REQUEST AS $fieldName => $fieldValue) {
			 if(strstr($fieldName, "step:")) {
				$fieldId = str_replace('step:','',$fieldName);
				$arrSteps[] = $fieldId;
			 }
		}

		$strSteps = '';
		if(!empty($arrSteps)) $strSteps = implode(',', $arrSteps);

		$dateSignedUp = $commonUses->getDateFormat($_REQUEST["dateSignedUp"]);

		$qryUpd = "UPDATE client
				SET client_type_id = '" . $_REQUEST['lstType'] . "',
				client_name = '" . $_REQUEST['cliName'] . "',
				id = '" . $_REQUEST['lstPractice'] . "',
				sr_manager = '" . $_REQUEST['lstSrManager'] . "',
				india_manager = '" . $_REQUEST['lstInManager'] . "',
				team_member = '" . $_REQUEST['lstTeamMember'] . "',
				sales_person = '" . $_REQUEST['lstSalesPerson'] . "',
				client_notes = '" . $_REQUEST['client_notes'] . "',
				client_received = '" . $dateSignedUp . "',
				steps_done = '" . $strSteps . "'
				WHERE client_id = '" . $_REQUEST['recid'] . "'";

		mysql_query($qryUpd);	
	} 

	function sql_delete($recid) {

		$qryDel = "DELETE FROM client where client_id = '".$recid."' ";
		mysql_query($qryDel);
	}
}

?>