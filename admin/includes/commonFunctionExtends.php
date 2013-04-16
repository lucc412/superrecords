<?php

/* This case is used to reset session of filters & order */

$crntURL = BASENAME($_SERVER['PHP_SELF']);
if(!isset($_SESSION['URL']))$_SESSION['URL'] = $crntURL;

if(strcasecmp($_SESSION['URL'],$crntURL) != 0) {
	unset($_SESSION["filter"]);
	unset($_SESSION["filter_field"]);
	unset($_SESSION["order"]);
	unset($_SESSION["type"]);
	$_SESSION['URL'] = $crntURL; 
}

?>