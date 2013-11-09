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
    public function getFundDetails() {
            $qrySel = "SELECT fund_name, CONCAT_WS(',', met_add_unit, met_add_build, met_add_street, met_add_subrb, cst_Description, met_add_pst_code, country_name) met_address, 
                        dt_estblshmnt, action_type, appointment_clause, resignation_clause
                        FROM cot_fund, es_country, cli_state
                        WHERE job_id = ".$_SESSION['jobId']."
                        AND met_add_country = country_id 
                        AND met_add_state = cst_Code";
            $fetchSel = mysql_query($qrySel);
            $rowData = mysql_fetch_assoc($fetchSel);
            return $rowData;
    }
    
    // fetch existing trustee data
    public function fetchExtTrustData() {
            $qrySel = "SELECT tf.trustee_id, ht.trustee_name, tf.noofmember, tf.comp_name, tf.acn, tf.tfn, tf.reg_address, tf.director
                        FROM cot_exsting_trustee tf, holding_trustee ht
                        WHERE tf.job_id = ".$_SESSION['jobId']."
                        AND ht.trustee_id = tf.trustee_id";
            $fetchFund = mysql_query($qrySel);
            $rowData = mysql_fetch_assoc($fetchFund);
            return $rowData;
    }
    
    // fetch existing individual trustee details
    public function fetchExtIndividualDetails()
    {
       $selQry="SELECT indvdl_id, trustee_name name, res_add address
                FROM cot_indvdl_exst_trustee 
                WHERE job_id=".$_SESSION['jobId'];
        $fetchResult = mysql_query($selQry);
        while($rowData = mysql_fetch_assoc($fetchResult)) {
            $arrIndvdlTrust[] = $rowData;
        }
        
        return $arrIndvdlTrust;
    }
    
    // fetch new trustee data
    public function fetchNewTrustData() {
            $qrySel = "SELECT tf.trustee_id, ht.trustee_name, tf.noofmember, tf.comp_name, tf.acn, tf.tfn, tf.reg_address, tf.director
                        FROM cot_new_trustee tf, holding_trustee ht
                        WHERE tf.job_id = ".$_SESSION['jobId']."
                        AND ht.trustee_id = tf.trustee_id";
            $fetchFund = mysql_query($qrySel);
            $rowData = mysql_fetch_assoc($fetchFund);
            return $rowData;
    }
    
    // fetch new individual trustee details
    public function fetchIndividualFundDetails()
    {
       $selQry="SELECT indvdl_id, trustee_name name, res_add address
                FROM cot_indvdl_new_trustee 
                WHERE job_id=".$_SESSION['jobId'];
        $fetchResult = mysql_query($selQry);
        while($rowData = mysql_fetch_assoc($fetchResult)) {
            $arrIndvdlFund[] = $rowData;
        }
        
        return $arrIndvdlFund;
    }

    // fetch member data
    public function fetchMemberData() {
            $qrySel = "SELECT CONCAT_WS(' ', md.fname, md.mname, md.lname) memberName, md.dob, md.city_birth, md.cntry_birth, md.tfn, md.res_add
                        FROM cot_member_details md
                        WHERE md.job_id = ".$_SESSION['jobId'];
            $fetchRow = mysql_query($qrySel);
            $memberCtr = 1;
            while($rowData = mysql_fetch_assoc($fetchRow)) {
                $arrMembers[$memberCtr++] = $rowData;
            }
            return $arrMembers;
    }
    
    // generate preview/pdf code
    public function generatePreview() {
       $arrFund = $this->getFundDetails();  
       $arrExtTrust = $this->fetchExtTrustData();
       $arrNewTrust = $this->fetchNewTrustData();
       $arrMembers = $this->fetchMemberData();
       $arrCountry = fetchCountries();
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
                                width:55%;
                        }
                    </style>';
       
        /* Fund details starts */
        $fund = '<div class="test">Fund Details</div>
                <br />
                <table class="first" cellpadding="4" cellspacing="6">
                    <tr>
                        <td>Name of Fund :</td>
                        <td>'.$arrFund['fund_name'].'</td>
                    </tr>
                    <tr>
                        <td>Meeting Address :</td>
                        <td>'.stringltrim($arrFund['met_address'], ',').'</td>
                    </tr>
                    <tr>
                        <td>Date of Establishment :</td>
                        <td>'.$arrFund['dt_estblshmnt'].'</td>
                    </tr>
                    <tr>
                        <td>Action Type :</td>
                        <td>'.$arrFund['action_type'].'</td>
                    </tr>
                    <tr>
                        <td>Appointment Clause :</td>
                        <td>'.$arrFund['appointment_clause'].'</td>
                    </tr>
                    <tr>
                        <td>Resignation Clause :</td>
                        <td>'.$arrFund['resignation_clause'].'</td>
                    </tr>
                </table><br/>';
        /* Fund details ends */
       
        /* Existing trustee details starts */
        // individual
        if($arrExtTrust['trustee_id'] == '1') {
            $arrIndvdlTrust = $this->fetchExtIndividualDetails();
            $extTrustee = '<tr>
                                <td>No of Individuals :</td>
                                <td>'.$arrExtTrust['noofmember'].'</td>
                            </tr>';
            
            $memberCtr = 1;
            $trustIndividual = "";
            foreach ($arrIndvdlTrust as $individualInfo) {
                $trustIndividual .= '<table class="first" cellpadding="4" cellspacing="6">
                                    <tr>
                                        <td colspan="2"><u>Individual '.$memberCtr.'</u></td>
                                    </tr>
                                    <tr>
                                        <td>Name :</td>
                                        <td>'.$individualInfo['name'].'</td>
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
        elseif($arrExtTrust['trustee_id'] == '2') {
            $extTrustee = '<tr>
                                <td>Name of company :</td>
                                <td>'.$arrExtTrust['comp_name'].'</td>
                            </tr>
                            <tr>
                                <td>ACN Number :</td>
                                <td>'.$arrExtTrust['acn'].'</td>
                            </tr>
                            <tr>
                                <td>TFN Number :</td>
                                <td>'.$arrExtTrust['tfn'].'</td>
                            </tr>
                            <tr>
                                <td>Registered Address :</td>
                                <td>'.$arrExtTrust['reg_address'].'</td>
                            </tr>
                            <tr>
                                <td>Directors :</td>
                                <td>'.  replaceString('|', ',', $arrExtTrust['director']).'</td>
                            </tr>';
        }
        
        $existingTrustee = '<div class="test">Existing Trustee Details</div>
                        <br />
                        <table class="first" cellpadding="4" cellspacing="6">
                            <tr>
                                <td>Trustee Type :</td>
                                <td>'.$arrExtTrust['trustee_name'].'</td>
                            </tr>'.$extTrustee.'
                        </table>'.$trustIndividual.'<br/>';
        
        /* Existing trustee details ends */
       
        /* New trustee details starts */
        // individual 
        if($arrNewTrust['trustee_id'] == '1') {
            $arrIndvdlFund = $this->fetchIndividualFundDetails();
            $nwTrustee = '<tr>
                                <td>No of individuals :</td>
                                <td>'.$arrNewTrust['noofmember'].'</td>
                            </tr>';
            
            $memberCtr = 1;
            $newIndividual = "";
            foreach ($arrIndvdlFund as $individualInfo) {
                $newIndividual .= '<table class="first" cellpadding="4" cellspacing="6">
                                    <tr>
                                        <td colspan="2"><u>Individual '.$memberCtr.'</u></td>
                                    </tr>
                                    <tr>
                                        <td>Name :</td>
                                        <td>'.$individualInfo['name'].'</td>
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
        elseif($arrNewTrust['trustee_id'] == '2') {
            $nwTrustee = '<tr>
                                <td>Name of company :</td>
                                <td>'.$arrNewTrust['comp_name'].'</td>
                            </tr>
                            <tr>
                                <td>ACN Number :</td>
                                <td>'.$arrNewTrust['acn'].'</td>
                            </tr>
                            <tr>
                                <td>TFN Number :</td>
                                <td>'.$arrNewTrust['tfn'].'</td>
                            </tr>
                            <tr>
                                <td>Registered Address :</td>
                                <td>'.$arrNewTrust['reg_address'].'</td>
                            </tr>
                            <tr>
                                <td>Directors :</td>
                                <td>'.  replaceString('|', ',', $arrNewTrust['director']).'</td>
                            </tr>';
        }
        
        $newTrustee = '<div class="test">New Trustee Details</div>
                        <br />
                        <table class="first" cellpadding="4" cellspacing="6">
                            <tr>
                                <td>Trustee Type :</td>
                                <td>'.$arrNewTrust['trustee_name'].'</td>
                            </tr>'.$nwTrustee.'
                        </table>'.$newIndividual.'<br/>';
        
        /* New Trustee details ends */
        
        /* Member details starts */
        $memberInfo = '<div class="test">Member Details</div>
                    <br />
                    <table class="first" cellpadding="4" cellspacing="6">';
        
        foreach ($arrMembers AS $memberCtr => $members) {
            $memberInfo .= '<tr>
                            <td colspan="2"></td>
                        </tr> 
                        <tr>
                            <td colspan="2"><u>Member '.$memberCtr.'</u></td>
                        </tr>
                        <tr>
                            <td>Name :</td>
                            <td>'.$members['memberName'].'</td>
                        </tr>
                        <tr>
                            <td>Date of birth :</td>
                            <td>'.$members['dob'].'</td>
                        </tr>
                        <tr>
                            <td>City of birth :</td>
                            <td>'.$members['city_birth'].'</td>
                        </tr>
                        <tr>
                            <td>Country of birth :</td>
                            <td>'.$arrCountry[$members['cntry_birth']].'</td>
                        </tr>
                        <tr>
                            <td>Residential Address :</td>
                            <td>'.$members['res_add'].'</td>
                        </tr>
                        <tr>
                            <td>Tax File Number :</td>
                            <td>'.$members['tfn'].'</td>
                        </tr>';
        }
        $memberInfo .= '</table>';
        /* Member details ends */
        
        $html = $styleCSS.$fund.$existingTrustee.$newTrustee.$memberInfo;
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
