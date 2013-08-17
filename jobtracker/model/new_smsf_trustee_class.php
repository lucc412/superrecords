<?
class NEW_SMSF_TRUSTEE
{ 
	// class constructor
	public function __construct()
	{ 
	
	}
	
	// function to insert trustee details of New trustee
	function addNewTrustee($jobId, $cName, $name1, $name2, $regAddress, $priAddress, $newTrstStats) {
		$qryInsert = "INSERT INTO es_new_trustee(job_id, company_name, alternative_name1, alternative_name2, office_address, business_address, newTrusty_status)					 
                      VALUES (
							'" . addslashes($jobId) . "',
							'" . addslashes($cName) . "',	
							'" . addslashes($name1) . "',	
							'" . addslashes($name2) . "',	
							'" . addslashes($regAddress) . "',	
							'" . addslashes($priAddress) . "',
                                                        '" . addslashes($newTrstStats) . "'
					)";

        mysql_query($qryInsert);

	    return true;	
	}

	// function to insert trustee details of New trustee
	function editNewTrustee($cName, $name1, $name2, $regAddress, $priAddress, $newTrstStats) {
		$qryUpd = "UPDATE es_new_trustee
						SET company_name = '" . addslashes($cName) . "',
							alternative_name1 = '" . addslashes($name1) . "',
							alternative_name2 = '" . addslashes($name2) . "',	
							office_address = '" . addslashes($regAddress) . "',	
							business_address = '" . addslashes($priAddress) . "',
                                                        newTrusty_status = '" . addslashes($newTrstStats) . "',
						WHERE job_id = " . $_SESSION['jobId'];

        mysql_query($qryUpd);

	    return true;	
	}
	
	// function to insert trustee details of Existing trustee
	function addExistingTrustee($jobId, $cName, $acn, $abn, $tfn, $regAddress, $priAddress, $yesNo, $extTrstStats) {
		$qryInsert = "INSERT INTO es_existing_trustee(job_id, company_name, abn, tfn, office_address, business_address, yes_no, extTrusty_status)					 
                      VALUES (
							'" . addslashes($jobId) . "',
							'" . addslashes($cName) . "',	
							'" . addslashes($acn) . "',	
							'" . addslashes($abn) . "',	
							'" . addslashes($tfn) . "',	
							'" . addslashes($regAddress) . "',	
							'" . addslashes($priAddress) . "',
							'" . addslashes($yesNo) . "',
                                                        '" . addslashes($extTrstStats) . "'
					)";

        mysql_query($qryInsert);

	    return true;	
	}

	// function to insert trustee details of Existing trustee
	function editExistingTrustee($cName, $acn, $abn, $tfn, $regAddress, $priAddress, $yesNo, $extTrstStats) {
		$qryUpd = "UPDATE es_existing_trustee
						SET company_name = '" . addslashes($cName) . "',
							 acn = '" . addslashes($acn) . "',
							 abn = '" . addslashes($abn) . "',
							 tfn = '" . addslashes($tfn) . "',
							 office_address = '" . addslashes($regAddress) . "',
							 business_address = '" . addslashes($priAddress) . "',
							 yes_no = '" . addslashes($yesNo) . "',
                                                         extTrusty_status = '".$extTrstStats."'    
						WHERE job_id = " . $_SESSION['jobId'];
									
        mysql_query($qryUpd);

	    return true;	
	}

	// function to existing fetch trustee details
	function fetchExistingDetails($jobId) {

		// for New Corporate Trustee
		if($_SESSION['TRUSTEETYPE'] == '2') {
			$tableName = "es_new_trustee";
		}
		// for Existing Corporate Trustee
		else if($_SESSION['TRUSTEETYPE'] == '3') {
			$tableName = "es_existing_trustee";
		}	

		$qryFetch = "SELECT * FROM " . $tableName . " WHERE job_id = '" . $jobId . "'";	

        $fetchResult = mysql_query($qryFetch);
		$arrData = mysql_fetch_assoc($fetchResult);

		return $arrData;
	}
}
?>