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
    function newTrustAsset($assetData, $financialYr) 
    {
       $qryIns = "INSERT INTO ins_asset(job_id, asset, financial_year, type, amount, asset_range, target)
                    VALUES ( 
                    '".$_SESSION['jobId']."', 
                    '".addslashes($assetData['asset'])."',
                    '".addslashes($financialYr)."',
                    '".addslashes($assetData['type'])."',
                    '".addslashes($assetData['amount'])."',
                    '".addslashes($assetData['range'])."',
                    '".addslashes($assetData['target'])."'
                    )";

        mysql_query($qryIns);
    }
    
    // fetch asset details
    public function fetchTrustAsset()
    {
       $selQry="SELECT asset_id, asset, financial_year, type, amount, asset_range, target
                FROM ins_asset 
                WHERE job_id=".$_SESSION['jobId'];
        $fetchResult = mysql_query($selQry);
        while($rowInfo = mysql_fetch_assoc($fetchResult)) {
            $arrHoldTrust[$rowInfo['asset_id']] = $rowInfo;
        }
            
        return $arrHoldTrust;
    }
    
    // fetch asset financial year
    public function fetchTrustAssetYear()
    {
       $selQry="SELECT financial_year
                FROM ins_asset 
                WHERE job_id=".$_SESSION['jobId'];
        $fetchResult = mysql_query($selQry);
        $rowInfo = mysql_fetch_assoc($fetchResult);
        $financialYear = $rowInfo['financial_year'];
            
        return $financialYear;
    }
    
    // update trust asset details
    function updateTrustAsset($assetData, $financialYr) 
    {
      $qryUpd = "UPDATE ins_asset
                    SET asset = '".addslashes($assetData['asset'])."',
                        financial_year = '".addslashes($financialYr)."',
                        type = '".addslashes($assetData['type'])."',
                        amount = '".addslashes($assetData['amount'])."',
                        asset_range = '".addslashes($assetData['range'])."',
                        target = '".addslashes($assetData['target'])."'
                    WHERE asset_id = ".$assetData['assetId'];
      mysql_query($qryUpd);
    }
}

?>