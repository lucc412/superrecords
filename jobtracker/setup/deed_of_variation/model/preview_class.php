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
                        dt_estblshmnt, dt_estblshmnt, dt_variation, variation_clause
                        FROM dov_fund, es_country, cli_state
                        WHERE job_id = ".$_SESSION['jobId']."
                        AND met_add_country = country_id 
                        AND met_add_state = cst_Code";
            $fetchSel = mysql_query($qrySel);
            $rowData = mysql_fetch_assoc($fetchSel);
            return $rowData;
    }
    
    // fetch existing trustee data
    public function fetchExtTrustData() {
            $qrySel = "SELECT tf.trustee_id, ht.trustee_name, tf.comp_name, tf.acn, tf.tfn, tf.reg_address, tf.director
                        FROM dov_holding_trust tf, holding_trustee ht
                        WHERE tf.job_id = ".$_SESSION['jobId']."
                        AND ht.trustee_id = tf.trustee_id";
            $fetchFund = mysql_query($qrySel);
            $rowData = mysql_fetch_assoc($fetchFund);
            return $rowData;
    }

    // fetch member data
    public function fetchMemberData() {
            $qrySel = "SELECT CONCAT_WS(' ', md.fname, md.mname, md.lname) memberName, md.dob, md.city_birth, md.cntry_birth, md.tfn, md.res_add
                        FROM dov_member_details md
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
                        <td>Date of Variation :</td>
                        <td>'.$arrFund['dt_variation'].'</td>
                    </tr>
                    <tr>
                        <td>Variation Clause :</td>
                        <td>'.$arrFund['variation_clause'].'</td>
                    </tr>
                </table><br/>';
        /* Fund details ends */
       
        /* Existing trustee details starts */
        // corporate
        if($arrExtTrust['trustee_id'] == '2') {
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
        
        $existingTrustee = '<div class="test">Trustee Details</div>
                        <br />
                        <table class="first" cellpadding="4" cellspacing="6">
                            <tr>
                                <td>Trustee Type :</td>
                                <td>'.$arrExtTrust['trustee_name'].'</td>
                            </tr>'.$extTrustee.'
                        </table><br/>';
        
        /* Existing trustee details ends */
       
        /* Member details starts */
        $memberInfo = '<div class="test">Member Details</div>
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
