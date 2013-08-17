<?
class NEW_SMSF_CONTACT { 	

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
	
	// function to check valid Referral Code 
	function checkIfCodeExists($refcode){
		
		$qry = "SELECT r.code FROM rf_referrer r WHERE r.code = '".$refcode."'";

		$res = mysql_query($qry);
		$code = mysql_fetch_row($res);
		
		if(isset($code[0]) && $code[0] != ''){
			if(isset($_SESSION['NEW_REFCODE'])) unset($_SESSION['NEW_REFCODE']);
			$_SESSION['NEW_REFCODE'] = $code[0];
			return TRUE;
		}
		else	
			return FALSE;
	}
	
	// function to insert contact details of sign up user
	function addContactDetails($fname, $lname, $email, $phone, $stateId, $refCode, $contStatus) {
		
		$qryInsert = "INSERT INTO es_contact_details(job_id,signup_type, fname, lname, email, phoneno, state_id, referral_code, cont_status)					 
                      VALUES ('" . $_SESSION['jobId'] . "',
							'N',
							'" . addslashes($fname) . "',
							'" . addslashes($lname) . "',	
							'" . addslashes($email) . "',	
							'" . addslashes($phone) . "',	
							'" . addslashes($stateId) . "',	
							'" . addslashes($refCode) . "',
                                                        '" . addslashes($contStatus) . "'
					)";
					
			
	    mysql_query($qryInsert);
		$lastInsertId = mysql_insert_id();

	    return $lastInsertId;	
	}

	// function to update contact details of sign up user
	function editContactDetails($fname, $lname, $email, $phone, $stateId, $refCode, $contStatus) {
		
		$qryUpd = "UPDATE es_contact_details
						SET fname = '" . addslashes($fname) . "',
							lname = '" . addslashes($lname) . "',
							email = '" . addslashes($email) . "',
							phoneno = '" . addslashes($phone) . "',
							state_id = '" . addslashes($stateId) . "',
							referral_code = '" . addslashes($refCode) . "',
                                                        cont_status = '" . addslashes($contStatus) . "'
						WHERE job_id = " . $_SESSION['jobId'];		
			
                mysql_query($qryUpd);

		return true;
	}

	// function to existing fetch trustee details
	function fetchExistingDetails($signupId) {

		$qryFetch = "SELECT * 
					FROM es_contact_details 
					WHERE job_id = '" . $signupId . "' 
					AND signup_type = 'N'";	

        $fetchResult = mysql_query($qryFetch);
	
		$arrData = array();
		if($fetchResult) {
			$arrData = mysql_fetch_assoc($fetchResult);
		}

		return $arrData;
	}
}
?>