<?
class EXISTING_SMSF_FUND { 
	
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
	
	// function to download doc file
	public function doc_download() {		
		$folderPath = "docs/Corporate_Trustee_vs_Individual_Trustees.docx";
		
		ob_clean();
		header("Expires: 0");
		header("Last-Modified: " . gmdate("D, d M Y H:i(worry)") . " GMT");  
		header("Cache-Control: no-store, no-cache, must-revalidate");  
		header("Cache-Control: post-check=0, pre-check=0", false);  
		header("Pragma: no-cache");
		header("Content-type: application/doc");  
		// tell file size  
		header('Content-length: '.filesize($folderPath));  
		// set file name  
		header('Content-disposition: attachment; filename="Corporate_Trustee_vs_Individual_Trustees.docx"');  
		readfile($folderPath);
		 
		// Exit script. So that no useless data is output-ed.  
		exit; 
	}

	// function to existing fetch contact details
	function fetchExistingDetails($signupId) {
		$qryFetch = "SELECT * 
					FROM es_fund_details 
					WHERE job_id = '" . $signupId . "' 
					AND signup_type = 'E'";	

        $fetchResult = mysql_query($qryFetch);

		$arrData = array();
		if($fetchResult) {
			$arrData = mysql_fetch_assoc($fetchResult);
		}

		return $arrData;
	}

	// function to insert fund details of sign up user
	function addFundInfo($fundName, $abn, $streetAdd, $postalAdd, $members, $trusteeId, $fundStatus, $jobStatus) {
		$qryInsert = "INSERT INTO es_fund_details(job_id, fund_name, abn, street_address, postal_address, members, trustee_type_id, fund_status)
                      VALUES (
							'" . addslashes($_SESSION['jobId']) . "',
							'" . addslashes($fundName) . "',
							'" . addslashes($abn) . "',
							'" . addslashes($streetAdd) . "',	
							'" . addslashes($postalAdd) . "',	
							'" . addslashes($members) . "',	
							'" . addslashes($trusteeId) . "',
                                                        '" . addslashes($fundStatus) . "'
					)";

            $flagReturn = mysql_query($qryInsert);
            if($jobStatus == 'Y')
            {
                $stQry = "UPDATE job SET job_submitted = '".$jobStatus."' WHERE job_id = ".$_SESSION['jobId'];
                $flagReturn = mysql_query($stQry);
            }
	    return $flagReturn;	
	}

	// function to insert fund details of sign up user
	function editFundInfo($fundName, $abn, $streetAdd, $postalAdd, $members, $trusteeId, $fundStatus, $jobStatus) {
		$qryInsert = "UPDATE es_fund_details
					SET fund_name = '" . addslashes($fundName) . "',
						abn = '" . addslashes($abn) . "',
						street_address = '" . addslashes($streetAdd) . "',	
						postal_address = '" . addslashes($postalAdd) . "',	
						members = '" . addslashes($members) . "',	
						trustee_type_id = '" . addslashes($trusteeId) . "',
                                                fund_status = '".addslashes($fundStatus)."'
					WHERE job_id = '" . $_SESSION['jobId']. "'";

        $flagReturn = mysql_query($qryInsert);
            if($jobStatus == 'Y')
            {
                $stQry = "UPDATE job SET job_submitted = '".$jobStatus."' WHERE job_id = ".$_SESSION['jobId'];
                $flagReturn = mysql_query($stQry);
            }
	    return $flagReturn;	
	}
}
?>