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

        function generatePDF()
        {
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
            $filename = "job_".$jobid.".pdf";
            $docQry = "INSERT INTO documents (job_id,document_title,date,viewed,file_path) VALUES (".$jobid.",'',NOW(),0,'".$filename."')";
            mysql_query($docQry);
            $doc_Id = mysql_insert_id();
            $filename = $doc_Id."~job.pdf";
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
            
            
            // HTML Part of PDF
            $members = '';
            $cnt = 1;
            foreach ($arrMembrs as $key => $value) 
            {
               $value["gender"] =($value["gender"] == "M")?"Male":"Female";
               $cntry = "SELECT * FROM es_country WHERE country_id = ".$value['country_id'];
               $fetchCntry = mysql_query($cntry);
               $Data = mysql_fetch_assoc($fetchCntry);
               $value['country_id'] = $Data['country_name'];
               
                $members .= '
                            <table class="first" cellpadding="4" cellspacing="6">
                            <tr>
                                <td colspan="2"><b>Member '.$cnt.'</b></td>
                            </tr>
                            <tr>
                                <td>Member Name : </td>
                                <td>'.$value['title'].' '.$value['fname'].' '.$value['mname'].' '.$value['lname'].' </td>
                            </tr>
                            <tr>
                                <td>Date of Birth : </td>
                                <td>'.$value['dob'].' </td>
                            </tr>
                            <tr>
                                <td>City of Birth : </td>
                                <td>'.$value['city'].' </td>
                            </tr>
                            <tr>
                                <td>Country of Birth : </td>
                                <td>'.$value['country_id'].' </td>
                            </tr>
                            <tr>
                                <td>Sex : </td>
                                <td>'.$value["gender"].' </td>
                            </tr>
                            <tr>
                                <td>Address : </td>
                                <td>'.$value['address'].' </td>
                            </tr>
                            <tr>
                                <td>Tax File Number : </td>
                                <td> '.$value['tfn'].' </td>
                            </tr>
                            <tr>
                                <td>Occupation : </td>
                                <td>'.$value['occupation'].' </td>
                            </tr>
                            <tr>
                                <td>Contact Number : </td>
                                <td>'.$value['contact_no'].' </td>
                            </tr>
                            
                        </table>
                        <br/>';
                $cnt++;
            }
            
            $trustee = '';
            if($arrFund[$jobid]['trustee_type_id'] == 1){
                $trustee .= '';
            }  else if($arrFund[$jobid]['trustee_type_id'] == 2) {
                $trustee .= '<div class="test">New Corporate Trustee Details</div>
                        <br />
                        <table class="first" cellpadding="4" cellspacing="6">
                            <tr>
                                <td>Preferred Company Name : </td>
                                <td>'.$arrNewTrsty[$jobid]['company_name'].' </td>
                            </tr>
                            <tr>
                                <td>Alternative Name Option 1 : </td>
                                <td>'.$arrNewTrsty[$jobid]['alternative_name1'].' </td>
                            </tr>
                            <tr>
                                <td>Alternative Name Option 2 : </td>
                                <td>'.$arrNewTrsty[$jobid]['alternative_name2'].' </td>
                            </tr>
                            <tr>
                                <td>Registered Office Address : </td>
                                <td>'.$arrNewTrsty[$jobid]['office_address'].' </td>
                            </tr>
                            <tr>
                                <td>Principal Place of Business : </td>
                                <td>'.$arrNewTrsty[$jobid]['business_address'].' </td>
                            </tr>
                        </table>';
            }  else if($arrFund[$jobid]['trustee_type_id'] == 3) {
                $trustee .= '<div class="test">Existing Corporate Trustee Details</div>
                        <br />
                        <table class="first" cellpadding="4" cellspacing="6">
                            <tr>
                                <td>Company Name : </td>
                                <td>'.$arrExtTrsty[$jobid]['company_name'].' </td>
                            </tr>
                            <tr>
                                <td>Company A.C.N : </td>
                                <td>'.$arrExtTrsty[$jobid]['acn'].' </td>
                            </tr>
                            <tr>
                                <td>Company A.B.N : </td>
                                <td>'.$arrExtTrsty[$jobid]['abn'].' </td>
                            </tr>
                            <tr>
                                <td>Company T.F.N : </td>
                                <td>'.$arrExtTrsty[$jobid]['tfn'].' </td>
                            </tr>
                            <tr>
                                <td>Registered Office Address : </td>
                                <td>'.$arrExtTrsty[$jobid]['office_address'].' </td>
                            </tr>
                            <tr>
                                <td>Principal Place of Business : </td>
                                <td>'.$arrExtTrsty[$jobid]['business_address'].' </td>
                            </tr>
                            <tr>
                                <td>Are all proposed members of the Superfund are directors of the company ? : </td>
                                <td>'.$arrExtTrsty[$jobid]['yes_no'].' </td>
                            </tr>
                        </table>';
            }
            
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
                                <td><a href="www.superrecords.com.au" style="float:left;margin-right: 40px;"><img src="images_user/header-logo.png" style="width:250px;" /></a></td>                            
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
                            <tr>
                                <td>State : </td>
                                <td>'.fetchStateName($arrCntact[$jobid]['state_id']).' </td>
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
                                <td>Street Address : </td>
                                <td>'.$arrFund[$jobid]['street_address'].' </td>
                            </tr>
                            <tr>
                                <td>Postal Address : </td>
                                <td>'.$arrFund[$jobid]['postal_address'].' </td>
                            </tr>
                            <tr>
                                <td>Date of establishment : </td>
                                <td>'.$arrFund[$jobid]['date_of_establishment'].' </td>
                            </tr>
                            <tr>
                                <td>State of registration : </td>
                                <td>'.fetchStateName($arrFund[$jobid]['registration_state']).' </td>
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
                        <br/>
                        <div class="test">Memeber Details</div>
                        <br/>'.$members.$trustee.'
                        ';
            
            // output the HTML content
            $pdf->writeHTML($html, true, false, true, false, '');

            //$pdf->Output($filename, 'I');
            $pdf->Output(UPLOADSETUP.$filename,"F");
         
        }
        
        function updateTerms($chk)
        {
            $chk = ($chk == 'on')?1:0;
            $qry = "UPDATE es_contact_details SET terms_n_conditn = ".$chk." WHERE job_id = ".$_SESSION['jobId'];
            mysql_query($qry);
        }
        
        function fetchTerms()
        {
            $qry = "SELECT terms_n_conditn FROM es_contact_details WHERE job_id = ".$_SESSION['jobId'];
            $data = mysql_query($qry);
            $rec = mysql_fetch_assoc($data);
            $chk = ($rec['terms_n_conditn'] == '1')?"on":"off";
            
            return $chk;
        }
}
                    
?>