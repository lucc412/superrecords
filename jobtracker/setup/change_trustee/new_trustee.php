<?php
// include common file
include("../../include/common.php");

// include class file
include("model/new_trustee_class.php");
$objNewTrustee = new Trust_Fund();

// fetch existing data [edit case]
if(!empty($_SESSION['jobId'])) {
    $arrHoldTrust = $objNewTrustee->fetchNewTrusteeDetails();
    if($arrHoldTrust['trustee_id'] == '1') $arrIndvdlTrust = $objNewTrustee->fetchIndividualTrustDetails();
}
        
// insert & update case
if(!empty($_REQUEST['saveData'])) {
    $trusteeId = $_REQUEST['lstType'];
    $compName = $_REQUEST['txtCompName'];
    $acn = $_REQUEST['txtAcn'];
    $tfn = $_REQUEST['txtTfn'];
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
        unset($tfn);
        unset($address); 
        unset($directors);
    }
    else if($trusteeId == '2') {
        unset($cntMember);
        $objNewTrustee->deleteAllIndividual();
    } 

    if(empty($arrHoldTrust)) {
        $objNewTrustee->addNewTrustee($trusteeId, $compName, $acn, $tfn, $address, $directors, $cntMember);
    } 
    else 
        $objNewTrustee->updateNewTrustee($trusteeId, $compName, $acn, $tfn, $address, $directors, $cntMember);
    
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
            $objNewTrustee->deleteIndividual($deleteMemberId);
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
                $objNewTrustee->insertIndividual($trusteeName, $resAdd);
            }
            else {
                $objNewTrustee->updateIndividual($memberId, $trusteeName, $resAdd);
            }
        }
    }
    
    if(isset($_REQUEST['next'])) {
        header('location: member.php');
        exit;
    }
    else if(isset($_REQUEST['save'])) {
        header('location: ../../jobs_saved.php');
        exit;
    }
}

// fetch holding trustee types
$arrTrusteeType = $objNewTrustee->fetchTrusteeType();

// include view file
include("view/new_trustee.php");

?>