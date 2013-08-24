<?php
include("include/common.php");
if($_REQUEST['a'] == 'logout') {
	unset($_SESSION['PRACTICEID']);
	unset($_SESSION['PRACTICE']);
	header('Location: login.php');
}

// check if event is active or inactive [This will return TRUE or FALSE as per result]
$flagSetLink = getEventStatus('home.php');

if(isset($_SESSION['PRACTICEID'])) {
	header('Location: home.php');
}
else {
	include(VIEW."login.php");
}
?>