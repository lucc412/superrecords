<?php

class Practice_Class extends Database { 	
	public function __construct() {
		$this->arrTypes = $this->fetchType();
		$this->arrSrManager = $this->fetchEmployees('srmanager');
		$this->arrSalesPerson = $this->fetchEmployees('salesmanager');
		$this->arrInManager = $this->fetchEmployees('indiamanager');
		$this->arrAuditMngr = $this->fetchEmployees('auditmanager');
		$this->arrServices = $this->fetchServices();
		//$this->arrItemList = $this->fetchItemList();
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

	public function checkEmailExists($prEmail) {		

		$qrySel = "SELECT pr.email
					FROM pr_practice pr
					WHERE pr.email = '".$prEmail."'";

		$fetchResult = mysql_query($qrySel);		
		$rowData = mysql_fetch_assoc($fetchResult);

		if(empty($rowData))
			return true;
		else
			return false;	
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
			$appendStr = 'AND c1.con_Designation = 28';
		}
		// if employees are fetched that are Sales Manager
		else if($flagManager == 'auditmanager') { 
			$appendStr = 'AND c1.con_Designation = 32';
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
					ORDER BY cs.cst_Description";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrStates[$rowData['cst_Code']] = $rowData['cst_Description'];
		}
		return $arrStates;	
	} 

	public function sql_select($mode='',$recId='') {	
	
		global $filter;
		global $filterfield;
		global $wholeonly;
		global $commonUses;	
                global $order;
                global $ordertype;

		if($_SESSION['usertype'] == 'Staff')
			$appendStr = "AND ( pr.sr_manager = {$_SESSION['staffcode']} 
						OR pr.india_manager = {$_SESSION['staffcode']}
						OR pr.sales_person = {$_SESSION['staffcode']}
						OR pr.audit_manager = {$_SESSION['staffcode']})";

		// view & edit case				
		if(isset($mode) && (($mode == 'view') || ($mode == 'edit'))) {				

			$qrySel = "SELECT pr.* 
						FROM pr_practice pr 
						WHERE pr.id = ".$recId."
						ORDER BY pr.id desc";
			
			$fetchResult = mysql_query($qrySel);		
			while($rowData = mysql_fetch_assoc($fetchResult)) {
				$arrPractices[$rowData['id']] = $rowData;
			}
					
		}
		// listing case		
		else {
	                
			$filterstr = $commonUses->sqlstr($filter);
                        if(strstr($filterstr, "/"))$filterstr = $commonUses->getDateFormat($filterstr)." 00:00:00";
                	if(!$wholeonly && isset($wholeonly) && $filterstr!='') 
                        {
                            $filterstr = "%" .$filterstr ."%";
                            $operator = ' LIKE ';
                        }
                        else {
                                $operator = ' = ';
                        }
			$qrySel = "SELECT pr.id pracId, pr.type, pr.name, pr.sr_manager, pr.date_signed_up, pr.pr_code, prt.*, s.*, cnt.* 
						FROM pr_practice pr, pr_type prt, stf_staff s, con_contact cnt 
						WHERE pr.type = prt.id 
						AND pr.sr_manager = s.stf_Code 
						AND s.stf_CCode = cnt.con_Code 
						{$appendStr}";
			
			// filter on selected fields
			if(isset($filterstr) && $filterstr!='' && isset($filterfield) && $filterfield!='') {
				
				if($commonUses->sqlstr($filterfield) == 'sr_manager') {
					$qrySel .= "AND (cnt.con_Firstname LIKE '". $filterstr ."' OR cnt.con_Middlename like '". $filterstr ."' OR cnt.con_Lastname LIKE '". $filterstr ."')";
				}
				elseif($commonUses->sqlstr($filterfield) == 'type'){
					$qrySel .= "AND prt.description LIKE '". $filterstr ."'";
				}
                                elseif($commonUses->sqlstr($filterfield) == 'date_signed_up'){
					$qrySel .= "AND pr.date_signed_up ".$operator."'". $filterstr ."'";
				}
                                else{
					$qrySel .= "AND " .$commonUses->sqlstr($filterfield) ." LIKE '" .$filterstr ."'";	
				}
			}
			// filter on all fields
			elseif(isset($filterstr) && $filterstr!='') {
			
				$qrySel .= " AND (pr.name LIKE '" .$filterstr ."'
                                                        OR pr.pr_code LIKE '" .$filterstr ."' 
							OR prt.description LIKE '" .$filterstr ."' 
							OR cnt.con_Firstname LIKE '". $filterstr ."' 
							OR cnt.con_Middlename LIKE '". $filterstr ."' 
							OR cnt.con_Lastname LIKE '". $filterstr ."'
							OR pr.date_signed_up LIKE '". $filterstr ."')";
					
			}			
                        $qrySel .= " ORDER BY {$order} {$ordertype}";
			//$qrySel .= " ORDER BY pracId DESC";
	
			$fetchResult = mysql_query($qrySel);		
			while($rowData = mysql_fetch_assoc($fetchResult)) {
				$arrPractices[$rowData['pracId']] = $rowData;
			}
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

			 /*if(strstr($fieldName, "item:")) {
				$fieldId = str_replace('item:','',$fieldName);
				$arrItems[] = $fieldId;
			 }
			 */
		}

		$strServices = '';
		if(!empty($arrServices)) $strServices = implode(',', $arrServices);

		//$strItems = '';
		//if(!empty($arrItems)) $strItems = implode(',', $arrItems);

		$dateSignedUp = $commonUses->getDateFormat($_REQUEST["dateSignedUp"]);

		$qryIns = "INSERT INTO pr_practice(type, name, sr_manager, india_manager, audit_manager, street_adress, suburb, state, postcode, postal_address, main_contact_name, other_contact_name, phone_no, alternate_no, fax, email, password, software, comp_projected, audit_projected, date_signed_up, agreed_services, sales_person)
					VALUES (
					'" . $_REQUEST['lstType'] . "', 
					'" . addslashes($_REQUEST['refName']) . "', 
					'" . $_REQUEST['lstSrManager'] . "', 
					'" . $_REQUEST['lstManager'] . "', 
					'" . $_REQUEST['lstAuditManager'] . "', 
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
					'" . $_REQUEST['software'] . "', 
					'" . $_REQUEST['comp_projected'] . "', 
					'" . $_REQUEST['audit_projected'] . "', 
					'" . $dateSignedUp . "', 
					'" . $strServices . "', 
					'" . $_REQUEST['lstSalesPerson'] . "'
					)";

		mysql_query($qryIns);
		$practiceId = mysql_insert_id();

		// get max practice code from pr_practice table
		$pracCode = $this->get_max_practice_code();
		$pracCode++;
		$pracCode = sprintf("%03s", $pracCode);

		$qryUpd = "UPDATE pr_practice 
					SET pr_code = '" . $pracCode . "'
					WHERE id = ". $practiceId;

		mysql_query($qryUpd);

		return $practiceId;
	} 

	public function sql_update() {	

		global $commonUses;

		foreach($_REQUEST AS $fieldName => $fieldValue) {
			 if(strstr($fieldName, "service:")) {
				$fieldId = str_replace('service:','',$fieldName);
				$arrServices[] = $fieldId;
			 }

			 /*if(strstr($fieldName, "item:")) {
				$fieldId = str_replace('item:','',$fieldName);
				$arrItems[] = $fieldId;
			 }*/
		}

		$strServices = '';
		if(!empty($arrServices)) $strServices = implode(',', $arrServices);

		//$strItems = '';
		//if(!empty($arrItems)) $strItems = implode(',', $arrItems);

		$dateSignedUp = $commonUses->getDateFormat($_REQUEST["dateSignedUp"]);

		$qryUpd = "UPDATE pr_practice
				SET type = '" . $_REQUEST['lstType'] . "',
				name = '" . addslashes($_REQUEST['refName']) . "',
				sr_manager = '" . $_REQUEST['lstSrManager'] . "',
				india_manager = '" . $_REQUEST['lstManager'] . "',
				audit_manager = '" . $_REQUEST['lstAuditManager'] . "',
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
				software = '" . $_REQUEST['software'] . "',
				comp_projected = '" . $_REQUEST['comp_projected'] . "',
				audit_projected = '" . $_REQUEST['audit_projected'] . "',
				date_signed_up = '" . $dateSignedUp . "',
				agreed_services = '" . $strServices . "',
				sales_person = '" . $_REQUEST['lstSalesPerson'] . "'
				WHERE id = '" . $_REQUEST['recid'] . "'";

		mysql_query($qryUpd);	
	} 

	function sql_delete($recid) {

		$qryDel = "DELETE FROM pr_practice where id = '".$recid."' ";
		mysql_query($qryDel);
	}

	function get_max_practice_code() {

		$qryDel = "SELECT MAX(pr_code) pr_code FROM pr_practice ";
		$fetchResult = mysql_query($qryDel);
		$rowData = mysql_fetch_assoc($fetchResult);
		$pracCode = $rowData['pr_code'];

		return $pracCode;
	}

	function fetchManager($pracId, $colManager) {

		$qryDel = "SELECT {$colManager} FROM pr_practice WHERE id = {$pracId}";
		$fetchResult = mysql_query($qryDel);
		$rowData = mysql_fetch_row($fetchResult);
		$pracManager = $rowData[0];

		return $pracManager;
	}
}

?>