<?
class DECLARATIONS
{ 	
	// class constructor
	public function __construct()
	{ 
	
	}
	
	// function to fetch states
	function fetchQuestions()
	{
            $qryFetch = "SELECT * FROM es_declarations";	

            $fetchResult = mysql_query($qryFetch);

            while($rowData = mysql_fetch_assoc($fetchResult))
            {
                    $arrQues[$rowData['question_id']] = $rowData;
            }

            return $arrQues;
	}
//        
//        function fetchStateName($id) 
//        {
//            $qryFetch = "SELECT cs.cst_Code state_id, cs.cst_Description state_name 
//					FROM cli_state cs WHERE cs.cst_Code = ".$id;
//
//            $fetchResult = mysql_query($qryFetch);
//            $rowData = mysql_fetch_assoc($fetchResult);
//            
//            return $rowData['state_name'];
//	}
//        
//        function fetchTrusteeName($id) 
//        {
//            $qryFetch = "SELECT * FROM es_trustee_type  WHERE trustee_type_id = ".$id;
//
//            $fetchResult = mysql_query($qryFetch);
//            $rowData = mysql_fetch_assoc($fetchResult);
//            
//            return $rowData['trustee_type_name'];
//	}
        
        function generatePDF()
        {
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
            
            $memberQry = "SELECT * FROM es_member_details WHERE job_id = ".$_SESSION['jobId'];
            $fetchMembr = mysql_query($memberQry);
            while($rowData = mysql_fetch_assoc($fetchMembr))
            {
                $arrMembrs[$rowData['member_id']] = $rowData;
            }
            
            $newTrstyQry = "SELECT * FROM es_new_trustee WHERE job_id = ".$_SESSION['jobId'];
            $fetchNewTrsty = mysql_query($newTrstyQry);
            $arrNewTrsty = array();
            while($rowData = mysql_fetch_assoc($fetchNewTrsty))
            {
                $arrNewTrsty[$rowData['job_id']] = $rowData;
            }
            
            $extTrstyQry = "SELECT * FROM es_existing_trustee WHERE job_id = ".$_SESSION['jobId'];
            $fetchExtTrsty = mysql_query($extTrstyQry);
            $arrExtTrsty = array();
            while($rowData = mysql_fetch_assoc($fetchExtTrsty))
            {
                $arrExtTrsty[$rowData['job_id']] = $rowData;
            }
            
//            $jobQry = "SELECT * FROM job WHERE job_id = ".$jobid;
//            $fetchJob = mysql_query($jobQry);
//            $arrJob = array();
//            while($rowData = mysql_fetch_assoc($fetchJob))
//            {
//                $arrJob[$rowData['job_id']] = $rowData;
//            }
//            print_r($arrJob);exit;
            
            $filename = "job_".$jobid.".pdf";
            $docQry = "INSERT INTO documents (job_id,document_title,date,viewed,file_path) VALUES (".$jobid.",'',NOW(),0,'".$filename."')";
            mysql_query($docQry);
            $doc_Id = mysql_insert_id();
            $filename = $doc_Id."~job_".$doc_Id.".pdf";
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
            
            $members = '';
            foreach ($arrMembrs as $key => $value) 
            {
               $value["gender"] =($value["gender"] == "M")?"Male":"Female";
               $cntry = "SELECT * FROM es_country WHERE country_id = ".$value['country_id'];
               $fetchCntry = mysql_query($cntry);
               $Data = mysql_fetch_assoc($fetchCntry);
               $value['country_id'] = $Data['country_name'];
               
                $members .= '<table class="first" cellpadding="4" cellspacing="6">
                            <tr>
                                <td><b>Member Name :</b></td>
                                <td><b>'.$value['title'].' '.$value['fname'].' '.$value['mname'].' '.$value['lname'].'</b></td>
                            </tr>
                            <tr>
                                <td><b>Date of Birth :</b></td>
                                <td><b>'.$value['dob'].'</b></td>
                            </tr>
                            <tr>
                                <td><b>City of Birth :</b></td>
                                <td><b>'.$value['city'].'</b></td>
                            </tr>
                            <tr>
                                <td><b>Country of Birth :</b></td>
                                <td><b>'.$value['country_id'].'</b></td>
                            </tr>
                            <tr>
                                <td><b>Sex :</b></td>
                                <td><b>'.$value["gender"].'</b></td>
                            </tr>
                            <tr>
                                <td><b>Address :</b></td>
                                <td><b>'.$value['address'].'</b></td>
                            </tr>
                            <tr>
                                <td><b>Tax File Number :</b></td>
                                <td><b>'.$value['tfn'].'</b></td>
                            </tr>
                            <tr>
                                <td><b>Occupation :</b></td>
                                <td><b>'.$value['occupation'].'</b></td>
                            </tr>
                            <tr>
                                <td><b>Contact Number :</b></td>
                                <td><b>'.$value['contact_no'].'</b></td>
                            </tr>
                            
                        </table>
                        <br/>';
                
            }
            
            $trustee = '';
            if($arrFund[$jobid]['trustee_type_id'] == 1){
                $trustee .= '';
            }  else if($arrFund[$jobid]['trustee_type_id'] == 2) {
                $trustee .= '<div class="test">New Corporate Trustee Details</div>
                        <br />
                        <table class="first" cellpadding="4" cellspacing="6">
                            <tr>
                                <td><b>Preferred Company Name :</b></td>
                                <td><b>'.$arrNewTrsty[$jobid]['company_name'].'</b></td>
                            </tr>
                            <tr>
                                <td><b>Alternative Name Option 1 :</b></td>
                                <td><b>'.$arrNewTrsty[$jobid]['alternative_name1'].'</b></td>
                            </tr>
                            <tr>
                                <td><b>Alternative Name Option 2 :</b></td>
                                <td><b>'.$arrNewTrsty[$jobid]['alternative_name2'].'</b></td>
                            </tr>
                            <tr>
                                <td><b>Registered Office Address :</b></td>
                                <td><b>'.$arrNewTrsty[$jobid]['office_address'].'</b></td>
                            </tr>
                            <tr>
                                <td><b>Principal Place of Business :</b></td>
                                <td><b>'.$arrNewTrsty[$jobid]['business_address'].'</b></td>
                            </tr>
                        </table>';
            }  else if($arrFund[$jobid]['trustee_type_id'] == 3) {
                $trustee .= '<div class="test">Existing Corporate Trustee Details</div>
                        <br />
                        <table class="first" cellpadding="4" cellspacing="6">
                            <tr>
                                <td><b>Company Name :</b></td>
                                <td><b>'.$arrExtTrsty[$jobid]['company_name'].'</b></td>
                            </tr>
                            <tr>
                                <td><b>Company A.C.N :</b></td>
                                <td><b>'.$arrExtTrsty[$jobid]['acn'].'</b></td>
                            </tr>
                            <tr>
                                <td><b>Company A.B.N :</b></td>
                                <td><b>'.$arrExtTrsty[$jobid]['abn'].'</b></td>
                            </tr>
                            <tr>
                                <td><b>Company T.F.N :</b></td>
                                <td><b>'.$arrExtTrsty[$jobid]['tfn'].'</b></td>
                            </tr>
                            <tr>
                                <td><b>Registered Office Address :</b></td>
                                <td><b>'.$arrExtTrsty[$jobid]['office_address'].'</b></td>
                            </tr>
                            <tr>
                                <td><b>Principal Place of Business :</b></td>
                                <td><b>'.$arrExtTrsty[$jobid]['business_address'].'</b></td>
                            </tr>
                            <tr>
                                <td><b>Are all proposed members of the Superfund are directors of the company ? :</b></td>
                                <td><b>'.$arrExtTrsty[$jobid]['yes_no'].'</b></td>
                            </tr>
                        </table>';
            }
            
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
                        <div class="test">Memeber Details</div>
                        <br/>'.$members.$trustee.'
                        ';
            

            // output the HTML content
            $pdf->writeHTML($html, true, false, true, false, '');

            //$pdf->Output($filename, 'I');
            $pdf->Output($_SERVER['DOCUMENT_ROOT']."/uploads/setup/".$filename,"F");
         
        }
}
                    
?>