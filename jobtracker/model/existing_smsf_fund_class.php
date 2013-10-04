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
        
        function generatePDF()
        {
            $stQry = "UPDATE job SET job_submitted = '".$_REQUEST['job_submitted']."', job_received = NOW() WHERE job_id = ".$_SESSION['jobId'];
            mysql_query($stQry);

            // add new task
            include(MODEL."job_class.php");
            $objJob = new Job();
            $objJob->add_new_task($_SESSION['PRACTICEID'], $_SESSION['jobId']);

            // send mail for new task
            new_job_task_mail();
            
            // Fetch All Details of Job
            $jobid = $_SESSION['jobId'];
            $contQry = "SELECT * FROM es_contact_details WHERE job_id = ".$_SESSION['jobId'];
            $fetchCntact = mysql_query($contQry);
            $arrCntact=array();
            while($rowData = mysql_fetch_assoc($fetchCntact))
            {
                    $arrCntact[$rowData['job_id']] = $rowData;
            }

            $fundQry = "SELECT * FROM es_fund_details WHERE job_id = ".$_SESSION['jobId'];
            $fetchFund = mysql_query($fundQry);
            $arrFund = array();
            while($rowData = mysql_fetch_assoc($fetchFund))
            {
                $arrFund[$rowData['job_id']] = $rowData;
            }

            $jobQry = "SELECT * FROM job WHERE job_id = ".$jobid;
            $fetchJob = mysql_query($jobQry);
            $arrJob = array();
            while($rowData = mysql_fetch_assoc($fetchJob))
            {
                $arrJob[$rowData['job_id']] = $rowData;
            }

            $qryCli = "SELECT t1.client_id, t1.client_name
                        FROM client t1
                        WHERE t1.client_id = '{$arrJob[$jobid]['client_id']}'
                        ORDER BY t1.client_name";

            $fetchClients = mysql_query($qryCli);
            $arrClients = mysql_fetch_assoc($fetchClients);


            $qryPra = "SELECT t1.id, t1.name
                        FROM pr_practice t1
                        WHERE t1.id = '{$_SESSION['PRACTICEID']}'
                        ORDER BY t1.name";

            $fetchPrac = mysql_query($qryPra);
            $arrPractice = mysql_fetch_assoc($fetchPrac);


            $qryAct = "SELECT sa.sub_Code, sa.sub_Description
                                        FROM sub_subactivity sa
                                        WHERE sa.sub_Code = ".$arrJob[$jobid]['job_type_id']."
                                        AND sa.display_in_practice = 'yes'
                                        ORDER BY sa.sub_Order";
            $fetchAct = mysql_query($qryAct);
            $arrActivity = mysql_fetch_assoc($fetchAct);

			// Insert into documents table
			$qrySel = "SELECT max(document_id) docId
					FROM documents";

			$objResult = mysql_query($qrySel);
			$arrInfo = mysql_fetch_assoc($objResult);
			$fileId = $arrInfo['docId'];	
			$fileId++;
			$currentTime = date('Y-m-d H:i:s');

            $filename = $fileId."~setup.pdf";
            $docQry = "INSERT INTO documents (job_id,document_title,date,file_path) VALUES (".$jobid.",'setup','".$currentTime."','".$filename."')";
            mysql_query($docQry);

            include(PDF);
            // create new PDF document
            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

            // set document information
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Super Records');
            $pdf->SetTitle('SuperRecords Setup Report');
            $pdf->SetSubject('SuperRecords Setup Report');
            $pdf->SetKeywords('SuperRecords Setup Report');

            // set default header data
            //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 061', PDF_HEADER_STRING);

            // set header and footer fonts
            $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

            // set default monospaced font
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

            // set margins
            $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

            // set auto page breaks
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

            // set image scale factor
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

            // set some language-dependent strings (optional)
            if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
                require_once(dirname(__FILE__).'/lang/eng.php');
                $pdf->setLanguageArray($l);
            }

            // set font
            $pdf->SetFont('helvetica', '', 10);

            // add a page
            $pdf->AddPage();


            $html = '<!-- EXAMPLE OF CSS STYLE -->
                        <style>
                            h2 {
                                font-family: helvetica;
                                margin:0;
                                color:#F05729;
                            }
                            p {
                                font-family: helvetica;
                                margin:0;
                                color:#F05729;
                                font-size:12px;
                                font-weight: bold;
                            }
                            table.first {
                                font-family: helvetica;
                                font-size: 10px;
                            }

                            div.test {
                                background-color: #074165;
                                color: #FFFFFF;
                                font-family: helvetica;
                                font-size: 11pt;
                                font-weight: bold;
                                padding: 5px;
                            }
                        </style>
                        <table style="margin-bottom: 30px;">
                            <tr>
                                <td><a href="www.superrecords.com.au" style="float:left;margin-right: 40px;"><img src="'.$_SERVER['DOCUMENT_ROOT'].'/jobtracker/images_user/header-logo.png" style="width:250px;" /></a></td>                            
                                <td><p>'.$arrPractice['name'].'</p>
                                    <p>'.$arrClients['client_name'].' - '.$arrJob[$jobid]['period'].' - '.$arrActivity['sub_Description'].'</p>
                                </td>
                            </tr>
                        </table>
                        <br/>
                        <div class="test">Contact Details</div>
                        <br />
                        <table class="first" cellpadding="4" cellspacing="6">
                            <tr>
                                <td>First Name :</td>
                                <td>'.$arrCntact[$jobid]['fname'].'</td>
                            </tr>
                            <tr>
                                <td>Last Name : </td>
                                <td>'.$arrCntact[$jobid]['lname'].' </td>
                            </tr>
                            <tr>
                                <td>Email Address : </td>
                                <td>'.$arrCntact[$jobid]['email'].' </td>
                            </tr>
                            <tr>
                                <td>Phone Number : </td>
                                <td>'.$arrCntact[$jobid]['phoneno'].' </td>
                            </tr>
                        </table>
                        <br/>
                        <div class="test">Fund Details</div>
                        <br/>
                        <table class="first" cellpadding="4" cellspacing="6">
                            <tr>
                                <td>Fund Name : </td>
                                <td>'.$arrFund[$jobid]['fund_name'].' </td>
                            </tr>
                            <tr>
                                <td>Fund ABN : </td>
                                <td>'.$arrFund[$jobid]['abn'].' </td>
                            </tr>
                            <tr>
                                <td>Street Address : </td>
                                <td>'.$arrFund[$jobid]['street_address'].' </td>
                            </tr>
                            <tr>
                                <td>Postal Address : </td>
                                <td>'.$arrFund[$jobid]['postal_address'].' </td>
                            </tr>
                            <tr>
                                <td>How many members? : </td>
                                <td>'.$arrFund[$jobid]['members'].' </td>
                            </tr>
                            <tr>
                                <td>Trustee Type : </td>
                                <td>'.fetchTrusteeName($arrFund[$jobid]['trustee_type_id']).' </td>
                            </tr>

                        </table>                        
                        <!--<br/>
                        <div class="test">Memeber Details</div>
                        <br/>'.$members.$trustee.'-->
                        ';

            // output the HTML content
            $pdf->writeHTML($html, true, false, true, false, '');

            //$pdf->Output($filename, 'I');
            $pdf->Output(UPLOADSETUP.$filename,"F");
        }
        
        
}
?>