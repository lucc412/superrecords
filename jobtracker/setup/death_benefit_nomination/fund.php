<?php
// include common file
include("../../include/common.php");

// include class file
include("model/fund_class.php");
$objFund = new Fund();
//unset($_SESSION['jobId']);
// set recid in session for Retrieve saved jobs
if(!empty($_REQUEST['recid'])) {
    if(isset($_SESSION['jobId'])) unset($_SESSION['jobId']);
    $_SESSION['jobId'] = $_REQUEST['recid'];
}

// fetch existing data [edit case]
if(!empty($_SESSION['jobId'])) {
    $arrFund = $objFund->fetchHoldingTrustDetails();
    if($arrFund['trustee_id'] == '1') $arrIndvdlTrust = $objFund->fetchIndividualTrustDetails();
    if($arrFund['trustee_id'] == '2') $arrDirectors = $objFund->fetchDirectorDetails();
}
        
// insert & update case
if(!empty($_REQUEST['saveData'])) {
	//echo "<pre>";	print_r($_REQUEST);exit;
    $fund = $_REQUEST['txtFund'];
    $trusteeId = $_REQUEST['lstType'];
    $compName = $_REQUEST['txtCompName'];
    $acn = $_REQUEST['txtAcn'];
    $address = $_REQUEST['txtAdd'];
    $cntMember = $_REQUEST['lstMember'];
    $cntDirector = $_REQUEST['lstDirector'];
    
    if($trusteeId == '1') {
        unset($compName);
        unset($acn);
        unset($address); 
        unset($cntDirector);
        $objFund->deleteAllDirector();
    }
    else if($trusteeId == '2') {
        unset($cntMember);
        $objFund->deleteAllIndividual();
    } 

    if(empty($arrFund)) {
        $_SESSION['jobId'] = $objFund->insertNewJob();
        $objFund->updateClientName($fund);
        $objFund->newFundDetails($fund, $trusteeId, $compName, $acn, $address, $cntDirector, $cntMember);
    } 
    else 
        $objFund->updateFundDetails($fund, $trusteeId, $compName, $acn, $address, $cntDirector, $cntMember);
    
    // individual trust, add members info
    if($trusteeId == '1') {
        //Reverse Array for deleting member
        krsort($arrIndvdlTrust);

        //Deleting officer id
        $delMember = count($arrIndvdlTrust) - $cntMember;
        if($delMember > 0) {
            $deleteMemberId = array();
            foreach ($arrIndvdlTrust AS $indvdlInfo) {
                if($delMember > 0) {
                    $deleteMemberId[] = $indvdlInfo['indvdl_id'];
                    $delMember--;
                }
            }
			if(count($deleteMemberId))
            	$objFund->deleteIndividual(implode(",",$deleteMemberId));
        }
        
        //Reverse Array for deleting member
        krsort($arrIndvdlTrust);
    
        for($memberCount=0; $memberCount < $cntMember; $memberCount++) 
        {
            $memberId = $_REQUEST['indvdlId'.$memberCount];
            $trusteeFName = $_REQUEST['txtTrusteeFName' . $memberCount];
			$trusteeMName = $_REQUEST['txtTrusteeMName' . $memberCount];
			$trusteeLName = $_REQUEST['txtTrusteeLName' . $memberCount];
            $resAdd = $_REQUEST['txtResAdd' . $memberCount];
            
            // insert member info of sign up user
            if(empty($memberId)) {
                $objFund->insertIndividual($trusteeFName,$trusteeLName,$trusteeMName, $resAdd);
            }
            else {
                $objFund->updateIndividual($memberId, $trusteeFName,$trusteeLName,$trusteeMName, $resAdd);
            }
        }
    }
    // directors
    else if($trusteeId == '2') {
        //Reverse Array for deleting member
        krsort($arrDirectors);

        //Deleting officer id
        $delDirector = count($arrDirectors) - $cntDirector;
        if($delDirector > 0) {
            $deleteMemberId = array();
            foreach ($arrDirectors AS $indvdlInfo) {
                if($delDirector > 0) {
                    $deleteMemberId[] = $indvdlInfo['d_id'];
                    $delDirector--;
                }
            }
            //$deleteMemberId = stringrtrim($deleteMemberId, ',');
            $objFund->deleteDirector(implode(",",$deleteMemberId));
        }
        
        //Reverse Array for deleting member
        krsort($arrDirectors);
    
        for($memberCount=0; $memberCount < $cntDirector; $memberCount++) 
        {
            $memberId = $_REQUEST['dirId'.$memberCount];
            $dirName = $_REQUEST['txtDirName' . $memberCount];
            $resAdd = $_REQUEST['txtDirAdd' . $memberCount];
            
            // insert member info of sign up user
            if(empty($memberId)) {
                $objFund->insertDirector($dirName, $resAdd);
            }
            else {
                $objFund->updateDirector($memberId, $dirName, $resAdd);
            }
        }
    }
    
    if(isset($_REQUEST['next'])) {
        header('location: nomination.php');
        exit;
    }
    else if(isset($_REQUEST['save'])) {
        header('location: ../../jobs_saved.php');
        exit;
    }
}

// fetch holding trustee types
$arrTrusteeType = $objFund->fetchTrusteeType();

// include view file
include("view/fund.php");

?>