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
            $qryCom = "SELECT tf.comp_pref_name, tf.comp_juri_reg
                        FROM spc_comp_dtls tf
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
                        FROM spc_adddress_dtls tf, cli_state cs1, cli_state cs2, cli_state cs3
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
            $qryCom = "SELECT CONCAT_WS(' ', of.offcr_fname, of.offcr_mname, of.offcr_lname) officerName, DATE_FORMAT(of.offcr_dob, '%d/%m/%Y')offcr_dob, of.offcr_city_birth, of.offcr_state_birth, 
                        of.offcr_cntry_birth, of.offcr_tfn, CONCAT_WS(',', of.offcr_addr_unit, of.offcr_addr_build, of.offcr_addr_street, of.offcr_addr_subrb, of.offcr_addr_pst_code, cs.cst_Description)offcrAddres
                        FROM spc_offcr_dtls of LEFT JOIN cli_state cs ON of.offcr_addr_state = cs.cst_Code
                        WHERE of.job_id = ".$_SESSION['jobId'];
            $fetchRow = mysql_query($qryCom);
            $offcrCntr = 1;
            while($rowData = mysql_fetch_assoc($fetchRow)) {
                $arrOfficer[$offcrCntr++] = $rowData;
            }
            return $arrOfficer;
    }
    
    // fetch officer data
    public function fetchShareholderData() {
            $qrySel = "SELECT sh.shrhldr_type, IF(sh.shrhldr_type = 1, 'Corporate', 'Individual') shrhldrType, sh.shrhldr_cmpny_name, sh.shrhldr_acn, sh.shrhldr_reg_addr,
                        sh.no_of_directrs, sh.directrs_name, CONCAT_WS(' ', sh.shrhldr_fname, sh.shrhldr_mname, sh.shrhldr_lname) shrhldrName, 
                        CONCAT_WS(',', sh.res_addr_unit, sh.res_addr_build, sh.res_addr_street, sh.res_addr_subrb, sh.res_addr_pcode, cs.cst_Description) regAddress, 
                        sc.shr_desc, IF(sh.is_shars_own_bhlf, 'Yes', 'No')isShrhldr, sh.shars_own_bhlf, sh.no_of_shares
                        FROM stp_share_class sc, spc_sharehldr_dtls sh LEFT JOIN cli_state cs ON sh.res_addr_state = cs.cst_Code
                        WHERE sh.job_id = ".$_SESSION['jobId']."
                        AND sh.share_class = sc.shrclass_id";
            $fetchRow = mysql_query($qrySel);
            $shrhldrCntr = 1;
            while($rowData = mysql_fetch_assoc($fetchRow)) {
                $arrShareholder[$shrhldrCntr++] = $rowData;
            }
            return $arrShareholder;
    }
    
    // generate preview/pdf code
    public function generatePreview() {
       $arrStates = fetchStates();
       $arrCountry = fetchCountries();
       $arrCompanyDetail = $this->fetchCompanyData();
       $arrAddressDetail = $this->fetchAddressData();
       $arrOfficerDetail = $this->fetchOfficerData();
       $arrSharehldrDetail = $this->fetchShareholderData();
       
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
                    </table>';
        /* company details ends */
        
        /* address details starts */
        $address = '<div class="test">Address Details</div>
                    <br />
                    <table class="first" cellpadding="4" cellspacing="6">
                        <tr>
                            <td>Registered Address :</td>
                            <td>'.stringltrim($arrAddressDetail['regAddres'], ',').'</td>
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
                        <td>'.stringltrim($arrAddressDetail['bsnsAddres'], ',').'</td>
                    </tr>
                    <tr>
                        <td>Meeting Address :</td>
                        <td>'.stringltrim($arrAddressDetail['metAddres'], ',').'</td>
                    </tr>
                 </table>';
        /* address details ends */
        
        /* Officer details starts */
        $officer = '<div class="test">Officer Details</div>
                    <br />
                    <table class="first" cellpadding="4" cellspacing="6">';
        
        foreach ($arrOfficerDetail AS $officerCtr => $officerInfo) {
            $officer .= '<tr>
                            <td colspan="2"></td>
                        </tr> 
                        <tr>
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
                            <td>'.$officerInfo['offcr_state_birth'].'</td>
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
                            <td>'.stringltrim($officerInfo['offcrAddres'], ',').'</td>
                        </tr>';
        }
        $officer .= '</table>';
        /* Officer details ends */
        
        /* shareholder details starts */
        $shareHolder .= '<div class="test">Shareholder Details</div><br />
                    <table class="first" cellpadding="4" cellspacing="6">';
        
        foreach ($arrSharehldrDetail AS $shrCtr => $shrHlderInfo) {
            $shareHolder .= '<tr>
                                <td colspan="2"></td>
                            </tr>
                            <tr>
                                <td colspan="2"><u>Shareholder '.$shrCtr.'</u></td>
                            </tr>
                            <tr>
                                <td>Type :</td>
                                <td>'.$shrHlderInfo['shrhldrType'].'</td>
                            </tr>';
            if($shrHlderInfo['shrhldr_type'] == '1') {
                $shareHolder .= '<tr>
                                    <td>Company Name :</td>
                                    <td>'.$shrHlderInfo['shrhldr_cmpny_name'].'</td>
                                </tr>
                                <tr>
                                    <td>ACN :</td>
                                    <td>'.$shrHlderInfo['shrhldr_acn'].'</td>
                                </tr>
                                <tr>
                                    <td>Registered Address :</td>
                                    <td>'.$shrHlderInfo['shrhldr_reg_addr'].'</td>
                                </tr>
                                <tr>
                                    <td>Number of Director :</td>
                                    <td>'.$shrHlderInfo['no_of_directrs'].'</td>
                                </tr>';
                
                if(!empty($shrHlderInfo['no_of_directrs'])) {
                     $shareHolder .= '<tr>
                                        <td>Directors :</td>
                                        <td>'.$shrHlderInfo['directrs_name'].'</td>
                                    </tr>';
                }
            }
            else if($shrHlderInfo['shrhldr_type'] == '2') {
                $shareHolder .= '<tr>
                                    <td>Shareholder Name :</td>
                                    <td>'.$shrHlderInfo['shrhldrName'].'</td>
                                </tr>
                                <tr>
                                    <td>Residential Address :</td>
                                    <td>'.stringltrim($shrHlderInfo['regAddress'], ',').'</td>
                                </tr>';
            }
            
            $shareHolder .= '<tr>
                                <td>Share Class :</td>
                                <td>'.$shrHlderInfo['shr_desc'].'</td>
                            </tr>
                            <tr>
                                <td>Are the shares owned on behalf <br/> of another Company or Trust? :</td>
                                <td>'.$shrHlderInfo['isShrhldr'].'</td>
                            </tr>';
            
            if($shrHlderInfo['isShrhldr'] == 'Yes') {
                $shareHolder .= '<tr>
                                    <td>Shares are owned on behalf :</td>
                                    <td>'.$shrHlderInfo['shars_own_bhlf'].'</td>
                                </tr>';
            }
            $shareHolder .= '<tr>
                                <td>Number of shares :</td>
                                <td>'.$shrHlderInfo['no_of_shares'].'</td>
                            </tr>';
        }
        
         $shareHolder .= '</table>';
        /* shareholder details ends */
        
        $html = $styleCSS.$company.$address.$officer.$shareHolder;
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
