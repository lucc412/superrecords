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
class Trust 
{
    // fetch trustee type
    public function fetchTrusteeType()
    {
        $selQry="SELECT trustee_id, trustee_name FROM holding_trustee";
        $fetchResult = mysql_query($selQry);
        while($rowResult = mysql_fetch_assoc($fetchResult)) {
            $arrTrusteeType[$rowResult['trustee_id']] = $rowResult['trustee_name'];
        }
        
        return $arrTrusteeType;
    }
    
    // this function is used to insert job details into Job table 
    function insertNewJob() 
    {
        $qryIns = "INSERT INTO job(job_genre, mas_Code, job_type_id, period, job_status_id, setup_subfrm_id, job_created_date)
                    VALUES ( 
                    'SETUP', 
                    '25', 
                    '21', 
                    'Year End 30/06/". date('Y') . "',  
                    1,   
                    ".$_REQUEST['frmId'].",    
                    '".date('Y-m-d')."'
                    )";

        mysql_query($qryIns);
        $jobId = mysql_insert_id();

        return $jobId;
    }
    
    // insert holding trust details
    function newHoldingTrust($trust) 
    {
      $qryIns = "INSERT INTO lrl_trust(job_id, trust_name)
                    VALUES ( 
                    '".$_SESSION['jobId']."', 
                    '".addslashes($trust)."'
                    )";
        mysql_query($qryIns);
    }
    
    // update holding trust details
    function updateHoldingTrust($trust) 
    {
      $qryUpd = "UPDATE lrl_trust
                    SET trust_name = '".addslashes($trust)."'
                    WHERE job_id = ".$_SESSION['jobId'];
        mysql_query($qryUpd);
    }
    
    // fetch holding trust details
    public function fetchHoldingTrustDetails()
    {
       $selQry="SELECT trust_name
                FROM lrl_trust 
                WHERE job_id=".$_SESSION['jobId'];
        $fetchResult = mysql_query($selQry);
        $arrHoldTrust = mysql_fetch_assoc($fetchResult);
            
        return $arrHoldTrust;
    }
}

?>