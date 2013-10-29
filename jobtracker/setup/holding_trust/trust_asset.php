<?php
// include common file
include("../../include/common.php");

// include class file
include("model/trust_asset_class.php");
$objHoldingTrust = new Trust_Asset();

// fetch existing data [edit case]
if(!empty($_SESSION['jobId'])) {
    $arrHoldTrust = $objHoldingTrust->fetchTrustAsset();
}
        
// insert & update case
if(!empty($_REQUEST['saveData'])) {
    // update holding trust asset details
    if(!empty($arrHoldTrust)) {
            $assetDetail = $_REQUEST['taAsset'];
            $objHoldingTrust->updateTrustAsset($assetDetail);
    }
    // insert holding trust asset details
    else {
        $assetDetail = $_REQUEST['taAsset'];
        $objHoldingTrust->newTrustAsset($assetDetail);
    }
    
    if(isset($_REQUEST['next'])) {
        header('location: preview.php');
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