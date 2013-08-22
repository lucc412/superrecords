<?

// include common file
include("include/common.php");

if(isset($_SESSION['jobId'])) {

	// include model file
	include(MODEL . "existing_smsf_fund_class.php");

	// create class object for class function access
	$objScr = new EXISTING_SMSF_FUND();

	// function to download doc file
	if(isset($_REQUEST['doAction']) && $_REQUEST['doAction'] == 'download') {
		$objScr->doc_download();	
	}

	// fetch data is available 
	if(isset($_SESSION['jobId']) && !empty($_SESSION['jobId'])) {

		// fetch existing fund details
		$arrData = $objScr->fetchExistingDetails($_SESSION['jobId']);
	}

	// case when next button is clicked
	if(isset($_REQUEST['doAction']) && $_REQUEST['doAction'] == 'addFundInfo') {
		$fundName = $_REQUEST['txtFund'];
		$abn = $_REQUEST['txtAbn'];
		$streetAdd = $_REQUEST['taStreetAdd'];
		$postalAdd = $_REQUEST['taPostalAdd'];
		$members = $_REQUEST['lstMembers'];
		$trusteeId = $_REQUEST['lstTrustee'];
                $fundStatus = $_REQUEST['fund_status'];
                $jobStatus = $_REQUEST['job_status'];

		// fetch existing fund details
		$arrData = $objScr->fetchExistingDetails($_SESSION['jobId']);

		// fetch existing fund details
		if(empty($arrData)) {

			// insert fund details of sign up user
			$flagReturn = $objScr->addFundInfo($fundName, $abn, $streetAdd, $postalAdd, $members, $trusteeId, $fundStatus, $jobStatus);
		}
		else {
			// edit fund details of sign up user
			$flagReturn = $objScr->editFundInfo($fundName, $abn, $streetAdd, $postalAdd, $members, $trusteeId, $fundStatus, $jobStatus);
		}
                
//            print $jobQry = "SELECT * FROM job WHERE job_id = ".$_SESSION['jobId'];
//            $fetchJob = mysql_query($jobQry);
//            $arrJob = array();
//            while($rowData = mysql_fetch_assoc($fetchJob))
//            {
//                $arrJob[$rowData['job_id']] = $rowData;
//            }
//            print_r($arrJob);exit;
//            print $jobQry = "SELECT * FROM job WHERE job_id = ".$_SESSION['jobId'];
                
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
                        
            $filename = "job_".$jobid.".pdf";
            $docQry = "INSERT INTO documents (job_id,document_title,date,viewed,file_path) VALUES (".$jobid.",'',NOW(),0,'".$filename."')";
            mysql_query($docQry);
            $doc_Id = mysql_insert_id();
            $filename = "job_".$doc_Id.".pdf";
            $doc2Qry = "UPDATE documents SET file_path = '".$filename."' WHERE document_id = ".$doc_Id;
            mysql_query($doc2Qry);
            
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
                            h1 {
                                font-family: helvetica;
                                font-size: 24pt;
                                text-align: center;
                            }
                            p.first {
                                color: #003300;
                                font-family: helvetica;
                                font-size: 12pt;
                            }
                            p.first span {
                                color: #006600;
                                font-style: italic;
                            }
                            p#second {
                                color: rgb(00,63,127);
                                font-family: times;
                                font-size: 12pt;
                                text-align: justify;
                            }
                            p#second > span {
                                background-color: gray;
                            }
                            table.first {
                                font-family: helvetica;
                                font-size: 9pt;
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
                        <div>
                            <h1 class="title">Setup Details</h1>
                        </div>
                        <div class="test">Contact Details</div>
                        <br />
                        <table class="first" cellpadding="4" cellspacing="6">
                            <tr>
                                <td><b>First Name :</b></td>
                                <td><b>'.$arrCntact[$jobid]['fname'].'</b></td>
                            </tr>
                            <tr>
                                <td><b>Last Name :</b></td>
                                <td><b>'.$arrCntact[$jobid]['lname'].'</b></td>
                            </tr>
                            <tr>
                                <td><b>Email Address :</b></td>
                                <td><b>'.$arrCntact[$jobid]['email'].'</b></td>
                            </tr>
                            <tr>
                                <td><b>Phone Number :</b></td>
                                <td><b>'.$arrCntact[$jobid]['phoneno'].'</b></td>
                            </tr>
                            <tr>
                                <td><b>State :</b></td>
                                <td><b>'.fetchStateName($arrCntact[$jobid]['state_id']).'</b></td>
                            </tr>
                        </table>
                        <br/>
                        <div class="test">Fund Details</div>
                        <br/>
                        <table class="first" cellpadding="4" cellspacing="6">
                            <tr>
                                <td><b>Fund Name :</b></td>
                                <td><b>'.$arrFund[$jobid]['fund_name'].'</b></td>
                            </tr>
                            <tr>
                                <td><b>Street Address :</b></td>
                                <td><b>'.$arrFund[$jobid]['street_address'].'</b></td>
                            </tr>
                            <tr>
                                <td><b>Postal Address :</b></td>
                                <td><b>'.$arrFund[$jobid]['postal_address'].'</b></td>
                            </tr>
                            <tr>
                                <td><b>Date of establishment :</b></td>
                                <td><b>'.$arrFund[$jobid]['date_of_establishment'].'</b></td>
                            </tr>
                            <tr>
                                <td><b>State of registration :</b></td>
                                <td><b>'.fetchStateName($arrFund[$jobid]['registration_state']).'</b></td>
                            </tr>
                            <tr>
                                <td><b>How many members? :</b></td>
                                <td><b>'.$arrFund[$jobid]['members'].'</b></td>
                            </tr>
                            <tr>
                                <td><b>Trustee Type :</b></td>
                                <td><b>'.fetchTrusteeName($arrFund[$jobid]['trustee_type_id']).'</b></td>
                            </tr>
                            
                        </table>                        
                        <br/>
                        ';
            

                    // output the HTML content
                    $pdf->writeHTML($html, true, false, true, false, '');

                    //$pdf->Output($filename, 'I');
                    $pdf->Output($_SERVER['DOCUMENT_ROOT']."/uploads/setup/".$filename,"F");
         
                
		if($flagReturn) {
                    
                    if(isset($_POST['fund_status']) && $_POST['fund_status'] == 1)
                            header('Location: jobs.php?a=pending');
                    else
			header('Location: jobs.php?a=saved');
		}
		else {
			echo "Sorry, Please try later.";
		}
	}

	// if data is already entered for current session then set variables
	if(isset($arrData) && !empty($arrData)) {
		$fundName = $arrData['fund_name'];
		$abn = $arrData['abn'];
		$streetAdd = $arrData['street_address'];
		$postalAdd = $arrData['postal_address'];
		$members = $arrData['members'];
		$trusteeType = $arrData['trustee_type_id'];
	}
	// declare variables
	else {
		$fundName = "";
		$abn = "";
		$streetAdd = "";
		$postalAdd = "";
		$members = "";
		$trusteeType = "";
	}

	// define array of members
	$arrNoOfMembers = array('1', '2', '3', '4');

	// fetch trustee type for drop-down
	$arrTrusteeType = $objScr->fetchTrusteeType();
	 
	// include view file 
	include(VIEW . "existing_smsf_fund.php");
}
else {
	header('Location: index.php');
}
?>