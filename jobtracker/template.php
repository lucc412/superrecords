<?php
// include common file
include("include/common.php");
include(MODEL."template_class.php");
$objScr = new Template();

// fetch all templates
$arrTemplate = $objScr->fetch_template();

// include view file 
include(VIEW . "template.php");
?>