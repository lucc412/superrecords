<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */ 

include("../../include/common.php");

//include class file address_details_class.php
include("model/address_details_class.php");
$objAddrDtls = new ADDRESS_DETAILS();

if(!empty($_SESSION['jobId']))
{
    $arrAddrDtls = $objAddrDtls->fetchAddrDtls();
}
if(!empty($_REQUEST['sql']))
{    
    if(empty($arrAddrDtls))
        $objAddrDtls->insertAddrDtls();
    else
        $objAddrDtls->updateAddrDtls();
    
    if(isset($_REQUEST['next'])) {
        header('location: officer_details.php');
        exit;
    }
    else if(isset($_REQUEST['save'])) {
        header('location: ../../jobs_saved.php');
        exit;
    }
}

// fetch states for drop-down
$arrStates = fetchStates();

include("view/address_details.php");
?>
