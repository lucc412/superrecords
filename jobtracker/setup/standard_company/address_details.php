<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */ 

include("../../include/common.php");

if(!empty($_REQUEST['sql']) && $_REQUEST['sql'] == 'Add')
{
    include("model/address_details_class.php");
    $objAddrDtls = new ADDRESS_DETAILS();
    
    $objAddrDtls->insertAddrDtls();
    header('location:officer_details.php');
    
}
// fetch states for drop-down
$arrStates = fetchStates();

include("view/address_details.php");
?>
