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
    
    // fetch company data
    public function fetchCompanyData() {
            $qryCom = "SELECT tf.comp_pref_name, tf.comp_juri_reg, IF(tf.exst_busns_name, 'Yes', 'No')exst_busns_name, 
                        IF(tf.reg_busns_name, 'Yes', 'No')reg_busns_name, tf.reg_busns_abn, tf.reg_busns_state, tf.reg_busns_number
                        FROM stp_comp_dtls tf
                        WHERE tf.job_id = ".$_SESSION['jobId'];
            $fetchRow = mysql_query($qryCom);
            $rowData = mysql_fetch_assoc($fetchRow);
            return $rowData;
    }
    
    // fetch address data
    public function fetchAddressData() {
            $qryCom = "SELECT CONCAT_WS(',', tf.reg_add_unit, tf.reg_add_build, tf.reg_add_street, tf.reg_add_subrb, tf.reg_add_pst_code, cs1.cst_Description)regAddres,
                        CONCAT_WS(',', tf.bsns_add_unit, tf.bsns_add_build, tf.bsns_add_street, tf.bsns_add_subrb, tf.bsns_add_pst_code, cs2.cst_Description)bsnsAddres,
                        CONCAT_WS(',', tf.met_add_unit, tf.met_add_build, tf.met_add_street, tf.met_add_subrb, tf.met_add_pst_code, cs3.cst_Description)metAddres,
                        IF(tf.is_comp_addr, 'Yes', 'No')is_comp_addr, tf.occp_name
                        FROM stp_adddress_dtls tf, cli_state cs1, cli_state cs2, cli_state cs3
                        WHERE tf.job_id = ".$_SESSION['jobId']."
                        AND tf.reg_add_state = cs1.cst_Code 
                        AND tf.bsns_add_state = cs2.cst_Code
                        AND tf.met_add_state = cs3.cst_Code";
            $fetchRow = mysql_query($qryCom);
            $rowData = mysql_fetch_assoc($fetchRow);
            return $rowData;
    }
    
    // fetch officer data
    public function fetchOfficerData() {
            $qryCom = "SELECT CONCAT_WS(' ', of.offcr_fname, of.offcr_mname, of.offcr_lname) officerName, of.offcr_dob, of.offcr_city_birth, of.offcr_state_birth, 
                        of.offcr_cntry_birth, of.offcr_tfn, CONCAT_WS(',', of.offcr_addr_unit, of.offcr_addr_build, of.offcr_addr_street, of.offcr_addr_subrb, of.offcr_addr_pst_code, cs.cst_Description)offcrAddres
                        FROM stp_offcr_dtls of LEFT JOIN cli_state cs ON of.offcr_addr_state = cs.cst_Code
                        WHERE of.job_id = ".$_SESSION['jobId'];
            $fetchRow = mysql_query($qryCom);
            $OffcrCntr = 1;
            while($rowData = mysql_fetch_assoc($fetchRow)) {
                $arrOfficer[$OffcrCntr++] = $rowData;
            }
            return $arrOfficer;
    }
    
    
    // generate preview/pdf code
    public function generatePreview() {
       $arrStates = fetchStates();
       $arrCountry = fetchCountries();
       $arrCompanyDetail = $this->fetchCompanyData();
       $arrAddressDetail = $this->fetchAddressData();
       $arrOfficerDetail = $this->fetchOfficerData();
       
       showArray($arrOfficerDetail);
       
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
       
        /* company details starts */
        $company = '<div class="test">Company Details</div>
                    <br />
                    <table class="first" cellpadding="4" cellspacing="6">
                        <tr>
                            <td>Proposed name of company :</td>
                            <td>'.$arrCompanyDetail['comp_pref_name'].'</td>
                        </tr>
                        <tr>
                            <td>Jurisdiction of registration :</td>
                            <td>'.$arrStates[$arrCompanyDetail['comp_juri_reg']].'</td>
                        </tr>
                        <tr>
                            <td>Is the proposed company name an <br/>existing business name ? :</td>
                            <td>'.$arrCompanyDetail['exst_busns_name'].'</td>
                        </tr>';
        
        if($arrCompanyDetail['exst_busns_name'] == 'Yes') {
           $company .=  '<tr>
                            <td>Was the business name registered <br/>on or after 28 May 2012 ? :</td>
                            <td>'.$arrCompanyDetail['reg_busns_name'].'</td>
                        </tr>';
           if($arrCompanyDetail['reg_busns_name'] == 'No') {
                $company .= '<tr>
                                <td>State :</td>
                                <td>'.$arrStates[$arrCompanyDetail['reg_busns_state']].'</td>
                            </tr>
                            <tr>
                                <td>Registration Number :</td>
                                <td>'.$arrCompanyDetail['reg_busns_number'].'</td>
                            </tr>';
           }
           if($arrCompanyDetail['reg_busns_name'] == 'Yes') {   
              $company .= '<tr>
                            <td>ABN :</td>
                            <td>'.$arrCompanyDetail['reg_busns_abn'].'</td>
                        </tr>';
           }
        }
        $company .= '</table>';
        /* company details ends */
        
        /* address details starts */
        $address = '<div class="test">Address Details</div>
                    <br />
                    <table class="first" cellpadding="4" cellspacing="6">
                        <tr>
                            <td>Registered Address :</td>
                            <td>'.$arrAddressDetail['regAddres'].'</td>
                        </tr>
                        <tr>
                            <td>Will this company occupy <br/>registered address? :</td>
                            <td>'.$arrAddressDetail['is_comp_addr'].'</td>
                        </tr>';
        if($arrAddressDetail['is_comp_addr'] == 'No') {
            $address .= '<tr>
                        <td>Occupier`s name :</td>
                        <td>'.$arrAddressDetail['occp_name'].'</td>
                    </tr>';
        }
        
        $address .= '<tr>
                        <td>Principal Business Address :</td>
                        <td>'.$arrAddressDetail['bsnsAddres'].'</td>
                    </tr>
                    <tr>
                        <td>Meeting Address :</td>
                        <td>'.$arrAddressDetail['metAddres'].'</td>
                    </tr>
                 </table>';
        /* address details ends */
        
        /* Officer details starts */
        $officer = '<div class="test">Officer Details</div>
                    <br />
                    <table class="first" cellpadding="4" cellspacing="6">';
        
        foreach ($arrOfficerDetail AS $officerCtr => $officerInfo) {
            $officer .= '<tr>
                            <td colspan="2"><u>Officer '.$officerCtr.'</u></td>
                        </tr>
                        <tr>
                            <td>Name :</td>
                            <td>'.$officerInfo['officerName'].'</td>
                        </tr>
                        <tr>
                            <td>Date of birth :</td>
                            <td>'.$officerInfo['offcr_dob'].'</td>
                        </tr>
                        <tr>
                            <td>City of birth :</td>
                            <td>'.$officerInfo['offcr_city_birth'].'</td>
                        </tr>
                        <tr>
                            <td>State of birth :</td>
                            <td>'.$arrStates[$officerInfo['offcr_state_birth']].'</td>
                        </tr>
                        <tr>
                            <td>Country of birth :</td>
                            <td>'.$arrCountry[$officerInfo['offcr_cntry_birth']].'</td>
                        </tr>
                        <tr>
                            <td>Tax File Number :</td>
                            <td>'.$officerInfo['offcr_tfn'].'</td>
                        </tr>
                        <tr>
                            <td>Residential Address :</td>
                            <td>'.$officerInfo['offcrAddres'].'</td>
                        </tr>';
        }
        $officer .= '</table>';
        /* Officer details ends */
        
        $html = $styleCSS.$company.$address.$officer;
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
