<?
class LEGAL_REFERENCES { 
    
	
	// class constructor
	public function __construct() {
			
  	}

	// function to fetch countries
	function fetchCountries() 
        {
            $qryFetch = "SELECT * FROM es_country";	
            $fetchResult = mysql_query($qryFetch);
            while($rowData = mysql_fetch_assoc($fetchResult)) {
                    $arrStates[$rowData['country_id']] = $rowData['country_name'];
            }
            return $arrStates;
	}

	// function to insert member details of sign up user
	function addLegalReferences($title, $fname, $mname, $lname, $dob, $city, $country, $gender, $address, $tfn, $occupation, $phone, $memberStatus) 
        {
		$qryInsert = "INSERT INTO es_legal_references (job_id, title, fname, mname, lname, dob, city, country_id, gender, address, tfn, occupation, contact_no, member_status)
                      VALUES (
							'" . addslashes($_SESSION['jobId']) . "',
							'" . addslashes($title) . "',
							'" . addslashes($fname) . "',	
							'" . addslashes($mname) . "',	
							'" . addslashes($lname) . "',	
							'" . addslashes($dob) . "',
							'" . addslashes($city) . "',
							'" . addslashes($country) . "',
							'" . addslashes($gender) . "',
							'" . addslashes($address) . "',
							'" . addslashes($tfn) . "',
							'" . addslashes($occupation) . "',
							'" . addslashes($phone) . "',
                                                        '" . addslashes($memberStatus) . "'
					)";

		$flagReturn = mysql_query($qryInsert);

	    return $flagReturn;
	}

	// function to edit member details of sign up user
	function editLegalReferences($memberId, $title, $fname, $mname, $lname, $dob, $city, $country, $gender, $address, $tfn, $occupation, $phone, $memberStatus) {
		$qryUpd = "UPDATE es_legal_references
						SET title = '" . addslashes($title) . "',
							fname = '" . addslashes($fname) . "',
							mname = '" . addslashes($mname) . "',	 
							lname = '" . addslashes($lname) . "',
							dob = '" . addslashes($dob) . "', 
							city = '" . addslashes($city) . "', 
							country_id = '" . addslashes($country) . "', 
							gender = '" . addslashes($gender) . "', 
							address = '" . addslashes($address) . "', 
							tfn = '" . addslashes($tfn) . "', 
							occupation = '" . addslashes($occupation) . "', 
							contact_no = '" . addslashes($phone) . "',
                                                        member_status = '" . addslashes($memberStatus) . "'
						WHERE member_id = " . $memberId ." AND job_id = ".$_SESSION['jobId'];

		$flagReturn = mysql_query($qryUpd);

	    return $flagReturn;
	}

	// function to existing fetch trustee details
	function fetchExistingDetails($jobId) {

		$qryFetch = "SELECT * FROM es_member_details WHERE job_id = '" . $jobId . "'";	

                $fetchResult = mysql_query($qryFetch);
		$count = 1;

		$arrData = array();
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrData[$count++] = $rowData;
		}

		return $arrData;
	}
}
?>