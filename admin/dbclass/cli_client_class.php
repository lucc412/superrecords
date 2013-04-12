<?php
class Practice_Class extends Database
{ 	
	public function __construct()
	{
		$this->arrTypes = $this->fetchType();
		$this->arrStepsList = $this->fetchStepsList();
		$this->arrPractice = $this->fetchPractice();
		$this->arrTeamMember = $this->fetchTeamMember();
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

	public function fetchTeamMember() {

		$qrySel = "SELECT stf_Code, c1.con_Firstname, c1.con_Lastname 
					FROM stf_staff t1, aty_accesstype t2, con_contact c1
					WHERE t1.stf_AccessType = t2.aty_Code 
					AND t1.stf_CCode = c1.con_Code 
					AND t2.aty_Description like 'Staff'
					AND c1.con_Designation = '29'
					ORDER BY c1.con_Firstname";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrEmployees[$rowData['stf_Code']] = $rowData['con_Firstname'] . ' ' . $rowData['con_Lastname'];
		}
		return $arrEmployees;	
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

	public function sql_select() {		
				
		if($_SESSION["usertype"] == "Staff") {
			$staffId = $_SESSION["staffcode"];
			$strWhere = "AND (pr.sr_manager=".$staffId." 
						OR pr.india_manager=".$staffId." 
						OR cl.team_member=".$staffId ." 
						OR pr.sales_person=".$staffId . ")";
		}

		$qrySel = "SELECT cl.*, pr.sr_manager, pr.india_manager, cl.team_member, pr.sales_person 
					FROM client cl, pr_practice pr
					WHERE pr.id = cl.id
					{$strWhere}
					ORDER BY cl.client_id DESC";

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

		$qryIns = "INSERT INTO client(client_type_id, client_name, id, team_member, client_notes, client_received, steps_done)
					VALUES (
					'" . $_REQUEST['lstType'] . "', 
					'" . $_REQUEST['cliName'] . "',
					'" . $_REQUEST['lstPractice'] . "',
					'" . $_REQUEST['lstTeamMember'] . "',
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
				team_member = '" . $_REQUEST['lstTeamMember'] . "',
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