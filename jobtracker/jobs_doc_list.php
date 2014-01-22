<?php
include("include/common.php");
include(MODEL."jobs_doc_list_class.php");
$objScr = new DOCUMENT();

$arrjobs = $objScr->fetchJobs();
$arrAllDocs = $objScr->fetch_documents();
$arrClients = getclientlist();
include(VIEW.'jobs_doc_list.php');
?>