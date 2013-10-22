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