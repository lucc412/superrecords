<?php
// include common file
include("../../include/common.php");

// include class file
include("model/other_class.php");
$objHoldingTrust = new Other();

$arrInsurancelist = array("1" => "The trustees have considered the members individual insurance requirements and will put in place the required insurance policies.",
                          "2" => "The trustees have in place insurance policies both inside and/or outside of superannuation that currently meet each member’s insurance requirements.",
                          "3" => "Due the age of the member and/or the current cash flow and asset levels of the fund insurance is not applicable."
                    );

// fetch existing data [edit case]
if(!empty($_SESSION['jobId'])) {
    $arrOtherData = $objHoldingTrust->fetchOtherDetails();
    $insDetail = $arrOtherData['insurance_details'];
    $arrInsDetail = stringToArray(',', $insDetail);
}
        
// insert & update case
if(!empty($_REQUEST['saveData'])) {
    $spcObj = $_REQUEST['txtObj'];
    
    foreach($_REQUEST AS $fieldName => $fieldValue) {
        if(strstr($fieldName, "insurance")) {
               $fieldId = str_replace('insurance','',$fieldName);
               $arrInsDetails[] = $fieldId;
        }
    }
    $insDetails = arrayToString(',', $arrInsDetails);
    
    // update other details
    if(!empty($arrOtherData)) {
            $objHoldingTrust->updOtherDetails($spcObj, $insDetails);
    }
    // insert other details
    else {
        $objHoldingTrust->insOtherDetails($spcObj, $insDetails);
    }
    
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
include("view/other.php");

?>