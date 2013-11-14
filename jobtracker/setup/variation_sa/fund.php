<?php
// include common file
include("../../include/common.php");

// include class file
include("model/fund_class.php");
$objFund = new Fund();

$arrStates = fetchStates();
$arrCountry = fetchCountries();

// set recid in session for Retrieve saved jobs
if(!empty($_REQUEST['recid'])) {
    if(isset($_SESSION['jobId'])) unset($_SESSION['jobId']);
    $_SESSION['jobId'] = $_REQUEST['recid'];
}

// fetch existing data [edit case]
if(!empty($_SESSION['jobId'])) {
    $arrFund = $objFund->fetchFundDetails();
}

// insert & update case
if(!empty($_REQUEST['saveData'])) {
    
    $fund = $_REQUEST['txtFund']; 
    $unit = $_REQUEST['metAddUnit']; 
    $build = $_REQUEST['metAddBuild']; 
    $street = $_REQUEST['metAddStreet']; 
    $suburb = $_REQUEST['metAddSubrb']; 
    $state = $_REQUEST['metAddState']; 
    $postCode = $_REQUEST['metAddPstCode']; 
    $country = $_REQUEST['metAddCntry']; 
    $dtEstblshmnt = getDateFormat($_REQUEST['txtDtEstblshmnt']); 
    $dtVariation = getDateFormat($_REQUEST['txtDtVariation']); 
    $varCls = $_REQUEST['txtVarCls']; 
    
    if(empty($arrFund)) {
        $_SESSION['jobId'] = $objFund->insertNewJob();
        $objFund->updateClientName($fund);
        $objFund->newFund($fund, $unit, $build, $street, $suburb, $state, $postCode, $country, $dtEstblshmnt, $dtVariation, $varCls);
    }
    else 
        $objFund->updateFund($fund, $unit, $build, $street, $suburb, $state, $postCode, $country, $dtEstblshmnt, $dtVariation, $varCls);
    
    if(isset($_REQUEST['next'])) {
        header('location: holding_trust.php');
        exit;
    }
    else if(isset($_REQUEST['save'])) {
        header('location: ../../jobs_saved.php');
        exit;
    }
}

// include view file
include("view/fund.php");

?>