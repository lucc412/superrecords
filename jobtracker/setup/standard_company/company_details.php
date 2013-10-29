<?php

// include common file
include("../../include/common.php");

include("model/company_details_class.php");
$objCompDtls = new COMPANY_DETAILS();
// fetch existing company details from database.
//$_SESSION['jobId'] = 198;


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

if(!empty($_REQUEST['btnNext']) && $_REQUEST['btnNext'] == 'submit')
{
    
    showArray($arrCompDtls);
    
    
    if(empty($arrCompDtls))
    {
        
        //Insert Details to Job
        $jobId = $objCompDtls->insertJobDetail();
        if(isset($_SESSION['jobId'])) unset($_SESSION['jobId']);
            $_SESSION['jobId'] = $jobId;
            
        //Insert Details to Company    
        $result = $objCompDtls->insertCompanyDetails();
        
    }
    else
    {
        //Update Details to Company    
        $result = $objCompDtls->updateCompanyDetails();             
    }    
    
    if($result)
        header('location:address_details.php');
}    

//if(!empty($_REQUEST['recid'])) 
//{
//    if(isset($_SESSION['jobId'])) unset($_SESSION['jobId']);
//        $_SESSION['jobId'] = $_REQUEST['recid'];
//}


if(!empty($_REQUEST['frmId'])) 
{
    if(isset($_SESSION['frmId']))unset($_SESSION['frmId']);
        $_SESSION['frmId'] = $_REQUEST['frmId'];
}   

// fetch states for drop-down
$arrStates = fetchStates();

include("view/company_details.php"); 

?>