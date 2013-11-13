<?php

// include common file
include("../../include/common.php");

// include class file
include("model/company_details_class.php");
$objCompDtlls = new COMPANY_DETAILS();



// fetch existing data [edit case]
if(!empty($_SESSION['jobId'])) {
    $arrCompDtls = $objCompDtlls->fetchCompDetails();
}

// insert & update case
if(!empty($_REQUEST['saveData'])) 
{
    if(empty($arrCompDtls)) 
        $objCompDtlls->insertCompDtls();
    else 
        $objCompDtlls->updateCompDtls();        
    
    if(isset($_REQUEST['next'])) 
    {
        header('location: preview.php');
        exit;
    }
    else if(isset($_REQUEST['save'])) 
    {
        header('location: ../../jobs_saved.php');
        exit;
    }
    
}

// Include view file
include("view/company_details.php");

?>
