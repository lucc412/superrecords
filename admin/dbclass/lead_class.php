<?php

class Lead_Class extends Database { 	
	public function __construct() {
		$this->arrTypes = $this->fetchType();
		$this->arrIndustry = $this->fetchIndustry();
		$this->arrStatus = $this->fetchStatus();
		$this->arrStage = $this->fetchStage();
		$this->arrSource = $this->fetchSource();
		$this->arrStates = $this->fetchStates();
		$this->arrSalesPerson = $this->fetchEmployees('salesperson');
		$this->arrSrManager = $this->fetchEmployees('srmanager');
	  	$this->arrIndiaManager = $this->fetchEmployees('indiamanager');
		$this->arrEmployees = $this->fetchEmployees('teammember');
  	}
	
	public function fetchEmployees($flagManager) {
	
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
			$arrSrManager[$rowData['stf_Code']] = $rowData['con_Firstname'] . ' ' . $rowData['con_Lastname'];
		}
		
		return $arrSrManager;	
	} 

	public function fetchType() {		

		$qrySel = "SELECT rt.id, rt.description 
					FROM lead_type rt
					ORDER BY rt.order";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrTypes[$rowData['id']] = $rowData['description'];
		}
		return $arrTypes;	
	} 

	public function fetchIndustry() {		

		$qrySel = "SELECT rt.id, rt.description 
					FROM lead_industry rt
					ORDER BY rt.order";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrTypes[$rowData['id']] = $rowData['description'];
		}
		return $arrTypes;	
	} 

	public function fetchStatus() {		

		$qrySel = "SELECT rt.id, rt.description 
					FROM lead_status rt
					ORDER BY rt.order";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrTypes[$rowData['id']] = $rowData['description'];
		}
		return $arrTypes;	
	} 

	public function fetchStage() {		

		$qrySel = "SELECT rt.id, rt.description 
					FROM lead_stage rt
					ORDER BY rt.order";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrTypes[$rowData['id']] = $rowData['description'];
		}
		return $arrTypes;	
	} 
	
	public function fetchSource() {		

		$qrySel = "SELECT rt.id, rt.description 
					FROM lead_source rt
					ORDER BY rt.order";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrTypes[$rowData['id']] = $rowData['description'];
		}
		return $arrTypes;	
	} 
		
	public function fetchStates() {		

		$qrySel = "SELECT cs.cst_Code, cs.cst_Description
					FROM cli_state cs
					ORDER BY cs.cst_Description";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrStates[$rowData['cst_Code']] = $rowData['cst_Description'];
		}
		return $arrStates;	
	} 

	public function sql_select() {	
	
		$userId = $_SESSION["staffcode"];
  
		$strWhere = "";
		if($_SESSION["usertype"]=="Staff") {
			if($_SESSION['staffcode'] != '112' && $_SESSION['staffcode'] != '114') {
				$strWhere="WHERE sr_manager=".$userId." or india_manager=".$userId." or team_member=".$userId;
			}
		}

		$qrySel = "SELECT t1.* FROM lead t1 {$strWhere} ORDER BY t1.id desc";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrLead[$rowData['id']] = $rowData;
		}
		
		return $arrLead;	
	}

	public function sql_insert() {	

		global $commonUses;
		foreach($_REQUEST AS $fieldName => $fieldValue) {
			 if(strstr($fieldName, "service:")) {
				$fieldId = str_replace('service:','',$fieldName);
				$arrServices[] = $fieldId;
			 }

			 if(strstr($fieldName, "item:")) {
				$fieldId = str_replace('item:','',$fieldName);
				$arrItems[] = $fieldId;
			 }
		}

		$strServices = '';
		if(!empty($arrServices)) $strServices = implode(',', $arrServices);

		$strItems = '';
		if(!empty($arrItems)) $strItems = implode(',', $arrItems);

		$dateReceived = $commonUses->getDateFormat($_REQUEST["date_received"]);
		$lastContactDate = $commonUses->getDateFormat($_REQUEST["last_contact_date"]);
		$futureContactdate = $commonUses->getDateFormat($_REQUEST["future_contact_date"]);
		
		$qryIns = "INSERT INTO lead(lead_type, lead_name,sr_manager,india_manager,team_member, sales_person, street_adress, suburb, state, postcode, postal_address, main_contact_name, other_contact_name, phone_no, alternate_phone_no, fax, email, date_received, day_received, lead_industry, lead_status,lead_reason,lead_stage,lead_source,contact_method,last_contact_date,future_contact_date,note)
					VALUES (
					'" . $_REQUEST['lead_type'] . "', 
					'" . $_REQUEST['lead_name'] . "',
					'" . $_REQUEST['lstSrManager'] . "',
					'" . $_REQUEST['lstSrIndiaManager'] . "',
					'" . $_REQUEST['lstSrTeamMember'] . "',
					'" . $_REQUEST['sales_person'] . "', 
					'" . $_REQUEST['street_adress'] . "', 
					'" . $_REQUEST['suburb'] . "', 
					'" . $_REQUEST['state'] . "', 
					'" . $_REQUEST['postcode'] . "', 
					'" . $_REQUEST['postal_address'] . "', 
					'" . $_REQUEST['main_contact_name'] . "', 
					'" . $_REQUEST['other_contact_name'] . "', 
					'" . $_REQUEST['phone_no'] . "', 
					'" . $_REQUEST['alternate_phone_no'] . "', 
					'" . $_REQUEST['fax'] . "', 
					'" . $_REQUEST['email'] . "', 
					'" . $dateReceived . "', 
					'" . $_REQUEST['day_received'] . "', 
					'" . $_REQUEST['lead_industry'] . "', 
					'" . $_REQUEST['lead_status'] . "', 
					'" . $_REQUEST['lead_reason'] . "', 
					'" . $_REQUEST['lead_stage'] . "', 
					'" . $_REQUEST['lead_source'] . "', 
					'" . $_REQUEST['contact_method'] . "', 
					'" . $lastContactDate . "', 
					'" . $futureContactdate . "', 
					'" . $_REQUEST['note'] . "'
					)";
		
		mysql_query($qryIns);
	} 

	public function sql_update() {	

		global $commonUses;

		foreach($_REQUEST AS $fieldName => $fieldValue) {
			 if(strstr($fieldName, "service:")) {
				$fieldId = str_replace('service:','',$fieldName);
				$arrServices[] = $fieldId;
			 }

			 if(strstr($fieldName, "item:")) {
				$fieldId = str_replace('item:','',$fieldName);
				$arrItems[] = $fieldId;
			 }
		}

		$dateReceived = $commonUses->getDateFormat($_REQUEST["date_received"]);
		$lastContactDate = $commonUses->getDateFormat($_REQUEST["last_contact_date"]);
		$futureContactdate = $commonUses->getDateFormat($_REQUEST["future_contact_date"]);
	
		$qryUpd = "UPDATE lead
				SET lead_type = '" . $_REQUEST['lead_type'] . "',
				lead_name = '" . $_REQUEST['lead_name'] . "',
				sr_manager = '" . $_REQUEST['lstSrManager']  . "',
				india_manager = '" . $_REQUEST['lstSrIndiaManager'] . "',
				team_member = '" . $_REQUEST['lstSrTeamMember'] . "',
				sales_person = '" . $_REQUEST['sales_person'] . "',
				street_adress = '" . $_REQUEST['street_adress'] . "',
				suburb = '" . $_REQUEST['suburb'] . "',
				state = '" . $_REQUEST['state'] . "',
				postcode = '" . $_REQUEST['postcode'] . "',
				postal_address = '" . $_REQUEST['postal_address'] . "',
				main_contact_name = '" . $_REQUEST['main_contact_name'] . "',
				other_contact_name = '" . $_REQUEST['other_contact_name'] . "',
				phone_no = '" . $_REQUEST['phone_no'] . "',
				alternate_phone_no = '" . $_REQUEST['alternate_phone_no'] . "',
				fax = '" . $_REQUEST['fax'] . "',
				email = '" . $_REQUEST['email'] . "',
				date_received = '" . $dateReceived . "',
				day_received = '" . $_REQUEST['day_received'] . "',
				lead_industry = '" . $_REQUEST['lead_industry'] . "',
				lead_status = '" . $_REQUEST['lead_status'] . "',
				lead_reason = '" . $_REQUEST['lead_reason'] . "',
				lead_stage = '" . $_REQUEST['lead_stage'] . "',
				lead_source = '" . $_REQUEST['lead_source'] . "',
				contact_method = '" . $_REQUEST['contact_method'] . "',
				last_contact_date = '" . $lastContactDate . "',
				future_contact_date = '" . $futureContactdate . "',
				note = '" . $_REQUEST['note'] . "'
				WHERE id = '" . $_REQUEST['recid'] . "'";
			
		mysql_query($qryUpd);
	} 

	function sql_delete($recid) {
		$qryDel = "DELETE FROM lead where id = '".$recid."' ";
		mysql_query($qryDel);
	}
}

?>