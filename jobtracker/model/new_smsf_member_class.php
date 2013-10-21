<?
class NEW_SMSF_MEMBER { 
	
	// class constructor
	public function __construct() {
			
  	}

	// function to fetch countries
	function fetchCountries() {
		$qryFetch = "SELECT * FROM es_country";	
                $fetchResult = mysql_query($qryFetch);
                while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrStates[$rowData['country_id']] = $rowData['country_name'];
		}
		return $arrStates;
	}

	// function to insert member details of sign up user
	function addMemberInfo($title, $fname, $mname, $lname, $dob, $city, $country, $gender, $StrAddUnit, $StrAddBuild, $StrAddStreet, $StrAddSubrb, $StrAddState, $StrAddPstCode, $StrAddCntry, $tfn, $occupation, $phone, $memberStatus, $ref) {
		$qryInsert = "INSERT INTO es_member_details(job_id, title, fname, mname, lname, dob, city, country_id, gender, strAddUnit, strAddBuild, strAddStreet, strAddSubrb, strAddState, strAddPstCode, strAddCntry, tfn, occupation, contact_no, member_status, legal_references)
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
							'" . addslashes($StrAddUnit) . "',	
                                                        '" . addslashes($StrAddBuild) . "',    
                                                        '" . addslashes($StrAddStreet) . "',
                                                        '" . addslashes($StrAddSubrb) . "',    
                                                        '" . addslashes($StrAddState) . "',
                                                        '" . addslashes($StrAddPstCode) . "',    
                                                        '" . addslashes($StrAddCntry) . "',
							'" . addslashes($tfn) . "',
							'" . addslashes($occupation) . "',
							'" . addslashes($phone) . "',
                                                        '" . addslashes($memberStatus) . "',
                                                        '". $ref ."'    
					)";
                
		$flagReturn = mysql_query($qryInsert);

	    return $flagReturn;
	}

	// function to edit member details of sign up user
	function editMemberInfo($memberId, $title, $fname, $mname, $lname, $dob, $city, $country, $gender, $StrAddUnit, $StrAddBuild, $StrAddStreet, $StrAddSubrb, $StrAddState, $StrAddPstCode, $StrAddCntry, $tfn, $occupation, $phone, $memberStatus, $ref) 
        {
            $qryUpd = "UPDATE es_member_details
                                                    SET title = '" . addslashes($title) . "',
							fname = '" . addslashes($fname) . "',
							mname = '" . addslashes($mname) . "',	 
							lname = '" . addslashes($lname) . "',
							dob = '" . addslashes($dob) . "', 
							city = '" . addslashes($city) . "', 
							country_id = '" . addslashes($country) . "', 
							gender = '" . addslashes($gender) . "', 
							strAddUnit = '" . addslashes($StrAddUnit) . "',
                                                        strAddBuild = '" . addslashes($StrAddBuild) . "',
                                                        strAddStreet = '" . addslashes($StrAddStreet) . "',    
                                                        strAddSubrb = '" . addslashes($StrAddSubrb) . "',
                                                        strAddState = '" . addslashes($StrAddState) . "',
                                                        strAddPstCode = '" . addslashes($StrAddPstCode) . "',
                                                        strAddCntry = '" . addslashes($StrAddCntry) . "',
							tfn = '" . addslashes($tfn) . "', 
							occupation = '" . addslashes($occupation) . "', 
							contact_no = '" . addslashes($phone) . "',
                                                        member_status = '" . addslashes($memberStatus) . "',
                                                        legal_references = '". $ref ."'
						WHERE member_id = " . $memberId ." AND job_id = ".$_SESSION['jobId'];
            
		$flagReturn = mysql_query($qryUpd);

		if(!empty($ref)) {
			//$qryDel = "DELETE FROM es_legal_references WHERE member_id = {$memberId}";
			//mysql_query($qryDel);
		}

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