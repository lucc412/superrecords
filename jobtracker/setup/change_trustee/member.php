<?php
// include common file
include("../../include/common.php");

// include class file
include("model/trust_asset_class.php");
$objHoldingTrust = new Trust_Asset();

$arrRateType = array('F'=>'Fixed Rate', 'V'=>'Variable Rate');
$arrLoanType = array('I'=>'Interest Only', 'P'=>'Principal and Interest');

// fetch existing data [edit case]
if(!empty($_SESSION['jobId'])) {
    $arrHoldTrust = $objHoldingTrust->fetchTrustAsset();
}
        
// insert & update case
if(!empty($_REQUEST['saveData'])) {
    $asset = $_REQUEST['taAsset'];
    $loan = $_REQUEST['txtLoan'];
    $loanYear = $_REQUEST['txtYear'];
    $loanRate = $_REQUEST['txtRate'];
    $rateType = $_REQUEST['lstRateType'];
    $loanType = $_REQUEST['lstLoanType'];
    
    // update holding trust asset details
    if(!empty($arrHoldTrust)) $objHoldingTrust->updateTrustAsset($asset, $loan, $loanYear, $loanRate, $rateType, $loanType);
    
    // insert holding trust asset details
    else $objHoldingTrust->newTrustAsset($asset, $loan, $loanYear, $loanRate, $rateType, $loanType);
    
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
include("view/member.php");

?>