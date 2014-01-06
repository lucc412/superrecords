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
        
    // fetch fund details
    public function fetchFundDetails()
    {
       $selQry="SELECT job_id, fund_name, CONCAT_WS(',', mt_add_unit, mt_add_build, mt_add_subrb, mt_add_street, cst_Description, mt_add_pst_code, country_name) mt_address 
                        FROM trp_fund_dtls, es_country, cli_state
                        WHERE job_id=".$_SESSION['jobId']."
                        AND mt_add_cntry = country_id 
                        AND mt_add_state = cst_Code";
       
        $fetchResult = mysql_query($selQry);
        $arrFundDtls = mysql_fetch_assoc($fetchResult);
            
        return $arrFundDtls;
    }
    
    // fetch Pension details
    public function fetchPensionDetails()
    {
        $selQry="SELECT pension_id, job_id, member_name, DATE_FORMAT(dob, '%d/%m/%Y') dob, DATE_FORMAT(commence_date, '%d/%m/%Y') commence_date, condition_release, pension_acc_bal, currnt_yr_pay, tax_free_percnt, rev_pensn_name, rev_terms_condn
                        FROM trp_pension_dtls
                        WHERE job_id=".$_SESSION['jobId'];
        
        $fetchResult = mysql_query($selQry);
        $arrPensionDtls = mysql_fetch_assoc($fetchResult);
            
        return $arrPensionDtls;
    }
    
    public function fetchTrustee()
    {
        $selQry="SELECT trusty_id, job_id, trusty_type, no_of_members FROM trp_trusty_dtls 
                        WHERE job_id = ".$_SESSION['jobId'];
        
        $fetchResult = mysql_query($selQry);
        $arrTrustee = mysql_fetch_assoc($fetchResult);
        
        return $arrTrustee;
    }
    
    // fetch holding trust details
    public function fetchCorpTrustDetails()
    {
       $selQry="SELECT corp_id, job_id, comp_name, acn, reg_add, directors
                FROM trp_corp_trusty_dtls 
                WHERE job_id=".$_SESSION['jobId'];
        $fetchResult = mysql_query($selQry);
        $arrCorpTrust = mysql_fetch_assoc($fetchResult);
            
        return $arrCorpTrust;
    }
    
    // fetch individual trust details
    public function fetchIndividualTrustDetails()
    {
       $selQry="SELECT indvdl_id, job_id, fname, mname, lname, res_add
                FROM trp_indvdl_trusty_dtls 
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
       $arrPension = $this->fetchPensionDetails();
       
       
       
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
                        <td>Name of the fund :</td>
                        <td>'.$arrFund['fund_name'].'</td>
                    </tr>
                    <tr>
                        <td>Meeting Address :</td>
                        <td>'.stringltrim($arrFund['mt_address'], ',').'</td>
                    </tr>
                </table><br/>';
        /* Fund details ends */
        
       $no_of_individuals = "</table>";
       $trusteeType = '';
       if($arrTrusty['trusty_type'] == '1') 
           $trusteeType = 'Individual';    
       else
           $trusteeType = 'Corporate';    
       
       
        $newTrustee = '<div class="test">Trustee Details</div>
                       <table class="first" cellpadding="4" cellspacing="6">
                       <tr>
                            <td>Trustee Type :</td>
                            <td>'.$trusteeType.'</td>
                       </tr>';
                
        if($arrTrusty['trusty_type'] == '1') {
            
            $no_of_individuals = '<tr>
                        <td>No of Trustees :</td>
                        <td>'.$arrTrusty['no_of_members'].'</td>
                    </tr>
                    </table>';
            
            $memberCtr = 1;
            $trustIndividual = "";
            
            foreach ($arrIndvdlTrusty as $individualInfo) {
                $trustIndividual .= '<table class="first" cellpadding="4" cellspacing="6">
                                    <tr>
                                        <td colspan="2"><u>Trustee '.$memberCtr.'</u></td>
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
            $indvdlTrustee = $no_of_individuals.$trustIndividual;
        }
        // corporate
        elseif($arrTrusty['trusty_type'] == '2') {
            $corpTrusty = $no_of_individuals.'<table class="first" cellpadding="4" cellspacing="6">
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
                                <td>'.replaceString('|', ',', $arrCorpTrusty['directors']).'</td>
                            </tr>
                            </table>';
        }

        //$arrPension
        $arrCondRel = array(1=>'Retirement',2=>'Reaching Age 65',3=>'Roll-over');
        $condition = "";
        foreach ($arrCondRel as $cond_id => $condValue) { 
            if($arrPension['condition_release'] == $cond_id) $condition = $condValue; 
        }
        
        $Pension = '<div class="test">Pension Details</div>
                <br />
                <table class="first" cellpadding="4" cellspacing="6">
                    <tr>
                        <td>Name of Member Commencing the Pension : </td>
                        <td>'.$arrPension['member_name'].'</td>
                    </tr>
                    <tr>
                        <td>Date of Birth : </td>
                        <td>'.$arrPension['dob'].'</td>
                    </tr>
                    <tr>
                        <td>Commencement Date : </td>
                        <td>'.$arrPension['commence_date'].'</td>
                    </tr>
                    <tr>
                        <td>Pension Account Balance : </td>
                        <td>$'.$arrPension['pension_acc_bal'].'</td>
                    </tr>
                    <tr>
                        <td>Current Year Payment : </td>
                        <td>$'.$arrPension['currnt_yr_pay'].'</td>
                    </tr>
                    <tr>
                        <td>Tax Free Percentage : </td>
                        <td>'.$arrPension['tax_free_percnt'].'</td>
                    </tr>
                    <tr>
                        <td>Reversionary Pension Name (if applicable) : </td>
                        <td>'.$arrPension['rev_pensn_name'].'</td>
                    </tr>
                    <tr>
                        <td>Reversionary Terms and Conditions : </td>
                        <td>'.$arrPension['rev_terms_condn'].'</td>
                    </tr>
                </table><br/>';
        
        $html = $styleCSS.$fund.$newTrustee.$indvdlTrustee.$corpTrusty.$Pension;
        
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
