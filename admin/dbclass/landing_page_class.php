<?php

class Landing_Class extends Database { 	
	public function __construct() {
		
  	}
	
	public function fetchSrManager() {		

		$qrySel = "SELECT t1.con_Code, t1.con_Firstname, t1.con_Lastname 
					FROM con_contact as t1 
					LEFT JOIN cnt_contacttype AS t2 ON t1.con_Type = t2.cnt_Code 
					WHERE t2.cnt_Description like 'Employee'";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrSrManager[$rowData['con_Code']] = $rowData['con_Firstname'] . ' ' . $rowData['con_Lastname'];
		}
		return $arrSrManager;	
	}

	public function sql_select() {		

		$qrySel = "SELECT st.stf_Code empId, CONCAT_WS(' ', cc.con_Firstname, cc.con_Lastname) empName, st.default_url landingUrl 
					FROM stf_staff st, con_contact cc
					LEFT JOIN cnt_contacttype AS t2 ON (cc.con_Type = t2.cnt_Code
					AND t2.cnt_Description like 'Employee')
					WHERE st.stf_CCode = cc.con_Code
					ORDER BY st.stf_Code desc";

		$fetchResult = mysql_query($qrySel);		
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrEmployees[$rowData['empId']]['empName'] = $rowData['empName'];
			$arrEmployees[$rowData['empId']]['landingUrl'] = $rowData['landingUrl'];
		}
		return $arrEmployees;	
	}

	public function sql_update() {

		$qryUpd = "UPDATE stf_staff
				SET default_url = '" . $_REQUEST['employeeUrl'] . "'
				WHERE stf_Code = '" . $_REQUEST['employeeId'] . "'";

		mysql_query($qryUpd);	
	} 
}

?>