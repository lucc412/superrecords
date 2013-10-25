<?php
include("include/common.php");

include(MODEL."setup_class.php");
$objScr = new SETUP();

$arrForms = $objScr->fetch_setup_forms();
include(VIEW.'setup.php');
?>