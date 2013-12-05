<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of change_fund_class
 *
 * @author siddheshc
 */
class PENSION {
    //put your code here
    
    // insert Pension Details
    function newPensionDetails($pensionDtls) 
    {
        $qryIns = "INSERT INTO abp_pension_dtls(job_id, member_name, dob, commence_date, condition_release, pension_acc_bal, currnt_yr_pay, tax_free_percnt, rev_pensn_name, rev_terms_condn)
                    VALUES (
                    '".$_SESSION['jobId']."',
                    '".$pensionDtls['txtMembrName']."',
                    '".$pensionDtls['txtDob']."',
                    '".$pensionDtls['txtComncDt']."',
                    '".$pensionDtls['selCondRel']."',
                    '".$pensionDtls['txtPenAccBal']."',
                    '".$pensionDtls['txtCurYrPay']."',
                    '".$pensionDtls['txtTxFrePrcnt']."',
                    '".$pensionDtls['txtRevPenName']."',
                    '".$pensionDtls['txtRevTnC']."'
                    )";
        
        mysql_query($qryIns);
    }
    
    // update Pension Details
    function updatePensionDetails($pensionDtls) 
    {
        $qryUpd = "UPDATE abp_pension_dtls
                    SET member_name = '".$pensionDtls['txtMembrName']."',
                        dob = '".$pensionDtls['txtDob']."',
                        commence_date = '".$pensionDtls['txtComncDt']."',
                        condition_release = '".$pensionDtls['selCondRel']."',
                        pension_acc_bal = '".$pensionDtls['txtPenAccBal']."',
                        currnt_yr_pay = '".$pensionDtls['txtCurYrPay']."',
                        tax_free_percnt = '".$pensionDtls['txtTxFrePrcnt']."',
                        rev_pensn_name = '".$pensionDtls['txtRevPenName']."',
                        rev_terms_condn = '".$pensionDtls['txtRevTnC']."'
                    WHERE job_id = ".$_SESSION['jobId'];
        
        mysql_query($qryUpd);
    }
    
    // fetch Pension details
    public function fetchPensionDetails()
    {
        $selQry="SELECT pension_id, job_id, member_name, DATE_FORMAT(dob, '%d/%m/%Y') dob, DATE_FORMAT(commence_date, '%d/%m/%Y') commence_date, condition_release, pension_acc_bal, currnt_yr_pay, tax_free_percnt, rev_pensn_name, rev_terms_condn
                        FROM abp_pension_dtls
                        WHERE job_id=".$_SESSION['jobId'];
        
        $fetchResult = mysql_query($selQry);
        $arrPensionDtls = mysql_fetch_assoc($fetchResult);
            
        return $arrPensionDtls;
    }
    
}

?>
