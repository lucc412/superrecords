<?php
// include common file
include("../../include/common.php");

// include class file
include("model/holding_trust_class.php");
$objHoldingTrust = new Holding_Trust();

// set recid in session for Retrieve saved jobs
if(!empty($_REQUEST['recid'])) {
    if(isset($_SESSION['jobId'])) unset($_SESSION['jobId']);
    $_SESSION['jobId'] = $_REQUEST['recid'];
}

// fetch existing data [edit case]
if(!empty($_SESSION['jobId'])) {
    $arrHoldTrust = $objHoldingTrust->fetchHoldingTrustDetails();
    if($arrHoldTrust['trustee_id'] == '1') $arrIndvdlTrust = $objHoldingTrust->fetchIndividualTrustDetails();
}

// insert & update case
if(!empty($_REQUEST['saveData'])) {
    $trusteeId = $_REQUEST['lstType'];
    $compName = $_REQUEST['txtCompName'];
    $acn = $_REQUEST['txtAcn'];
    $address = $_REQUEST['txtAdd'];
    $cntMember = $_REQUEST['lstMember'];
    
    // directors
    foreach($_REQUEST AS $eleName => $eleValue) {
        if(!empty($eleValue)) if(strstr($eleName, "dir")) $arrDir[] = $eleValue;
    }
    $directors = arrayToString('|', $arrDir);
    
    if($trusteeId == '1') {
        unset($compName);
        unset($acn);
        unset($address); 
        unset($directors);
    }
    else if($trusteeId == '2') {
        unset($cntMember);
        $objHoldingTrust->deleteAllIndividual();
    } 

    if(empty($arrHoldTrust)) $objHoldingTrust->newHoldingTrust($trusteeId, $compName, $acn, $address, $directors, $cntMember);
    else $objHoldingTrust->updateHoldingTrust($trusteeId, $compName, $acn, $address, $directors, $cntMember);
    
    // individual trust, add members info
    if($trusteeId == '1') {
        //Reverse Array for deleting member
        krsort($arrIndvdlTrust);

        //Deleting officer id
        $delMember = count($arrIndvdlTrust) - $cntMember;
        if($delMember > 0) {
            $deleteMemberId = "";
            foreach ($arrIndvdlTrust AS $indvdlInfo) {
                if($delMember > 0) {
                    $deleteMemberId .= $indvdlInfo['indvdl_id'].',';
                    $delMember--;
                }
            }
            $deleteMemberId = stringrtrim($deleteMemberId, ',');
            $objHoldingTrust->deleteIndividual($deleteMemberId);
        }
        
        //Reverse Array for deleting member
        krsort($arrIndvdlTrust);
    
        for($memberCount=0; $memberCount < $cntMember; $memberCount++) 
        {
            $memberId = $_REQUEST['indvdlId'.$memberCount];
            $trusteeName = $_REQUEST['txtTrusteeName' . $memberCount];
            $resAdd = $_REQUEST['txtResAdd' . $memberCount];
            
            // insert member info of sign up user
            if(empty($memberId)) {
                $objHoldingTrust->insertIndividual($trusteeName, $resAdd);
            }
            else {
                $objHoldingTrust->updateIndividual($memberId, $trusteeName, $resAdd);
            }
        }
    }
    
    header('location: trust_fund.php');
    exit;
}

// fetch holding trustee types
$arrTrusteeType = $objHoldingTrust->fetchTrusteeType();

// include view file
include("view/holding_trust.php");

?>