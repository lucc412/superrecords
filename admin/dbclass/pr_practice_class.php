<?php

class Practice_Class extends Database { 	
	public function __construct() {
		$this->arrTypes = $this->fetchType();
		$this->arrSrManager = $this->fetchEmployees('srmanager');
		$this->arrSalesPerson = $this->fetchEmployees('salesmanager');
		$this->arrInManager = $this->fetchEmployees('indiamanager');
		$this->arrTeamMember = $this->fetchEmployees('teammember');
		$this->arrServices = $this->fetchServices();
		$this->arrItemList = $this->fetchItemList();
		$this->arrStates = $this->fetchStates();
  	}	

	public function fetchType() {		

		$qrySel = "SELECT rt.id, rt.description 
					FROM pr_type rt
					ORDER BY rt.order";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrTypes[$rowData['id']] = $rowData['description'];
		}
		return $arrTypes;	
	} 

	public function fetchEmployees($flagManager) {
		
		// if employees are fetched that are SR Manager
		if($flagManager == 'srmanager') { 
			$appendStr = 'AND c1.con_Designation = 24';
		}
		// if employees are fetched that are Sales Manager
		else if($flagManager == 'salesmanager') { 
			$appendStr = 'AND c1.con_Designation = 14';
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
			$arrEmployees[$rowData['stf_Code']] = $rowData['con_Firstname'] . ' ' . $rowData['con_Lastname'];
		}
		return $arrEmployees;	
	} 

	public function fetchServices() {		

		$qrySel = "SELECT rf.svr_Code code, rf.svr_Description description
					FROM pr_services rf
					ORDER BY rf.svr_Order";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrServices[$rowData['code']] = $rowData['description'];
		}
		return $arrServices;	
	} 

	public function fetchItemList() {		

		$qrySel = "SELECT rf.task_Id id, rf.task_Description description
					FROM pr_tasklist rf
					ORDER BY rf.task_Order";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrItemList[$rowData['id']] = $rowData['description'];
		}
		return $arrItemList;	
	} 

	public function fetchStates() {		

		$qrySel = "SELECT cs.cst_Code, cs.cst_Description
					FROM cli_state cs
					ORDER BY cs.cst_Description ASC";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrStates[$rowData['cst_Code']] = $rowData['cst_Description'];
		}
		return $arrStates;	
	} 

	public function sql_select() {

		if($_SESSION['usertype'] == 'Staff')
			$appendStr = "WHERE ( t1.sr_manager = {$_SESSION['staffcode']} 
						OR t1.india_manager = {$_SESSION['staffcode']}
						OR t1.team_member = {$_SESSION['staffcode']}
						OR t1.sales_person = {$_SESSION['staffcode']})";

		$qrySel = "SELECT t1.* 
					FROM pr_practice t1 
					{$appendStr}
					ORDER BY t1.id desc";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrPractices[$rowData['id']] = $rowData;
		}
		return $arrPractices;	
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

		$dateSignedUp = $commonUses->getDateFormat($_REQUEST["dateSignedUp"]);

		$qryIns = "INSERT INTO pr_practice(type, name, sr_manager, india_manager, team_member, street_adress, suburb, state, postcode, postal_address, main_contact_name, other_contact_name, phone_no, alternate_no, fax, email, password, date_signed_up, agreed_services, sent_items, sales_person)
					VALUES (
					'" . $_REQUEST['lstType'] . "', 
					'" . $_REQUEST['refName'] . "', 
					'" . $_REQUEST['lstSrManager'] . "', 
					'" . $_REQUEST['lstManager'] . "', 
					'" . $_REQUEST['lstMember'] . "', 
					'" . $_REQUEST['street_Address'] . "', 
					'" . $_REQUEST['suburb'] . "', 
					'" . $_REQUEST['lstState'] . "', 
					'" . $_REQUEST['postCode'] . "', 
					'" . $_REQUEST['postalAddress'] . "', 
					'" . $_REQUEST['mainContactName'] . "', 
					'" . $_REQUEST['otherContactName'] . "', 
					'" . $_REQUEST['phoneNo'] . "', 
					'" . $_REQUEST['altPhoneNo'] . "', 
					'" . $_REQUEST['fax'] . "', 
					'" . $_REQUEST['email'] . "', 
					'" . $_REQUEST['password'] . "', 
					'" . $dateSignedUp . "', 
					'" . $strServices . "', 
					'" . $strItems . "', 
					'" . $_REQUEST['lstSalesPerson'] . "'
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

		$strServices = '';
		if(!empty($arrServices)) $strServices = implode(',', $arrServices);

		$strItems = '';
		if(!empty($arrItems)) $strItems = implode(',', $arrItems);

		$dateSignedUp = $commonUses->getDateFormat($_REQUEST["dateSignedUp"]);

		$qryUpd = "UPDATE pr_practice
				SET type = '" . $_REQUEST['lstType'] . "',
				name = '" . $_REQUEST['refName'] . "',
				sr_manager = '" . $_REQUEST['lstSrManager'] . "',
				india_manager = '" . $_REQUEST['lstManager'] . "',
				team_member = '" . $_REQUEST['lstMember'] . "',
				street_adress = '" . $_REQUEST['street_Address'] . "',
				suburb = '" . $_REQUEST['suburb'] . "',
				state = '" . $_REQUEST['lstState'] . "',
				postcode = '" . $_REQUEST['postCode'] . "',
				postal_address = '" . $_REQUEST['postalAddress'] . "',
				main_contact_name = '" . $_REQUEST['mainContactName'] . "',
				other_contact_name = '" . $_REQUEST['otherContactName'] . "',
				phone_no = '" . $_REQUEST['phoneNo'] . "',
				alternate_no = '" . $_REQUEST['altPhoneNo'] . "',
				fax = '" . $_REQUEST['fax'] . "',
				email = '" . $_REQUEST['email'] . "',
				password = '" . $_REQUEST['password'] . "',
				date_signed_up = '" . $dateSignedUp . "',
				agreed_services = '" . $strServices . "',
				sent_items = '" . $strItems . "',
				sales_person = '" . $_REQUEST['lstSalesPerson'] . "'
				WHERE id = '" . $_REQUEST['recid'] . "'";

		mysql_query($qryUpd);	
	} 

	function sql_delete($recid) {

		$qryDel = "DELETE FROM pr_practice where id = '".$recid."' ";
		mysql_query($qryDel);
	}
}

?>