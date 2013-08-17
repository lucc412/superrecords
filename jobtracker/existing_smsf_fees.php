<?php

// include common file
include("include/common.php");

if(isset($_SESSION['SIGNUPID'])) {

	// include model file
	include(MODEL . "existing_smsf_fees_class.php");

	// create class object for class function access
	$objScr = new EXISTING_SMSF_FEES();
	$amt = $objScr->setUpFees();
	
	$objScr->insertPaymentInfo($_SESSION['SIGNUPID']);
	
	// include view file 
	session_write_close();//Make Session Read onlu Because Easy Debit make Session restore 
	include(VIEW . "existing_smsf_fees.php");
}
else {
	header('Location: index.php');
}
?>