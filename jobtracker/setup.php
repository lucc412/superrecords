<?php
include("include/common.php");

include(MODEL."setup_class.php");
$objScr = new SETUP();

// unset job id 
if(isset($_SESSION['jobId'])) unset($_SESSION['jobId']);

$arrForms = $objScr->fetch_setup_forms();
include(VIEW.'setup.php');
?>