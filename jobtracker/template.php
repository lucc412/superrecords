<?php
// include common file
include("include/common.php");
include(MODEL."template_class.php");
$objScr = new Template();

// fetch all templates
$arrTemplate = $objScr->fetch_template();

if(isset($_REQUEST['a']) && $_REQUEST['a'] == 'download')
	$objScr->doc_download($_REQUEST['filePath']);

// include view file 
include(VIEW . "template.php");
?>