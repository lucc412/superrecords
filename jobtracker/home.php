<?php
include("include/common.php");
include(MODEL."home_class.php");
$objScr = new Home();
	
if(isset($_REQUEST['txtName']) && isset($_REQUEST['txtPassword'])) {
	$username = $_REQUEST['txtName'];
	$password = $_REQUEST['txtPassword'];

	// function call to check whether user is valid or not
	$practiceId = $objScr->check_valid_practice($username, $password);
	if(isset($_SESSION['PRACTICEID'])) unset($_SESSION['PRACTICEID']);
	$_SESSION['PRACTICEID'] = $practiceId;

	if(!empty($practiceId)) {
		$prName = $objScr->get_Practice_Name();
		if(isset($_SESSION['PRACTICE'])) unset($_SESSION['PRACTICE']);
		$_SESSION['PRACTICE'] = $prName;
		include(VIEW."home.php");
	}
	else {
		// file inclusion for displaying login form with error message
		header('Location: login.php?loginFail=Y');
	}
}
else if(isset($_SESSION['PRACTICEID']) && isset($_SESSION['PRACTICE'])) {
	include(VIEW."home.php");
}
else {
	// file inclusion for displaying login form with error message
	header('Location: login.php?loginFail=Y');
}
?>