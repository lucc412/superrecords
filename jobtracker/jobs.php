<?php
// include common file
include("include/common.php");

// unset session
if(isset($_SESSION['jobId'])) unset($_SESSION['jobId']);

// include view file
include(VIEW.'jobs.php');
?>