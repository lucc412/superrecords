<?php

class Referrer_Class extends Database { 	
	public function __construct() {
		$this->arrTypes = $this->fetchType();
		$this->arrSrManager = $this->fetchSrManager();
		$this->arrServices = $this->fetchServices();
		$this->arrItemList = $this->fetchItemList();
		$this->arrStates = $this->fetchStates();
		$this->arrSalesPerson = $this->fetchSalesPerson();
  	}	

	public function fetchType() {		

		$qrySel = "SELECT rt.id, rt.description 
					FROM rf_type rt
					ORDER BY rt.order";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrTypes[$rowData['id']] = $rowData['description'];
		}
		return $arrTypes;	
	} 
	
	public function fetchSrManager() {		

		$qrySel = "SELECT t1.con_Code, t1.con_Firstname, t1.con_Lastname 
					FROM con_contact as t1 
					LEFT JOIN cnt_contacttype AS t2 ON t1.con_Type = t2.cnt_Code 
					WHERE t2.cnt_Description like 'Employee'
					AND t1.con_Designation = 24 
					ORDER BY t1.con_Firstname";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrSrManager[$rowData['con_Code']] = $rowData['con_Firstname'] . ' ' . $rowData['con_Lastname'];
		}
		return $arrSrManager;	
	} 

	public function fetchServices() {		

		$qrySel = "SELECT rf.svr_Code code, rf.svr_Description description
					FROM rf_services rf
					ORDER BY rf.svr_Order";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrServices[$rowData['code']] = $rowData['description'];
		}
		return $arrServices;	
	} 

	public function fetchItemList() {		

		$qrySel = "SELECT rf.task_Id id, rf.task_Description description
					FROM rf_tasklist rf
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
					ORDER BY cs.cst_Description";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrStates[$rowData['cst_Code']] = $rowData['cst_Description'];
		}
		return $arrStates;	
	} 

	public function fetchSalesPerson() {		

		$qrySel = "SELECT stf_Code, stf_Login, c1.con_Firstname, c1.con_Lastname 
					FROM stf_staff t1 
					LEFT JOIN aty_accesstype AS t2 ON t1.stf_AccessType = t2.aty_Code 
					LEFT JOIN con_contact AS c1 ON t1.stf_CCode = c1.con_Code 
					WHERE (c1.con_Designation=14 || c1.con_Designation=19) 
					AND t2.aty_Description LIKE '%Staff%' 
					ORDER BY c1.con_Firstname";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrSalesPerson[$rowData['stf_Code']] = $rowData['con_Firstname'] . ' ' . $rowData['con_Lastname'];
		}
		return $arrSalesPerson;
	}

	public function sql_select() {		

		$qrySel = "SELECT t1.* FROM rf_referrer t1 ORDER BY t1.id desc";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrReferrers[$rowData['id']] = $rowData;
		}
		return $arrReferrers;	
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

		$qryIns = "INSERT INTO rf_referrer(type, name, sr_manager, street_adress, suburb, state, postcode, postal_address, main_contact_name, other_contact_name, phone_no, alternate_no, fax, email, date_signed_up, agreed_services, sent_items, sales_person)
					VALUES (
					'" . $_REQUEST['lstType'] . "', 
					'" . $_REQUEST['refName'] . "', 
					'" . $_REQUEST['lstSrManager'] . "', 
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

		$qryUpd = "UPDATE rf_referrer
				SET type = '" . $_REQUEST['lstType'] . "',
				name = '" . $_REQUEST['refName'] . "',
				sr_manager = '" . $_REQUEST['lstSrManager'] . "',
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
				date_signed_up = '" . $dateSignedUp . "',
				agreed_services = '" . $strServices . "',
				sent_items = '" . $strItems . "',
				sales_person = '" . $_REQUEST['lstSalesPerson'] . "'
				WHERE id = '" . $_REQUEST['recid'] . "'";

		mysql_query($qryUpd);	
	} 

	function sql_delete($recid) {

		$qryDel = "DELETE FROM rf_referrer where id = '".$recid."' ";
		mysql_query($qryDel);
	}
}

?>