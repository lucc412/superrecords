<?php
// include common file
include("../../include/common.php");

// include class file
include("model/trustee_class.php");
$objTrustee = new TRUSTEE();

// set recid in session for Retrieve saved jobs
if(!empty($_REQUEST['recid'])) {
    if(isset($_SESSION['jobId'])) unset($_SESSION['jobId']);
    $_SESSION['jobId'] = $_REQUEST['recid'];
}

// fetch existing data [edit case]
if(!empty($_SESSION['jobId'])) {
    $arrTrusty = $objTrustee->fetchTrustee();
    if($arrTrusty['trusty_type'] == 1) 
        $arrIndvdlTrust = $objTrustee->fetchIndividualTrustDetails();
    if($arrTrusty['trusty_type'] == 2) 
    {
        $arrCorpTrust = $objTrustee->fetchCorpTrustDetails();
        unset($arrTrusty['no_of_members']);
    }
    
}

// insert & update case
if(!empty($_REQUEST['saveData'])) 
{
    
    $trustyDtls = array();
    $trustyDtls['selTrstyType'] = $_REQUEST['selTrstyType'];
    $trustyDtls['selMember'] = $_REQUEST['selMember'];
    
    if(empty($arrTrusty))
        $objTrustee->newTrusty($trustyDtls);
    else 
        $objTrustee->updateTrusty($trustyDtls);
    
    
    if(isset($trustyDtls['selTrstyType']) && $trustyDtls['selTrstyType'] == 1)
    {
        //Reverse Array for deleting member
        krsort($arrIndvdlTrust);

        //Deleting officer id
        $delMember = count($arrIndvdlTrust) - $trustyDtls['selMember'];
        if($delMember > 0) {
            $deleteMemberId = "";
            foreach ($arrIndvdlTrust AS $indvdlInfo) {
                if($delMember > 0) {
                    $deleteMemberId .= $indvdlInfo['indvdl_id'].',';
                    $delMember--;
                }
            }
            $deleteMemberId = stringrtrim($deleteMemberId, ',');
            $objTrustee->deleteIndividual($deleteMemberId);
            $objTrustee->deleteAllCorporate();
        }
        
        //Reverse Array for deleting member
        krsort($arrIndvdlTrust);
        
        for($i = 0; $i < $trustyDtls['selMember']; $i++)
        {
            $FName = $_REQUEST['txtFName'.$i];
            $MName = $_REQUEST['txtMName'.$i];
            $LName = $_REQUEST['txtLName'.$i];
            $ResAdd = $_REQUEST['txtResAdd'.$i];
            $indvdlId = $_REQUEST['indvdlId'.$i];
            
            if(empty($arrIndvdlTrust))
                $objTrustee->insertIndividual($FName, $MName, $LName, $ResAdd);
            else
                $objTrustee->updateIndividual($FName, $MName, $LName, $ResAdd, $indvdlId);
        }
    }  
    else if(isset($trustyDtls['selTrstyType']) && $trustyDtls['selTrstyType'] == 2)
    {
        $trustyDtls['txtCompName'] = $_REQUEST['txtCompName'];
        $trustyDtls['txtAcn'] = $_REQUEST['txtAcn'];
        $trustyDtls['txtAdd'] = $_REQUEST['txtAdd'];
        
        foreach($_REQUEST AS $eleName => $eleValue) 
        {
            if(!empty($eleValue)) if(strstr($eleName, "dir")) $arrDir[] = $eleValue;
        }
        $trustyDtls['directors'] = arrayToString('|', $arrDir);  
        
        $objTrustee->deleteAllIndividual();
        
        if(empty($arrCorpTrust))
            $objTrustee->insertCorporate($trustyDtls);
        else 
            $objTrustee->updateCorporate($trustyDtls);
    }
    
    
    if(isset($_REQUEST['next'])) {
        header('location: pension.php');
        exit;
    }
    else if(isset($_REQUEST['save'])) {
        header('location: ../../jobs_saved.php');
        exit;
    }
}

// include view file
include("view/trustee.php");

?>