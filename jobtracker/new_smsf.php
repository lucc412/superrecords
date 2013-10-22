<?php
// include common file
include("include/common.php");

include(MODEL . "new_smsf_class.php");
$objNewSmsf = new NEW_SMSF();

// update checkbox case.
if(isset($_SESSION["jobId"]) && $_REQUEST['flagUpdate']=='Y')
{
    $objNewSmsf->updateCheckbox(); 
    header('location: new_smsf_contact.php');
}
// insert Job details
else if(isset($_REQUEST['job_type']) && $_REQUEST['job_type'] == 'SETUP')
{
    // Insert Job Details
    $arrJobReq['lstClientType'] = NULL;
    $arrJobReq['lstJobType'] = 21;
    $arrJobReq['lstCliType'] = 25;
    $arrJobReq['type'] = $_REQUEST['job_type'];
    $arrJobReq['subfrmId'] = $_SESSION['frmId'];
    $arrJobReq['txtPeriod'] = 'Year End 30/06/'. date('Y');
    
    $jobId = insertJobDetails($arrJobReq);
    $objNewSmsf->insertCheckbox($_SESSION['frmId'],$jobId);
    if(isset($_SESSION['jobId'])) unset($_SESSION['jobId']);
        $_SESSION['jobId'] = $jobId;

    header('location: new_smsf_contact.php');
}
//Default Case
else 
{
    if(!empty($_REQUEST['recid'])) 
    {
        if(isset($_SESSION['jobId'])) unset($_SESSION['jobId']);
            $_SESSION['jobId'] = $_REQUEST['recid'];
    }
    
    if(!empty($_REQUEST['frmId'])) 
    {
        if(isset($_SESSION['frmId']))unset($_SESSION['frmId']);
            $_SESSION['frmId'] = $_REQUEST['frmId'];
    }   
    
    if(isset($_SESSION['jobId'])) $arrSMSF = $objNewSmsf->fetchCheckbox();
        
    include(VIEW . "new_smsf.php");
}

?>