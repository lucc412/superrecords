<?php
// include common file
include("include/common.php");

// include class file
include(MODEL."jobs_completed_class.php");
$objScr = new CompletedJobs();        

$arrJobs = $objScr->fetch_completed_jobs();
$arrAllReports = $objScr->fetch_reports();
$arrAllDocs = $objScr->fetch_documents();
$arrAllQueryCnt = $objScr->fetch_queries();
$arrClients = getclientlist();

// include view file
include(VIEW.'jobs_completed.php');
?>