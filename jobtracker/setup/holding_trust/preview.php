<?php
// include common file
include("../../include/common.php");

// include class file
include("model/preview_class.php");
$objPreview = new Preview();

$html = $objPreview->generatePreview();

// include view file
include("view/preview.php");

?>