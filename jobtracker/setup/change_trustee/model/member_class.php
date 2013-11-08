<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of new_smsf_class
 *
 * @author disha
 */
class Trust_Asset 
{
    // insert holding trust asset details
    function newTrustAsset($asset, $loan, $loanYear, $loanRate, $rateType, $loanType) 
    {
        $qryIns = "INSERT INTO lrl_trust_asset(job_id, asset_details, loan_amount, loan_years, interest, interest_type, loan_type)
                    VALUES ( 
                    '".$_SESSION['jobId']."', 
                    '".addslashes($asset)."',
                    '".addslashes($loan)."',
                    '".addslashes($loanYear)."',
                    '".addslashes($loanRate)."',
                    '".$rateType."',
                    '".$loanType."'
                    )";

        mysql_query($qryIns);
    }
    
    // fetch trust asset details
    public function fetchTrustAsset()
    {
       $selQry="SELECT asset_details, loan_amount, loan_years, interest, interest_type, loan_type
                FROM lrl_trust_asset 
                WHERE job_id=".$_SESSION['jobId'];
        $fetchResult = mysql_query($selQry);
        $arrHoldTrust = mysql_fetch_assoc($fetchResult);
            
        return $arrHoldTrust;
    }
    
    // update trust asset details
    function updateTrustAsset($asset, $loan, $loanYear, $loanRate, $rateType, $loanType) 
    {
      $qryUpd = "UPDATE lrl_trust_asset
                    SET asset_details = '".addslashes($asset)."',
                        loan_amount = '".addslashes($loan)."',
                        loan_years = '".addslashes($loanYear)."',
                        interest = '".addslashes($loanRate)."',
                        interest_type = '".$rateType."',
                        loan_type = '".$loanType."'
                    WHERE job_id = ".$_SESSION['jobId'];
      mysql_query($qryUpd);
    }
}

?>