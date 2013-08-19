<?php

// include common file
include("include/common.php");

// include model file
include(MODEL . "new_smsf_contact_class.php");

// create class object for class function access
$objScr = new NEW_SMSF_CONTACT();

// fetch states for drop-down
//$arrStates = $objScr->fetchStates();
$arrStates = fetchStates();

// check referral Code
if(isset($_POST['flaginit']) && $_POST['flaginit'] == 'Y') {
	if(isset($_POST['txtCode']) && !empty($_POST['txtCode'])) {
//		$codeStatus = $objScr->checkIfCodeExists($_POST['txtCode']);
//		if($codeStatus) {
//			$flagInsert = TRUE;
//		}
//		else{
//			$flaginvalid = TRUE;
//		}
            $flagInsert = TRUE;
	}
}
else if(isset($_POST['flaginit']) && $_POST['flaginit'] == 'N') {
	if(isset($_SESSION['NEW_REFCODE'])) unset($_SESSION['NEW_REFCODE']);
	$flagInsert = TRUE;
}

if(isset($flagInsert) && $flagInsert === TRUE) {
	
	$fname = $_REQUEST['txtFname'];
	$lname = $_REQUEST['txtLname'];
	$email = $_REQUEST['txtEmail'];
	$phone = $_REQUEST['txtPhone'];
	$stateId = $_REQUEST['lstState'];
	$refCode = $_REQUEST['txtCode'];
        $contStatus = $_REQUEST['cont_status'];

	// fetch existing trustee data
	$arrData = $objScr->fetchExistingDetails($_SESSION['jobId']);
	
	// insert contact details of sign up user
	if(empty($arrData)) {
		$lastInsertId = $objScr->addContactDetails($fname, $lname, $email, $phone, $stateId, $refCode, $contStatus);

		//set sign up id in session variable
//		if(!empty($lastInsertId)) {
//			if(isset($_SESSION['jobId'])) unset($_SESSION['jobId']);
//			$_SESSION['jobId'] = $lastInsertId;
//		}
	}
	// edit contact details of sign up user
	else {
		$flagReturn = $objScr->editContactDetails($fname, $lname, $email, $phone, $stateId, $refCode, $contStatus);
	}

	if(!empty($lastInsertId) || $flagReturn) {
            if(isset($_POST['cont_status']) && $_POST['cont_status'] == 1)
                header('Location: jobs.php?a=saved');
            else    
		header('Location: new_smsf_fund.php');
	}
	else {
		echo "Sorry, Please try later.";
	}
}

// fetch data is available 
if(isset($_SESSION['jobId']) && !empty($_SESSION['jobId'])) {

	// fetch existing contact details
	$arrData = $objScr->fetchExistingDetails($_SESSION['jobId']);
}

// declare variables
if(isset($_REQUEST['txtFname'])) {
	$fname = $_REQUEST['txtFname'];
}
else if(!empty($arrData['fname'])) {
	$fname = $arrData['fname'];
}
else {
	$fname = "";
}

if(isset($_REQUEST['txtLname'])) {
	$lname = $_REQUEST['txtLname'];
}
else if(!empty($arrData['lname'])) {
	$lname = $arrData['lname'];
}
else {
	$lname = "";
}

if(isset($_REQUEST['txtEmail'])) {
	$email = $_REQUEST['txtEmail'];
}
else if(!empty($arrData['email'])) {
	$email = $arrData['email'];
}
else {
	$email = "";
}

if(isset($_REQUEST['txtPhone'])) {
	$phoneno = $_REQUEST['txtPhone'];
}
else if(!empty($arrData['phoneno'])) {
	$phoneno = $arrData['phoneno'];
}
else {
	$phoneno = "";
}

if(isset($_REQUEST['lstState'])) {
	$stateId = $_REQUEST['lstState'];
}
else if(!empty($arrData['state_id'])) {
	$stateId = $arrData['state_id'];
}
else {
	$stateId = "";
}

if(isset($_REQUEST['txtCode'])) {
	$referralCode = $_REQUEST['txtCode'];
}
else if(!empty($arrData['referral_code'])) {
	$referralCode = $arrData['referral_code'];
}
else {
	$referralCode = "";
}

// include view file
include(VIEW . "new_smsf_contact.php");
?>