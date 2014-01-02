<?php
// include common file
include("../../include/common.php");

// include class file
include("model/pension_class.php");
$objPension = new PENSION();

//$arrStates = fetchStates();
//$arrCountry = fetchCountries();

// set recid in session for Retrieve saved jobs
if(!empty($_REQUEST['recid'])) 
{
    if(isset($_SESSION['jobId'])) unset($_SESSION['jobId']);
    $_SESSION['jobId'] = $_REQUEST['recid'];
}

// fetch existing data [edit case]
if(!empty($_SESSION['jobId'])) 
{
    $arrPension = $objPension->fetchPensionDetails();
}

// insert & update case
if(!empty($_REQUEST['saveData'])) 
{
    
    $pensionDtls['txtMembrName'] = $_REQUEST['txtMembrName']; 
    $pensionDtls['txtDob'] = getDateFormat($_REQUEST['txtDob']); 
    $pensionDtls['txtComncDt'] = getDateFormat($_REQUEST['txtComncDt']); 
    $pensionDtls['selCondRel'] = $_REQUEST['selCondRel']; 
    $pensionDtls['txtPenAccBal'] = $_REQUEST['txtPenAccBal']; 
    $pensionDtls['txtCurYrPay'] = $_REQUEST['txtCurYrPay']; 
    $pensionDtls['txtTxFrePrcnt'] = $_REQUEST['txtTxFrePrcnt']; 
    $pensionDtls['txtRevPenName'] = $_REQUEST['txtRevPenName']; 
    $pensionDtls['txtRevTnC'] = $_REQUEST['txtRevTnC']; 
    
    if(empty($arrPension)) 
        $objPension->newPensionDetails($pensionDtls);
    else 
        $objPension->updatePensionDetails($pensionDtls);
    
    if(isset($_REQUEST['next'])) {
        header('location: preview.php');
        exit;
    }
    else if(isset($_REQUEST['save'])) {
        header('location: ../../jobs_saved.php');
        exit;
    }
}

// include view file
include("view/pension.php");

?>