<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of new_smsf_class
 *
 * @author siddheshc
 */
class NEW_SMSF 
{
    //put your code here
    
    public function fetchCheckbox()
    {
        $selQry="SELECT apply_abntfn, authority_status FROM es_smsf WHERE job_id = ".$_SESSION["jobId"];
        $fetchResult = mysql_query($selQry);
        $arrSMSF = mysql_fetch_assoc($fetchResult);
        
        return $arrSMSF;
    }
    
    // this function is used to insert job details into Job table 
    function insertJob($details) 
    {
        $qryIns = "INSERT INTO job(job_genre, mas_Code, job_type_id, period, job_status_id, setup_subfrm_id, job_created_date)
                    VALUES ( 
                    'SETUP', 
                    '25', 
                    '21', 
                    'Year End 30/06/". date('Y') . "',  
                    1,   
                    1,    
                    '".date('Y-m-d')."'
                    )";

        mysql_query($qryIns);
        $jobId = mysql_insert_id();

        return $jobId;
    }
    
    public function updateCheckbox()
    {
        $cbVal = 0;
        if(!empty($_REQUEST['cbApply'])) $cbVal = 1;

        print $updQry = "UPDATE es_smsf SET apply_abntfn = ".$cbVal." WHERE job_id = ".$_SESSION["jobId"];
        mysql_query($updQry);
    }
    
    public function insertCheckbox($setup_subfrm,$jobId)
    {
        if($setup_subfrm == '1') {
            if(!empty($_REQUEST['cbApply'])) {
                    $strField = ",apply_abntfn";
                    $strValue = ",1";
            }
        }

        $Qry = "INSERT INTO es_smsf (job_id, authority_status, smsf_type {$strField}) 
                        VALUES ({$jobId}, '1','".$setup_subfrm."' {$strValue})";
        mysql_query($Qry);
    }
   
}

?>