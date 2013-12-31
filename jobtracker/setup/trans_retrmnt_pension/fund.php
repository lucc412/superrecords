<?php

// include common file
include("../../include/common.php");

// include class file
include("model/fund_class.php");
$objFund = new Fund();

// set recid in session for Retrieve saved jobs
if(!empty($_REQUEST['recid'])) 
{
    if(isset($_SESSION['jobId'])) unset($_SESSION['jobId']);
    $_SESSION['jobId'] = $_REQUEST['recid'];
}

// fetch existing data [edit case]
if(!empty($_SESSION['jobId'])) 
{
    $arrFund = $objFund->fetchFundDetails();
}

// insert & update case
if(!empty($_REQUEST['saveData'])) 
{
    if(empty($arrFund)) 
    {
        $_SESSION['jobId'] = $objFund->insertNewJob();
        $objFund->updateClientName($_REQUEST['txtFund']);
        $objFund->insertFund();
    }
    else 
    {
        $objFund->updateFund();        
    }
    
    if(isset($_REQUEST['next'])) 
    {
        header('location: trustee.php');
        exit;
    }
    else if(isset($_REQUEST['save'])) 
    {
        header('location: ../../jobs_saved.php');
        exit;
    }
    
}

// fetch states for drop-down
$arrStates = fetchStates();
$arrCountry = fetchCountries();

// Include view file
include("view/fund.php");

?>
