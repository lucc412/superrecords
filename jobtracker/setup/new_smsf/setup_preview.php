<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

// include common file
include("../../include/common.php");

include(MODEL . "setup_preview_class.php");
$objStpPrvw = new SETUP_PREVIEW();

$html = $objStpPrvw->generatePreview();
include("view/setup_preview.php");
?>