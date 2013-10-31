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
    function newTrustAsset($assetDetail) 
    {
        $qryIns = "INSERT INTO hbt_trust_asset(job_id, asset_details)
                    VALUES ( 
                    '".$_SESSION['jobId']."', 
                    '".addslashes($assetDetail)."'
                    )";

        mysql_query($qryIns);
    }
    
    // fetch trust asset details
    public function fetchTrustAsset()
    {
       $selQry="SELECT asset_details
                FROM hbt_trust_asset 
                WHERE job_id=".$_SESSION['jobId'];
        $fetchResult = mysql_query($selQry);
        $arrHoldTrust = mysql_fetch_assoc($fetchResult);
            
        return $arrHoldTrust;
    }
    
    // update trust asset details
    function updateTrustAsset($assetDetail) 
    {
      $qryUpd = "UPDATE hbt_trust_asset
                    SET asset_details = '".addslashes($assetDetail)."'
                    WHERE job_id = ".$_SESSION['jobId'];
      mysql_query($qryUpd);
    }
}

?>