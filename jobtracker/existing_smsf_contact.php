<?php

	// include common file
	include("include/common.php");

	// include model file
	include(MODEL . "existing_smsf_contact_class.php");

	// create class object for class function access
	$objScr = new EXISTING_SMSF_CONTACT();

	// fetch data is available 
	if(isset($_SESSION['jobId']) && !empty($_SESSION['jobId'])) {

		// fetch existing contact details
		$arrData = $objScr->fetchExistingDetails($_SESSION['jobId']);
	}
	
	// check referral Code
//	if(isset($_POST['flaginit']) && $_POST['flaginit'] == 'Y'){
//		
//		if(isset($_POST['txtCode']) && !empty($_POST['txtCode'])){
		
//			$codeStatus = $objScr->checkIfCodeExists($_POST['txtCode']);
//			
//			if($codeStatus)
//			{
//				$flagInsert = TRUE;
//			}
//			else{
//				$flaginvalid = TRUE;
//			}
//                    $flagInsert = TRUE;
//			
//		}	
		
//	}elseif(isset($_POST['flaginit']) && $_POST['flaginit'] == 'N'){
//		if(isset($_SESSION['EXST_REFCODE'])) unset($_SESSION['EXST_REFCODE']);
//		$flagInsert = TRUE;
//	}

	// case when next button is clicked
	if(isset($_POST['flaginit']) && $_POST['flaginit'] =='add') {
		
		$fname = $_REQUEST['txtFname'];
		$lname = $_REQUEST['txtLname'];
		$email = $_REQUEST['txtEmail'];
		$phone = $_REQUEST['txtPhone'];
		$stateId = $_REQUEST['lstState'];
		$contStatus = $_REQUEST['cont_status'];

		// fetch existing contact details
		$arrData = $objScr->fetchExistingDetails($_SESSION['jobId']);

		// insert contact details of sign up user
		if(empty($arrData)) {
			$lastInsertId = $objScr->addContactDetails($fname, $lname, $email, $phone, $stateId, $contStatus);

			if(!empty($lastInsertId)) {

				//set sign up id in session variable
//				if(isset($_SESSION['SIGNUPID'])) unset($_SESSION['SIGNUPID']);				
//				$_SESSION['SIGNUPID'] = $lastInsertId;
//				$_COOKIE['PHPSESSID']['SIGNUPID']=$lastInsertId;
			}
		}
		// update contact details of sign up user
		else {
			$flagUpdate = $objScr->editContactDetails($fname, $lname, $email, $phone, $stateId, $contStatus);
		}		

		if(!empty($lastInsertId) || $flagUpdate) {
			
                    if(isset($_POST['cont_status']) && $_POST['cont_status'] == 1)
                        header('Location: jobs.php?a=saved');
                    else
                        header('Location: existing_smsf_fund.php');
		}
		else {
			echo "Sorry, Please try later.";
		}
	}

	// if data is already entered for current session then set variables
	if(isset($arrData) && !empty($arrData)) {
		$fname = $arrData['fname'];
		$lname = $arrData['lname'];
		$email = $arrData['email'];
		$phoneno = $arrData['phoneno'];
		$stateId = $arrData['state_id'];
		$refCode = $arrData['referral_code'];
	}
	// declare variables
	if(isset($_REQUEST['txtFname'])){
		$fname = $_REQUEST['txtFname'];
	}
	else if(!empty($arrData['fname'])) {
		$fname = $arrData['fname'];
	}
	else {
		$fname = "";
	}
	
	if(isset($_REQUEST['txtLname'])){
		$lname = $_REQUEST['txtLname'];
	}
	else if(!empty($arrData['lname'])) {
		$lname = $arrData['lname'];
	}
	else {
		$lname = "";
	}
	
	if(isset($_REQUEST['txtEmail'])){
		$email = $_REQUEST['txtEmail'];
	}
	else if(!empty($arrData['email'])) {
		$email = $arrData['email'];
	}
	else {
		$email = "";
	}
	
	if(isset($_REQUEST['txtPhone'])){
		$phoneno = $_REQUEST['txtPhone'];
	}
	else if(!empty($arrData['phoneno'])) {
		$phoneno = $arrData['phoneno'];
	}
	else {
		$phoneno = "";
	}
	
	if(isset($_REQUEST['lstState'])){
		$stateId = $_REQUEST['lstState'];
	}
	else if(!empty($arrData['state_id'])) {
		$stateId = $arrData['state_id'];
	}
	else {
		$stateId = "";
	}
	
	
	// fetch states for drop-down
	$arrStates = $objScr->fetchStates();

	// include view file 
	include(VIEW . "existing_smsf_contact.php");

?>