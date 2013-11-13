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
class Other 
{
    // insert other details
    function insOtherDetails($spcObj, $insDetails) 
    {
       $qryIns = "INSERT INTO ins_other(job_id, spc_objective, insurance_details)
                    VALUES ( 
                    '".$_SESSION['jobId']."', 
                    '".addslashes($spcObj)."',
                    '".$insDetails."'
                    )";

        mysql_query($qryIns);
    }
    
    // fetch other details
    public function fetchOtherDetails()
    {
       $selQry="SELECT spc_objective, insurance_details
                FROM ins_other 
                WHERE job_id=".$_SESSION['jobId'];
        $fetchResult = mysql_query($selQry);
        $arrHoldTrust = mysql_fetch_assoc($fetchResult);
            
        return $arrHoldTrust;
    }
    
    // update other details
    function updOtherDetails($spcObj, $insDetails) 
    {
      $qryUpd = "UPDATE ins_other
                    SET spc_objective = '".addslashes($spcObj)."',
                        insurance_details = '".$insDetails."'
                    WHERE job_id = ".$_SESSION['jobId'];
      mysql_query($qryUpd);
    }
}

?>