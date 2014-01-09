<?php
// include common file
include("../../include/common.php");

// include class file
include("model/nomination_class.php");
$objNomination = new Nomination();
//unset($_SESSION['jobId']);
// set recid in session for Retrieve saved jobs
if(!empty($_REQUEST['recid'])) {
    if(isset($_SESSION['jobId'])) unset($_SESSION['jobId']);
    $_SESSION['jobId'] = $_REQUEST['recid'];
}

// fetch existing data [edit case]
if(!empty($_SESSION['jobId'])) {
    $arrNomination = $objNomination->fetchNominationDetails();
    $arrNominationBref = $objNomination->fetchNominationBref();    
}
        
// insert & update case
if(!empty($_REQUEST['saveData'])) {
	//echo "<pre>";	print_r($_REQUEST);//exit;
    $name = $_REQUEST['txtName'];
    $address = $_REQUEST['txtAdd'];
    $dob = getDateFormat($_REQUEST['txtDob']);
    $beneficiaries = $_REQUEST['beneficiaries'];
    
    if(empty($arrNomination)) {
        $objNomination->newNominationDetails($name, $address, $dob, $beneficiaries);
    } 
    else 
        $objNomination->updateNominationDetails($name, $address, $dob, $beneficiaries);
    
	//Reverse Array for deleting member
	krsort($arrNominationBref);

	//Deleting officer id
	$delMember = count($arrNominationBref) - $beneficiaries;
    if($delMember > 0) {
        $deleteMemberId = array();
        foreach ($arrNominationBref AS $indvdlInfo) {
            if($delMember > 0) {
                $deleteMemberId[] = $indvdlInfo['benef_id'];
                $delMember--;
            }
        }
		if(count($deleteMemberId))
        	$objNomination->deletebenef(implode(",",$deleteMemberId));
    }
        
    //Reverse Array for deleting member
    krsort($arrNominationBref);

    for($memberCount=0; $memberCount < $beneficiaries; $memberCount++) 
    {
        $benef_id = $_REQUEST['benef_id'.$memberCount];
        $name = $_REQUEST['txtName' . $memberCount];
		$dob = getDateFormat($_REQUEST['txtDob' . $memberCount]);
		$address = $_REQUEST['txtAdd' . $memberCount];
        $relationship = $_REQUEST['txtRelationship' . $memberCount];
		$portion = $_REQUEST['txtportion' . $memberCount];
        
        // insert member info of sign up user
        if(empty($benef_id)) {
            $objNomination->insertbenef($name,$dob,$address, $relationship, $portion);
        }
        else {
            $objNomination->updatebenef($benef_id, $name,$dob,$address, $relationship, $portion);
        }
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
include("view/nomination.php");

?>