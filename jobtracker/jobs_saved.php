<?php
// include common file
include("include/common.php");

// include class file
include(MODEL."jobs_saved_class.php");
$objScr = new SavedJobs(); 

if(isset($_SESSION['jobId'])) unset($_SESSION['jobId']);
$arrJobs = $objScr->fetch_saved_jobs();
$arrClients = getclientlist();

// include view file
include(VIEW.'jobs_saved.php');
?>