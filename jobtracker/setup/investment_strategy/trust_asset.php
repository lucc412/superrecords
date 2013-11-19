<?php
// include common file
include("../../include/common.php");

// include class file
include("model/trust_asset_class.php");
$objAsset = new Trust_Asset();

// fetch existing data [edit case]
if(!empty($_SESSION['jobId'])) {
    $arrHoldTrust = $objAsset->fetchTrustAsset();
    $financialYear = $objAsset->fetchTrustAssetYear();
}

$assetCnt = 1;
if(!empty($arrHoldTrust)) $assetCnt = count($arrHoldTrust);
        
// insert & update case
if(!empty($_REQUEST['saveData'])) {
    $financialYr = $_REQUEST['txtYear'];
    foreach ($_REQUEST as $eleName => $eleValue) {
        if(strstr($eleName, "assetId")) $arrAssets[str_replace('assetId', '', $eleName)]['assetId'] = $eleValue;
        if(strstr($eleName, "taAsset")) $arrAssets[str_replace('taAsset', '', $eleName)]['asset'] = $eleValue;
        if(strstr($eleName, "txtType")) $arrAssets[str_replace('txtType', '', $eleName)]['type'] = $eleValue;
        if(strstr($eleName, "txtAmt")) $arrAssets[str_replace('txtAmt', '', $eleName)]['amount'] = $eleValue;
        if(strstr($eleName, "txtRange")) $arrAssets[str_replace('txtRange', '', $eleName)]['range'] = $eleValue;
        if(strstr($eleName, "txtTarget")) $arrAssets[str_replace('txtTarget', '', $eleName)]['target'] = $eleValue;
    }
    
    foreach ($arrAssets AS $assetData) {
        // update asset details
        if(!empty($assetData['assetId'])) {
                $objAsset->updateTrustAsset($assetData, $financialYr);
        }
        // insert asset details
        else {
            $objAsset->newTrustAsset($assetData, $financialYr);
        }
    }
    
    if(isset($_REQUEST['next'])) {
        header('location: other.php');
        exit;
    }
    else if(isset($_REQUEST['save'])) {
        header('location: ../../jobs_saved.php');
        exit;
    }
}

// include view file
include("view/trust_asset.php");

?>