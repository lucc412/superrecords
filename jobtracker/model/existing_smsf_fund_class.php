<?
class EXISTING_SMSF_FUND 
{ 
	
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
	function addFundInfo($fundName, $abn, $streetAdd, $postalAdd, $members, $trusteeId, $fundStatus, $jobStatus) 
        {
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
            return $flagReturn;	
	}

	// function to insert fund details of sign up user
	function editFundInfo($fundName, $abn, $streetAdd, $postalAdd, $members, $trusteeId, $fundStatus, $jobStatus) 
        {
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
            
            return $flagReturn;	
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
					VALUES ( 7, '" . $fundName . "', 1, " . $_SESSION['PRACTICEID'] . ", '".date('Y-m-d')."')";
                
                $flagReturn = mysql_query($qryIns);
                $client_id = mysql_insert_id();
            
                generateClientCode($client_id,$fundName);
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
            
            return $client_id;
        }
        
        function generatePDF()
        {
            // process new job
            submitSavedJob();
            
            include(MODEL . "setup_preview_class.php");
            $objStpPrvw = new SETUP_PREVIEW();
            
            // Insert into documents table
            $qrySel = "SELECT max(document_id) docId FROM documents";

            $objResult = mysql_query($qrySel);
            $arrInfo = mysql_fetch_assoc($objResult);
            $fileId = $arrInfo['docId'];	
            $fileId++;
            $currentTime = date('Y-m-d H:i:s');

            $filename = $fileId."~setup.pdf";
            $docQry = "INSERT INTO documents (job_id,document_title,date,file_path) VALUES (".$_SESSION['jobId'].",'setup','".$currentTime."','".$filename."')";
            mysql_query($docQry);

            $html = $objStpPrvw->generatePreview();
            $title1 = $_SESSION['PRACTICENAME'];
            $title2 = returnJobName();
            
            // Create PDF
            createPDF($html,$filename,$title1,$title2);

        }
        
        
}
?>
