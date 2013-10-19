<?
class NEW_SMSF_FUND { 
	
	// class constructor
	public function __construct() {
			
  	}
	
	// function to fetch trustee types
	function fetchTrusteeType() {
		$qryFetch = "SELECT * FROM es_trustee_type";	

                $fetchResult = mysql_query($qryFetch);

		while($rowData = mysql_fetch_assoc($fetchResult)) {
			$arrStates[$rowData['trustee_type_id']] = $rowData['trustee_type_name'];
		}
		return $arrStates;
	}

	// function to insert fund details of sign up user
	function addFundInfo($fundName, $StrAddUnit, $StrAddBuild, $StrAddStreet, $StrAddSubrb, $StrAddState, $StrAddPstCode, $StrAddCntry, $postalAdd, $regDate, $regState, $members, $trusteeId, $fundStatus) 
        {
            $qryInsert = "INSERT INTO es_fund_details(job_id, signup_type, fund_name, strAddUnit, strAddBuild, strAddStreet, strAddSubrb, strAddState, strAddPstCode, strAddCntry, postal_address, date_of_establishment, registration_state, members, trustee_type_id, fund_status)
                    
                      VALUES (
                            '" . addslashes($_SESSION['jobId']) . "',
                            'N',
                            '" . addslashes($fundName) . "',
                            '" . addslashes($StrAddUnit) . "',	
                            '" . addslashes($StrAddBuild) . "',    
                            '" . addslashes($StrAddStreet) . "',
                            '" . addslashes($StrAddSubrb) . "',    
                            '" . addslashes($StrAddState) . "',
                            '" . addslashes($StrAddPstCode) . "',    
                            '" . addslashes($StrAddCntry) . "',
                            '" . addslashes($postalAdd) . "',	
                            '" . addslashes($regDate) . "',	
                            '" . addslashes($regState) . "',	
                            '" . addslashes($members) . "',	
                            '" . addslashes($trusteeId) . "',
                            '" . addslashes($fundStatus) . "'
			)";
            
            $flagReturn = mysql_query($qryInsert);
	    return $flagReturn;
	}

	// function to insert fund details of sign up user
	function editFundInfo($fundName, $StrAddUnit, $StrAddBuild, $StrAddStreet, $StrAddSubrb, $StrAddState, $StrAddPstCode, $StrAddCntry, $postalAdd, $regDate, $regState, $members, $trusteeId, $fundStatus) {
           
           // delete old member details when no of members field is changed
           $qrySel = "SELECT member_id FROM es_member_details WHERE job_id =". $_SESSION['jobId']." ORDER BY member_id desc";
           $objResult = mysql_query($qrySel);
           while($rowMember = mysql_fetch_assoc($objResult)) {
                $arrMemberId[] = $rowMember['member_id'];
           }
           $exstngMember = count($arrMemberId);
           $delMember = $exstngMember - $members;
           
           if($delMember > 0) {
                foreach ($arrMemberId as $memberId) {
                    if($delMember > 0) {
                        $qryDel1 = "DELETE em.*
                                    FROM es_member_details em
                                    WHERE em.member_id =". $memberId;
                        mysql_query($qryDel1);

                        $qryDel2 = "DELETE el.*
                                    FROM es_legal_references el 
                                    WHERE el.member_id = ". $memberId;
                        mysql_query($qryDel2);
                        $delMember--;
                    }
                }
           }
            
           $qryInsert = "UPDATE es_fund_details
                        SET fund_name = '" . addslashes($fundName) . "',
                                strAddUnit = '" . addslashes($StrAddUnit) . "',
                                strAddBuild = '" . addslashes($StrAddBuild) . "',
                                strAddStreet = '" . addslashes($StrAddStreet) . "',    
                                strAddSubrb = '" . addslashes($StrAddSubrb) . "',
                                strAddState = '" . addslashes($StrAddState) . "',
                                strAddPstCode = '" . addslashes($StrAddPstCode) . "',
                                strAddCntry = '" . addslashes($streetAdd) . "',
                                postal_address = '" . addslashes($StrAddCntry) . "',
                                date_of_establishment = '" . addslashes($regDate) . "',
                                registration_state = '" . addslashes($regState) . "',
                                members = '" . addslashes($members) . "',
                                trustee_type_id = '" . addslashes($trusteeId) . "',
                                fund_status = '" . addslashes($fundStatus) . "'
                        WHERE job_id = ". $_SESSION['jobId'];
           
            $flagReturn = mysql_query($qryInsert);
	    return $flagReturn;	
	}

	// function to existing fetch trustee details
	function fetchExistingDetails($jobId) {

		$qryFetch = "SELECT * 
					FROM es_fund_details 
					WHERE job_id = '" . $jobId . "' 
					AND signup_type = 'N'";	

        $fetchResult = mysql_query($qryFetch);

		$arrData = array();
		if($fetchResult) {
			$arrData = mysql_fetch_assoc($fetchResult);
		}

		return $arrData;
	}
        
        function checkClients($fundName)
        {
            $qrySel = "SELECT t1.client_id, t1.client_name FROM client t1
					WHERE id = '{$_SESSION['PRACTICEID']}' AND t1.client_name = '".$fundName."'
					ORDER BY t1.client_name";
                                        
            $fetchResult = mysql_query($qrySel);
            $client_id = "";
            $rowData = mysql_fetch_assoc($fetchResult);
            
            if($rowData)
            {
                $client_id = $rowData['client_id'];
            }
            else
            {
				// client_code
                $qryIns = "INSERT INTO client(client_type_id, client_name, recieved_authority, id, client_received)
					VALUES ( 7, '" . $fundName . "', 1, " . $_SESSION['PRACTICEID'] . ", NOW())";
                
                $flagReturn = mysql_query($qryIns);
                $client_id = mysql_insert_id();
            }

            if(isset($client_id) && $client_id != '')
            {
				$jobName = $client_id .'::Year End 30/06/'. date('Y') .'::21';
                $updt = "UPDATE job SET 
                    client_id = ".$client_id.", 
                    job_name = '".addslashes($jobName)."' 
                    WHERE job_id = ".$_SESSION['jobId'];
                
                mysql_query($updt);
            }
            
            generateClientCode($client_id,$fundName);
            
            return $client_id;
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
}
?>