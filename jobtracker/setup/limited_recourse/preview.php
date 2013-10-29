<?php
// include common file
include("../../include/common.php");

// include class file
include("model/preview_class.php");
$objPreview = new Preview();

$html = $objPreview->generatePreview();

if(isset($_REQUEST['submit'])) {
    $objPreview->generatePdf($html);
    header("Location: ../../jobs_pending.php");
}

// include view file
include("view/preview.php");

?>