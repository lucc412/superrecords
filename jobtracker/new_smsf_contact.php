<?php

// include common file
include("include/common.php");

// include model file
include(MODEL . "new_smsf_contact_class.php");

// create class object for class function access
$objScr = new NEW_SMSF_CONTACT();

if(isset($_POST['flaginit']) && $_POST['flaginit'] =='add') {
	
	$fname = $_REQUEST['txtFname'];
	$lname = $_REQUEST['txtLname'];
	$email = $_REQUEST['txtEmail'];
	$phone = $_REQUEST['txtPhone'];
	//$stateId = $_REQUEST['lstState'];
	$contStatus = $_REQUEST['cont_status'];

	// fetch existing trustee data
	$arrData = $objScr->fetchExistingDetails($_SESSION['jobId']);
	
	// insert contact details of sign up user
	if(empty($arrData)) {
            $lastInsertId = $objScr->addContactDetails($fname, $lname, $email, $phone, $contStatus);
	}
	// edit contact details of sign up user
	else {
            $flagReturn = $objScr->editContactDetails($fname, $lname, $email, $phone, $contStatus);
	}

	if(!empty($lastInsertId) || $flagReturn) 
        {
            if(isset($_POST['cont_status']) && $_POST['cont_status'] == 1)
            {
                if(isset($_SESSION['jobId']))unset($_SESSION['jobId']);
                header('Location: jobs_saved.php');
            }
            else    
		header('Location: new_smsf_fund.php');
	}
	else {
		echo "Sorry, Please try later.";
	}
}

// fetch data is available 
if(isset($_SESSION['jobId']) && !empty($_SESSION['jobId'])) 
{
    // fetch existing contact details
    $arrData = $objScr->fetchExistingDetails($_SESSION['jobId']);
}

// declare variables
if(isset($_REQUEST['txtFname'])) 
{
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

// include view file
include(VIEW . "new_smsf_contact.php");
?>