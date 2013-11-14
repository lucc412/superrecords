<?php
// include common file
include("../../include/common.php");

// include class file
include("model/holding_trust_class.php");
$objHoldingTrust = new Holding_Trust();

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
    $trusteeId = $_REQUEST['lstType'];
    $compName = $_REQUEST['txtCompName'];
    $acn = $_REQUEST['txtAcn'];
    $tfn = $_REQUEST['txtTfn'];
    $address = $_REQUEST['txtAdd'];
    
    // directors
    foreach($_REQUEST AS $eleName => $eleValue) {
        if(!empty($eleValue)) if(strstr($eleName, "dir")) $arrDir[] = $eleValue;
    }
    $directors = arrayToString('|', $arrDir);
    
    if($trusteeId == '1') {
        unset($compName);
        unset($acn);
        unset($tfn);
        unset($address); 
        unset($directors);
    } 

    if(empty($arrHoldTrust)) $objHoldingTrust->newHoldingTrust($trusteeId, $compName, $acn, $tfn, $address, $directors);
    else $objHoldingTrust->updateHoldingTrust($trusteeId, $compName, $acn, $tfn, $address, $directors);
    
    if(isset($_REQUEST['next'])) {
        header('location: member.php');
        exit;
    }
    else if(isset($_REQUEST['save'])) {
        header('location: ../../jobs_saved.php');
        exit;
    }
}

// fetch holding trustee types
$arrTrusteeType = $objHoldingTrust->fetchTrusteeType();

// include view file
include("view/holding_trust.php");

?>