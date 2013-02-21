<?php

class Lead_Class extends Database { 	
	public function __construct() {
		$this->arrTypes = $this->fetchType();
		$this->arrIndustry = $this->fetchIndustry();
		$this->arrStatus = $this->fetchStatus();
		$this->arrStage = $this->fetchStage();
		$this->arrSource = $this->fetchSource();
		$this->arrStates = $this->fetchStates();
		$this->arrSalesPerson = $this->fetchSalesPerson();
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
					ORDER BY cs.cst_Description ASC";

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
					ORDER BY stf_Code";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrSalesPerson[$rowData['stf_Code']] = $rowData['con_Firstname'] . ' ' . $rowData['con_Lastname'];
		}
		return $arrSalesPerson;
	}

	public function sql_select() {		

		$qrySel = "SELECT t1.* FROM lead t1 ORDER BY t1.id desc";

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

		$dateReceived	 	= $commonUses->getDateFormat($_REQUEST["date_received"]);
		$lastContactDate 	= $commonUses->getDateFormat($_REQUEST["last_contact_date"]);
		$futureContactdate	= $commonUses->getDateFormat($_REQUEST["future_contact_date"]);
		echo "<pre>";
		print_r($_REQUEST);
		$qryIns = "INSERT INTO lead(lead_type, lead_name, sales_person, street_adress, suburb, state, postcode, postal_address, main_contact_name, other_contact_name, phone_no, alternate_phone_no, fax, email, date_received, day_received, lead_industry, lead_status,lead_reason,lead_stage,lead_source,contact_method,last_contact_date,future_contact_date,note)
					VALUES (
					'" . $_REQUEST['lead_type'] . "', 
					'" . $_REQUEST['lead_name'] . "', 
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

		$dateReceived	 	= $commonUses->getDateFormat($_REQUEST["date_received"]);
		$lastContactDate 	= $commonUses->getDateFormat($_REQUEST["last_contact_date"]);
		$futureContactdate	= $commonUses->getDateFormat($_REQUEST["future_contact_date"]);

		$qryUpd = "UPDATE lead
				SET lead_type = '" . $_REQUEST['lead_type'] . "',
				lead_name = '" . $_REQUEST['lead_name'] . "',
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
		header("location:lead.php");
	} 

	function sql_delete($recid) {

		$qryDel = "DELETE FROM lead where id = '".$recid."' ";
		mysql_query($qryDel);
	}
}

?>