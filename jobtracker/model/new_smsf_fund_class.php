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
	function addFundInfo($fundName, $streetAdd, $postalAdd, $regDate, $regState, $members, $trusteeId, $fundStatus) {
		$qryInsert = "INSERT INTO es_fund_details(job_id, signup_type, fund_name, street_address, postal_address, date_of_establishment, registration_state, members, trustee_type_id, fund_status)
                      VALUES (
							'" . addslashes($_SESSION['jobId']) . "',
							'N',
							'" . addslashes($fundName) . "',
							'" . addslashes($streetAdd) . "',	
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
	function editFundInfo($fundName, $streetAdd, $postalAdd, $regDate, $regState, $members, $trusteeId, $fundStatus) {
           $qryInsert = "UPDATE es_fund_details
						SET fund_name = '" . addslashes($fundName) . "',
							street_address = '" . addslashes($streetAdd) . "',
							postal_address = '" . addslashes($postalAdd) . "',
							date_of_establishment = '" . addslashes($regDate) . "',
							registration_state = '" . addslashes($regState) . "',
							members = '" . addslashes($members) . "',
							trustee_type_id = '" . addslashes($trusteeId) . "',
                                                        fund_status = '" . addslashes($fundStatus) . "'
						WHERE job_id = ". $_SESSION['jobId'];

            $flagReturn = mysql_query($qryInsert);

	    return $flagReturn;	
	}

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
//                client_code
                $qryIns = "INSERT INTO client(client_type_id, client_name, recieved_authority, id, client_received)
					VALUES ( 7, '" . $fundName . "', 1, " . $_SESSION['PRACTICEID'] . ", NOW())";
                
                $flagReturn = mysql_query($qryIns);
                $client_id = mysql_insert_id();
                
                
                
            }

            if(isset($client_id) && $client_id != '')
            {
                $jobName = $client_id .'::'. date('Y') .'::21';
                $updt = "UPDATE job SET 
                    client_id = ".$client_id.", 
                    job_name = '".addslashes($jobName)."' 
                    WHERE job_id = ".$_SESSION['jobId'];
                
                mysql_query($updt);
            }
            
            generateClientCode($client_id,$fundName);
            
            return $client_id;
        }
}
?>