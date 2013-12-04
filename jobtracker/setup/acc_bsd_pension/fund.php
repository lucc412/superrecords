<?php
// include common file
include("../../include/common.php");

// include class file
include("model/change_fund_class.php");
$objChangeFnd = new CHANGE_FUND();

$arrStates = fetchStates();
$arrCountry = fetchCountries();

// set recid in session for Retrieve saved jobs
if(!empty($_REQUEST['recid'])) {
    if(isset($_SESSION['jobId'])) unset($_SESSION['jobId']);
    $_SESSION['jobId'] = $_REQUEST['recid'];
}

// fetch existing data [edit case]
if(!empty($_SESSION['jobId'])) {
    $arrFund = $objChangeFnd->fetchFundDetails();
}

// insert & update case
if(!empty($_REQUEST['saveData'])) 
{
    $fundDtls['txtExtFund'] = $_REQUEST['txtExtFund']; 
    $fundDtls['txtNewFund'] = $_REQUEST['txtNewFund']; 
    $fundDtls['metAddUnit'] = $_REQUEST['metAddUnit']; 
    $fundDtls['metAddBuild'] = $_REQUEST['metAddBuild']; 
    $fundDtls['metAddStreet'] = $_REQUEST['metAddStreet']; 
    $fundDtls['metAddSubrb'] = $_REQUEST['metAddSubrb']; 
    $fundDtls['metAddState'] = $_REQUEST['metAddState']; 
    $fundDtls['metAddPstCode'] = $_REQUEST['metAddPstCode']; 
    $fundDtls['metAddCntry'] = $_REQUEST['metAddCntry']; 
    
    if(empty($arrFund)) {
        $_SESSION['jobId'] = $objChangeFnd->insertNewJob();
        $objChangeFnd->updateClientName($fundDtls['txtNewFund']);
        $objChangeFnd->newFundName($fundDtls);
    }
    else 
        $objChangeFnd->updateFundName($fundDtls);
    
    if(isset($_REQUEST['next'])) {
        header('location: trustee.php');
        exit;
    }
    else if(isset($_REQUEST['save'])) {
        header('location: ../../jobs_saved.php');
        exit;
    }
}

// include view file
include("view/change_fund.php");

?>