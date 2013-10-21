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
	function addLegalReferences($memberId, $title, $fname, $mname, $lname, $dob, $city, $country, $gender, $StrAddUnit, $StrAddBuild, $StrAddStreet, $StrAddSubrb, $StrAddState, $StrAddPstCode, $StrAddCntry, $tfn, $occupation, $phone) 
        {
		$qryInsert = "INSERT INTO es_legal_references (job_id, member_id, title, fname, mname, lname, dob, city, country_id, gender, strAddUnit, strAddBuild, strAddStreet, strAddSubrb, strAddState, strAddPstCode, strAddCntry, tfn, occupation, contact_no)
                      VALUES (
							'" . addslashes($_SESSION['jobId']) . "',
                                                        '" . $memberId . "',    
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
							'" . addslashes($phone) . "'
                                                        
					)";
                
		$flagReturn = mysql_query($qryInsert);

	    return $flagReturn;
	}

	// function to edit member details of sign up user
	function editLegalReferences($refId, $memberId, $title, $fname, $mname, $lname, $dob, $city, $country, $gender, $StrAddUnit, $StrAddBuild, $StrAddStreet, $StrAddSubrb, $StrAddState, $StrAddPstCode, $StrAddCntry, $tfn, $occupation, $phone) {
		$qryUpd = "UPDATE es_legal_references
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
							contact_no = '" . addslashes($phone) . "'
						WHERE ref_id = ". $refId ." AND member_id = " . $memberId ." AND job_id = ".$_SESSION['jobId'];
                
                

		$flagReturn = mysql_query($qryUpd);

	    return $flagReturn;
	}

	// function to existing fetch trustee details
	function fetchExistingDetails($jobId) {

		$qryFetch = "SELECT * FROM es_legal_references WHERE job_id = '" . $jobId . "'";	

                $fetchResult = mysql_query($qryFetch);
		$count = 1;

		$arrData = array();
		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrData[$count++] = $rowData;
		}

		return $arrData;
	}
        
        function checkLegalRef()
        {
            $qryFetch = "SELECT * FROM es_member_details WHERE job_id = '" . $_SESSION['jobId'] . "' AND legal_references = 1";

            $fetchResult = mysql_query($qryFetch);
            $count = 1;

            $arrData = array();
            while($rowData = mysql_fetch_assoc($fetchResult)) {
                    $arrData[$count++] = $rowData['member_id'];
            }

            return $arrData;
        }
}
?>