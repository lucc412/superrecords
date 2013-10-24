<?php
// include common file
include("include/common.php");

// include class file
include(MODEL."jobs_pending_class.php");
$objScr = new PendingJobs();        

$arrJobs = $objScr->fetch_pending_jobs();
$arrAllReports = $objScr->fetch_reports();
$arrAllDocs = $objScr->fetch_documents();
$arrAllQueryCnt = $objScr->fetch_queries();
$arrClients = getclientlist();

// include view file
include(VIEW.'jobs_pending.php');
?>