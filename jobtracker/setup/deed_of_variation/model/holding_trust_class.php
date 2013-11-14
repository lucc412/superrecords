<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of hlding_trust_class
 *
 * @author disha
 */
class Holding_Trust 
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
    
    // insert holding trust details
    function newHoldingTrust($trusteeId, $compName, $acn, $tfn, $address, $directors) 
    {
      $qryIns = "INSERT INTO dov_holding_trust(job_id, trustee_id, comp_name, acn, tfn, reg_address, director)
                    VALUES ( 
                    '".$_SESSION['jobId']."', 
                    ".$trusteeId.", 
                    '".addslashes($compName)."', 
                    '".addslashes($acn)."', 
                    '".addslashes($tfn)."', 
                    '".addslashes($address)."', 
                    '".addslashes($directors)."'
                    )";
        mysql_query($qryIns);
    }
    
    // update holding trust details & corporate trust details
    function updateHoldingTrust($trusteeId, $compName, $acn, $tfn, $address, $directors) 
    {
      $qryUpd = "UPDATE dov_holding_trust
                    SET trustee_id = '".$trusteeId."',
                        comp_name = '".addslashes($compName)."',
                        acn = '".addslashes($acn)."',
                        tfn = '".addslashes($tfn)."',
                        reg_address = '".addslashes($address)."',
                        director = '".addslashes($directors)."'
                    WHERE job_id = ".$_SESSION['jobId'];
        mysql_query($qryUpd);
    }
    
    // fetch holding trust details
    public function fetchHoldingTrustDetails()
    {
       $selQry="SELECT trustee_id, comp_name, acn, tfn, reg_address, director
                FROM dov_holding_trust 
                WHERE job_id=".$_SESSION['jobId'];
        $fetchResult = mysql_query($selQry);
        $arrHoldTrust = mysql_fetch_assoc($fetchResult);
            
        return $arrHoldTrust;
    }
}

?>