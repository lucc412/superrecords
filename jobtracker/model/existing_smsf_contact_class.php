<?
class EXISTING_SMSF_CONTACT { 	

	// class constructor
	public function __construct() {
			
  	}
	
	// function to fetch states
	function fetchStates() {
		$qryFetch = "SELECT cs.cst_Code state_id, cs.cst_Description state_name
					FROM cli_state cs";	

        $fetchResult = mysql_query($qryFetch);

		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrStates[$rowData['state_id']] = $rowData['state_name'];
		}
		return $arrStates;
	}

	// function to existing fetch contact details
	function fetchExistingDetails($signupId) {
		$qryFetch = "SELECT * 
					FROM es_contact_details 
					WHERE job_id = '" . $signupId . "' 
					AND signup_type= 'E'";
        $fetchResult = mysql_query($qryFetch);

		$arrData = array();
		if($fetchResult) {
			$arrData = mysql_fetch_assoc($fetchResult);
		}

		return $arrData;
	}

	// function to check Referral Code 
	function checkIfCodeExists($refcode){
		
		$qry = "SELECT r.code FROM rf_referrer r WHERE r.code = '".$refcode."'";
	
		$res = mysql_query($qry);
		$code = mysql_fetch_row($res);
		
		if(isset($code[0]) && $code[0] != ''){
			if(isset($_SESSION['EXST_REFCODE'])) unset($_SESSION['EXST_REFCODE']);
			$_SESSION['EXST_REFCODE'] = $code[0];
			return TRUE;	
		}
		else	
			return FALSE;
	}

	// function to insert contact details of sign up user
	function addContactDetails($fname, $lname, $email, $phone, $stateId, $contStatus) {
		$qryInsert = "INSERT INTO es_contact_details(fname, lname, email, phoneno, state_id, job_id, cont_status)					 
                      VALUES (
							'" . addslashes($fname) . "',
							'" . addslashes($lname) . "',	
							'" . addslashes($email) . "',	
							'" . addslashes($phone) . "',	
							'" . addslashes($stateId) . "',	
							'" . addslashes($_SESSION['jobId']) . "',
                                                        '" . addslashes($contStatus) . "'
					)";

		
        mysql_query($qryInsert);
		$lastInsertId = mysql_insert_id();

	    return $lastInsertId;
	}

	// function to update contact details of sign up user
	function editContactDetails($fname, $lname, $email, $phone, $stateId, $contStatus) {
		$qryUpd = "UPDATE es_contact_details
					SET fname = '" . addslashes($fname) . "',
						lname = '" . addslashes($lname) . "',	
						email = '" . addslashes($email) . "',	
						phoneno = '" . addslashes($phone) . "',	
						state_id = '" . addslashes($stateId) . "',	
						cont_status = '" . addslashes($contStatus) . "',    
					WHERE job_id = '" . $_SESSION['jobId']. "'";					 

        mysql_query($qryUpd);

	    return true;
	}
}
?>