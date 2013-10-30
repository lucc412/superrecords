<?php

// include common file
include("../../include/common.php");

include("model/company_details_class.php");
$objCompDtls = new COMPANY_DETAILS();

$arrCompDtls = '';
if(!empty($_SESSION['jobId']) || !empty($_REQUEST['recid']))
{
    if(!empty($_REQUEST['recid'])) 
    {
        if(isset($_SESSION['jobId'])) unset($_SESSION['jobId']);
            $_SESSION['jobId'] = $_REQUEST['recid'];
    }
    
    $arrCompDtls = $objCompDtls->fetchCompDtls();
}

if(!empty($_REQUEST['flagUpdate']))
{
    if(empty($arrCompDtls))
    {
        //Insert Details to Job
        $_SESSION['jobId'] = $objCompDtls->insertJobDetail();
        $cliName = $_REQUEST['txtCompPref'][0];
        $objCompDtls->updateClientName($cliName);
            
        //Insert Details to Company    
        $objCompDtls->insertCompanyDetails();
    }
    else
    {
        //Update Details to Company    
        $objCompDtls->updateCompanyDetails();             
    }    
    
    if(isset($_REQUEST['next'])) {
        header('location: address_details.php');
        exit;
    }
    else if(isset($_REQUEST['save'])) {
        header('location: ../../jobs_saved.php');
        exit;
    }
}    

// fetch states for drop-down
$arrStates = fetchStates();

include("view/company_details.php"); 

?>