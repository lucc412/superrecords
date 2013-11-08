<?php
// include common file
include("../../include/common.php");

// include class file
include("model/fund_class.php");
$objHoldingTrust = new Trust();

// set recid in session for Retrieve saved jobs
if(!empty($_REQUEST['recid'])) {
    if(isset($_SESSION['jobId'])) unset($_SESSION['jobId']);
    $_SESSION['jobId'] = $_REQUEST['recid'];
}

// fetch existing data [edit case]
if(!empty($_SESSION['jobId'])) {
    $arrHoldTrust = $objHoldingTrust->fetchHoldingTrustDetails();
}

// insert & update case
if(!empty($_REQUEST['saveData'])) {
    $trust = $_REQUEST['txtTrust'];
    
    if(empty($arrHoldTrust)) {
        $_SESSION['jobId'] = $objHoldingTrust->insertNewJob();
        $objHoldingTrust->newHoldingTrust($trust);
    }
    else 
        $objHoldingTrust->updateHoldingTrust($trust);
    
    header('location: existing_trustee.php');
    exit;
}

// fetch holding trustee types
$arrTrusteeType = $objHoldingTrust->fetchTrusteeType();

// include view file
include("view/fund.php");

?>