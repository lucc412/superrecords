<?php
// include common file
include("../../include/common.php");

// include class file
include("model/fund_class.php");
$objFund = new Fund();

$arrActionType = array('Removal', 'Retirement', 'Resignation', 'Dismissal');
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
    $actionType = $_REQUEST['selActTyp']; 
    $applCls = $_REQUEST['txtAppCls']; 
    $resgCls = $_REQUEST['txtResgnCls']; 
    
    if(empty($arrFund)) {
        $_SESSION['jobId'] = $objFund->insertNewJob();
        $objFund->updateClientName($fund);
        $objFund->newFund($fund, $unit, $build, $street, $suburb, $state, $postCode, $country, $dtEstblshmnt, $actionType, $applCls, $resgCls);
    }
    else 
        $objFund->updateFund($fund, $unit, $build, $street, $suburb, $state, $postCode, $country, $dtEstblshmnt, $actionType, $applCls, $resgCls);
    
    if(isset($_REQUEST['next'])) {
        header('location: existing_trustee.php');
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