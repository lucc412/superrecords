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
                        DATE_FORMAT(dt_estblshmnt, '%d/%m/%Y')dt_estblshmnt, action_type, appointment_clause, resignation_clause
                        FROM cot_fund, es_country, cli_state
                        WHERE job_id = ".$_SESSION['jobId']."
                        AND met_add_country = country_id 
                        AND met_add_state = cst_Code";
            $fetchSel = mysql_query($qrySel);
            $rowData = mysql_fetch_assoc($fetchSel);
            return $rowData;
    }
    
    
    // fetch fund details
    public function fetchFundDetails()
    {
       
       $selQry="SELECT job_id, ext_fund_name, new_fund_name, CONCAT_WS(',', metAddUnit, metAddBuild, metAddStreet, metAddSubrb, metAddState, metAddPstCode, metAddCntry) met_address 
                        FROM cfn_fund_dtls, es_country, cli_state
                        WHERE job_id=".$_SESSION['jobId']."
                        AND metAddCntry = country_id 
                        AND metAddState = cst_Code";
       
        $fetchResult = mysql_query($selQry);
        $arrFundDtls = mysql_fetch_assoc($fetchResult);
            
        return $arrFundDtls;
    }
    
    public function fetchTrustee()
    {
        $selQry="SELECT trusty_id, job_id, trusty_type, no_of_members FROM cfn_trusty_dtls 
                        WHERE job_id = ".$_SESSION['jobId'];
        
        $fetchResult = mysql_query($selQry);
        $arrTrustee = mysql_fetch_assoc($fetchResult);
        
        return $arrTrustee;
    }
    
    // fetch holding trust details
    public function fetchCorpTrustDetails()
    {
       $selQry="SELECT corp_id, job_id, comp_name, acn, reg_add, directors
                FROM cfn_corp_trusty_dtls 
                WHERE job_id=".$_SESSION['jobId'];
        $fetchResult = mysql_query($selQry);
        $arrCorpTrust = mysql_fetch_assoc($fetchResult);
            
        return $arrCorpTrust;
    }
    
    // fetch individual trust details
    public function fetchIndividualTrustDetails()
    {
       $selQry="SELECT indvdl_id, job_id, fname, mname, lname, res_add
                FROM cfn_indvdl_trusty_dtls 
                WHERE job_id = ".$_SESSION['jobId'];
        $fetchResult = mysql_query($selQry);
        while($rowData = mysql_fetch_assoc($fetchResult)) {
            $arrIndvdlTrust[] = $rowData;
        }
        
        return $arrIndvdlTrust;
    }
    
    
    // generate preview/pdf code
    public function generatePreview() {
       $arrFund = $this->fetchFundDetails();  
       
       $arrCorpTrusty = $this->fetchCorpTrustDetails();
       $arrIndvdlTrusty = $this->fetchIndividualTrustDetails();
       $arrTrusty = $this->fetchTrustee();
       
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
                        <td>Existing name of the fund :</td>
                        <td>'.$arrFund['ext_fund_name'].'</td>
                    </tr>
                    <tr>
                        <td>New name of the fund :</td>
                        <td>'.$arrFund['new_fund_name'].'</td>
                    </tr>
                    <tr>
                        <td>Meeting Address :</td>
                        <td>'.stringltrim($arrFund['met_address'], ',').'</td>
                    </tr>
                    <tr>
                        <td>No of Individuals :</td>
                        <td>'.$arrTrusty['no_of_members'].'</td>
                    </tr>
                </table><br/>';
        /* Fund details ends */
       
        $newTrustee = '<div class="test">Trustee Details</div>';
        
        if($arrTrusty['trusty_type'] == '1') {
            
            $memberCtr = 1;
            $trustIndividual = "";
            
            foreach ($arrIndvdlTrusty as $individualInfo) {
                $trustIndividual .= '<table class="first" cellpadding="4" cellspacing="6">
                                    <tr>
                                        <td colspan="2"><u>Individual '.$memberCtr.'</u></td>
                                    </tr>
                                    <tr>
                                        <td>First Name :</td>
                                        <td>'.$individualInfo['fname'].'</td>
                                    </tr>
                                    <tr>
                                        <td>Middle Name :</td>
                                        <td>'.$individualInfo['mname'].'</td>
                                    </tr>
                                    <tr>
                                        <td>Last Name :</td>
                                        <td>'.$individualInfo['lname'].'</td>
                                    </tr>
                                    <tr>
                                        <td>Residential Address :</td>
                                        <td>'.$individualInfo['res_add'].'</td>
                                    </tr>
                                    </table>';
                $memberCtr++;
            }
            $indvdlTrustee = $trustIndividual;
        }
        // corporate
        elseif($arrTrusty['trusty_type'] == '2') {
            $corpTrusty = '<table class="first" cellpadding="4" cellspacing="6">
                            <tr>
                                <td>Name of company :</td>
                                <td>'.$arrCorpTrusty['comp_name'].'</td>
                            </tr>
                            <tr>
                                <td>ACN Number :</td>
                                <td>'.$arrCorpTrusty['acn'].'</td>
                            </tr>
                            <tr>
                                <td>Registered Address :</td>
                                <td>'.$arrCorpTrusty['reg_add'].'</td>
                            </tr>
                            <tr>
                                <td>Directors :</td>
                                <td>'.  replaceString('|', ',', $arrCorpTrusty['directors']).'</td>
                            </tr>
                            </table>';
        }
       
        $html = $styleCSS.$fund.$newTrustee.$indvdlTrustee.$corpTrusty;
        
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
