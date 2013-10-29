<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */ 

include("../../include/common.php");

//include class file address_details_class.php
include("model/address_details_class.php");
$objAddrDtls = new ADDRESS_DETAILS();

$arrAddrDtls = '';

if(!empty($_SESSION['jobId']))
{
    $arrAddrDtls = $objAddrDtls->fetchAddrDtls();
}
if(!empty($_REQUEST['sql']) && ($_REQUEST['sql'] == 'Add' || $_REQUEST['sql'] == 'Save'))
{    
    if(empty($arrAddrDtls))
        $objAddrDtls->insertAddrDtls();
    else
        $objAddrDtls->updateAddrDtls();
        
    if($_REQUEST['sql'] == 'Add')
        header('location:officer_details.php'); 
    else if($_REQUEST['sql'] == 'Save')
        header('Location: jobs_saved.php');
    
}

// fetch states for drop-down
$arrStates = fetchStates();

include("view/address_details.php");
?>
