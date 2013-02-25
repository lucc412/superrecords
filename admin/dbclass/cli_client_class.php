<?php

class Practice_Class extends Database { 	
	public function __construct() {
		$this->arrTypes = $this->fetchType();
		$this->arrSrManager = $this->fetchEmployees(true);
		$this->arrEmployees = $this->fetchEmployees(false);
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
					FROM pr_practice ct";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrPractice[$rowData['id']] = $rowData['name'];
		}
		return $arrPractice;
	}
	
	public function fetchEmployees($flagManager) {
		
		if($flagManager) { 
			$appendStr = 'AND t1.con_Designation = 24';
		}

		$qrySel = "SELECT t1.con_Code, t1.con_Firstname, t1.con_Lastname 
					FROM con_contact as t1 
					LEFT JOIN cnt_contacttype AS t2 ON t1.con_Type = t2.cnt_Code 
					WHERE t2.cnt_Description like 'Employee'
					{$appendStr}
					";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrEmployees[$rowData['con_Code']] = $rowData['con_Firstname'] . ' ' . $rowData['con_Lastname'];
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

	public function sql_select() {		

		$qrySel = "SELECT t1.* 
				FROM client t1";

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

		$qryIns = "INSERT INTO client(client_type_id, client_name, id, sr_manager, india_manager, client_notes, client_received, steps_done)
					VALUES (
					'" . $_REQUEST['lstType'] . "', 
					'" . $_REQUEST['cliName'] . "',
					'" . $_REQUEST['lstPractice'] . "', 
					'" . $_REQUEST['lstSrManager'] . "', 
					'" . $_REQUEST['lstInManager'] . "', 
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