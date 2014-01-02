<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of preview_class
 *
 * @author dishag
 */
class Preview {
    
    // fetch fund data
    public function fetchFundData() {
            $qryfund = "SELECT tf.fund, tf.trustee_id, ht.trustee_name, tf.noofmember, tf.noofdirector, tf.comp_name, tf.acn, tf.reg_address
                        FROM dbn_fund tf, holding_trustee ht
                        WHERE tf.job_id = ".$_SESSION['jobId']."
                        AND ht.trustee_id = tf.trustee_id";
            $fetchFund = mysql_query($qryfund);
            $rowData = mysql_fetch_assoc($fetchFund);
            return $rowData;
    }
    
    // fetch director details
    public function fetchDirectorDetails()
    {
       $selQry="SELECT d_id, name, res_add address 
                FROM dbn_director 
                WHERE job_id=".$_SESSION['jobId'];
        $fetchResult = mysql_query($selQry);
        while($rowData = mysql_fetch_assoc($fetchResult)) {
            $arrIndvdlTrust[] = $rowData;
        }
        
        return $arrIndvdlTrust;
    }
    
    // fetch individual trust details
    public function fetchIndividualTrustDetails()
    {
       $selQry="SELECT indvdl_id, fname, lname,mname, res_add address FROM dbn_indvdl_member 
                WHERE job_id=".$_SESSION['jobId'];
        $fetchResult = mysql_query($selQry);
        while($rowData = mysql_fetch_assoc($fetchResult)) {
            $arrIndvdlTrust[] = $rowData;
        }
        
        return $arrIndvdlTrust;
    }
	
	//fetch nomination 
	public function fetchNominations()
	{
		$selQury = "Select name, res_add address, DATE_FORMAT(dob, '%d/%m/%Y')dob, noofbeneficiars from dbn_nomination WHERE job_id=".$_SESSION['jobId'];
		$fetchResult = mysql_query($selQury);
		$rowData = mysql_fetch_assoc($fetchResult);        
        return $rowData;
	}
	
	//fetch nomination 
	public function fetchNominationsBenef()
	{
		$selQury = "Select name, res_add address, DATE_FORMAT(dob, '%d/%m/%Y')dob, relationship, portion from dbn_nomination_benef WHERE job_id=".$_SESSION['jobId'];
		$fetchResult = mysql_query($selQury);
        while($rowData = mysql_fetch_assoc($fetchResult)) {
            $arr[] = $rowData;
        }
        
        return $arr;
	}

    // generate preview/pdf code
    public function generatePreview() {
       $arrFundDetail = $this->fetchFundData();       
       $arrNominations = $this->fetchNominations();
	   //echo "<pre>";	   print_r($arrNominations);exit;
	   $arrNominationsBenef = $this->fetchNominationsBenef();
       $html = '';
       $styleCSS = '<style>
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
                                font-size: 12px;
                        }

                        div.test {
                                background-color: #074165;
                                color: #FFFFFF;
                                font-family: helvetica;
                                font-size: 11pt;
                                font-weight: bold;
                                padding: 5px;
                                /*width:55%;*/
                        }
                    </style>';
       
        /* Fund details starts */
        $fundTypeData = "";
        
        // individual
        if($arrFundDetail['trustee_id'] == '1') {
            $arrIndvdlTrust = $this->fetchIndividualTrustDetails();
            $fundType = '<tr>
                                <td>No of trustees :</td>
                                <td>'.$arrFundDetail['noofmember'].'</td>
                            </tr>';
            
            $memberCtr = 1;
            foreach ($arrIndvdlTrust as $individualInfo) {
                $fundTypeData .= '<table class="first" cellpadding="4" cellspacing="6">
                                        <tr>
                                            <td colspan="2"><u>Trustee '.$memberCtr.'</u></td>
                                        </tr>
                                        <tr>
                                            <td>First Name:</td>
                                            <td>'.$individualInfo['fname'].'</td>
                                        </tr>
                                        <tr>
                                            <td>Middle Name:</td>
                                            <td>'.$individualInfo['mname'].'</td>
                                        </tr>
                                        <tr>
                                            <td>Last Name:</td>
                                            <td>'.$individualInfo['lname'].'</td>
                                        </tr>
                                        <tr>
                                            <td>Residential Address :</td>
                                            <td>'.$individualInfo['address'].'</td>
                                        </tr>
                                   </table>';
                $memberCtr++;
            }
        }
        // corporate
        elseif($arrFundDetail['trustee_id'] == '2') {
            $arrDirectors = $this->fetchDirectorDetails();
			//echo "<pre>";			print_r($arrDirectors);
            $fundType = '<tr>
                                    <td>Name of company :</td>
                                    <td>'.$arrFundDetail['comp_name'].'</td>
                                </tr>
                                <tr>
                                    <td>ACN Number :</td>
                                    <td>'.$arrFundDetail['acn'].'</td>
                                </tr>
                                <tr>
                                    <td>Registered Address :</td>
                                    <td>'.$arrFundDetail['reg_address'].'</td>
                                </tr>
                                <tr>
                                    <td>No of Directors :</td>
                                    <td>'.$arrFundDetail['noofdirector'].'</td>
                                </tr>';
            $memberCtr = 1;
            foreach ($arrDirectors as $director) {
                $fundTypeData .= '<table class="first" cellpadding="4" cellspacing="6">
                                        <tr>
                                            <td colspan="2"><u>Director '.$memberCtr.'</u></td>
                                        </tr>
                                        <tr>
                                            <td>Name:</td>
                                            <td>'.$director['name'].'</td>
                                        </tr>
                                        <tr>
                                            <td>Residential Address :</td>
                                            <td>'.$director['address'].'</td>
                                        </tr>
                                   </table>';
                $memberCtr++;
            }
        }
        
        $fund = '<div class="test">Fund Details</div>
                        <br />
                        <table class="first" cellpadding="4" cellspacing="6">
                            <tr>
                                <td>Name of Fund :</td>
                                <td>'.$arrFundDetail['fund'].'</td>
                            </tr>
                            <tr>
                                <td>Trustee Type :</td>
                                <td>'.$arrFundDetail['trustee_name'].'</td>
                            </tr>
							'.$fundType.'
                        </table>'.$fundTypeData.'<br/>';        
        /* Fund details ends */
		
		/* Nominations	Benef	*/		
			$memberCtr = 1;
            foreach ($arrNominationsBenef as $datas) {
                $NominationsBenefData .= '<table class="first" cellpadding="4" cellspacing="6">
                                        <tr>
                                            <td colspan="2"><u>Beneficiary '.$memberCtr.'</u></td>
                                        </tr>
                                        <tr>
                                            <td>Full Name:</td>
                                            <td>'.$datas['name'].'</td>
                                        </tr>
                                        <tr>
                                            <td>Date of Birth:</td>
                                            <td>'.$datas['dob'].'</td>
                                        </tr>
                                        <tr>
                                            <td>Residential Address:</td>
                                            <td>'.$datas['address'].'</td>
                                        </tr>
                                        <tr>
                                            <td>Relationship:</td>
                                            <td>'.$datas['relationship'].'</td>
                                        </tr>
										<tr>
                                            <td>Portion (%) of Death Benefit:</td>
                                            <td>'.$datas['portion'].'</td>
                                        </tr>
                                   </table>';
                $memberCtr++;
            }
			
			$nomination = '<div class="test">Nomination</div>
                        <br />
                        <table class="first" cellpadding="4" cellspacing="6">
                            <tr>
                                <td>Name of Member :</td>
                                <td>'.$arrNominations['name'].'</td>
                            </tr>
                            <tr>
                                <td>Residential Address:</td>
                                <td>'.$arrNominations['address'].'</td>
                            </tr>
							<tr>
                                <td>Date of Birth:</td>
                                <td>'.$arrNominations['dob'].'</td>
                            </tr>
							<tr>
                                <td>Number of Beneficiaries:</td>
                                <td>'.$arrNominations['noofbeneficiars'].'</td>
                            </tr>'.$NominationsBenefData.'
                        </table>';   
						
        /*End Numbet of benef*/
		
        $html = $styleCSS.$fund.$nomination;
        return $html;
        
    }
    
    function generatePDF($html) {

        // process new job
        submitSavedJob();

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

        $title1 = $_SESSION['PRACTICENAME'];
        $title2 = returnJobName();

        // Create PDF
        createPDF($html,$filename,$title1,$title2);
    }
}
?>
